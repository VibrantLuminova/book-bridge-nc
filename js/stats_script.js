// Add an EventListener to make sure stats.php loads first
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([35.5, -79.8], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 15,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Create info box
    const info = L.control();
    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info-box');
        this.update();
        return this._div;
    };

    // Update the info box dynamically (when hovering)
    info.update = function (props) {
        if (!props) {
            this._div.innerHTML = 'Hover to view stats';
            return;
        }

        this._div.innerHTML = `
            <strong>${props.County}</strong><br>
            <div style="display: flex; gap: 30px; min-width: 320px;">
                <div>
                    Population (2017): ${Number(props.POP).toLocaleString()}<br>
                    Below Level 1 Literacy: ${(props.Lit_P1 * 100).toFixed(1)}%<br>
                    Level 2 Literacy: ${(props.Lit_P2 * 100).toFixed(1)}%<br>
                    Level 3 Literacy: ${(props.Lit_P3 * 100).toFixed(1)}%<br>
                    Average Literacy Score: ${props.Lit_A}<br>
                    Limited English Proficiency: ${(props.Eng_not_well * 100).toFixed(1)}%<br>
    
                </div>
                <div>
                    Less than High School: ${(props.Less_HS * 100).toFixed(1)}%<br>
                    High School Graduate: ${(props.HS * 100).toFixed(1)}%<br>
                    More than High School: ${(props.More_HS * 100).toFixed(1)}%<br>
                    Poverty Rate 100%: ${(props.Poverty_100 * 100).toFixed(1)}%<br>
                    Poverty Rate 150%: ${(props.Poverty_150 * 100).toFixed(1)}%<br>
                    SNAP Participation: ${(props.SNAP * 100).toFixed(1)}%<br>
                </div>
            </div>
        `;
    };

    info.addTo(map);

    // Create a constant to hold breakpoints for all variables, and store fetched data globally
    const breakpoints = {};
    let geojson;
    let geojsonData;

    // Select colors to distinguish between breakpoints
    function getColor(d, variable) {
        const bp = breakpoints[variable];
        return d > bp[4] ? '#800026' :
            d > bp[3] ? '#cf0305' :
                d > bp[2] ? '#ff4f2b' :
                    d > bp[1] ? '#ff8a35' :
                        '#ffe980';
    }

    // Specify styles for the color overlays
    function style(feature) {
        const selectedVar = document.getElementById('variableSelect').value;
        const value = feature.properties[selectedVar];
        return {
            fillColor: getColor(value, selectedVar),
            weight: 1,
            opacity: 1,
            color: '#999',
            fillOpacity: 0.65
        };
    }

    // Specify style changes when hovering over a county (border & fill)
    function highlightFeature(e) {
        const layer = e.target;
        layer.setStyle({
            weight: 3,
            color: '#333',
            fillOpacity: 0.85
        });
        info.update(layer.feature.properties);
    }

    // Revert the hovered area when the mouse moves away
    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
    }

    // Assign what happens on mouseover and mouseout
    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight
        });
    }

    // Set up the Legend
    const legend = L.control({ position: 'bottomright' });

    legend.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'info legend');
        const selectedVar = document.getElementById('variableSelect').value;
        const bp = breakpoints[selectedVar];

        const percentVars = ["Lit_P1", "Lit_P2", "Lit_P3", "Less_HS", "HS", "More_HS", "Eng_not_well", "Poverty_100", "Poverty_150", "SNAP"];
        const isPercent = percentVars.includes(selectedVar);

        div.innerHTML = '';

        if (!bp || bp.length < 2) {
            div.innerHTML = 'No data';
            return div;
        }

        // Algorithm to determine the breakpoints
        for (let i = 0; i < bp.length - 1; i++) {
            const from = bp[i];
            const to = bp[i + 1] - (isPercent ? 0.0001 : 1);  // avoid overlapping

            // Create the label
            let label;
            if (isPercent) {
                label = `${Math.round(from * 100)}%–${Math.round(to * 100)}%`;
            } else {
                label = `${Math.round(from).toLocaleString()}–${Math.round(to).toLocaleString()}`;
            }

            div.innerHTML +=
                `<i style="background:${getColor(from + 0.0001, selectedVar)}"></i> ${label}<br>`;
        }

        // Final range (last breakpoint and above)
        const lastFrom = bp[bp.length - 1];
        const label = isPercent
            ? `${Math.round(lastFrom * 100)}%+`
            : `${Math.round(lastFrom).toLocaleString()}+`;

        div.innerHTML +=
            `<i style="background:${getColor(lastFrom + 0.0001, selectedVar)}"></i> ${label}`;

        return div;
    };


    // Calculate breakpoints for all variables
    function calculateAllBreakpoints() {
        const variables = [
            "Lit_P1", "Lit_P2", "Lit_P3", "Lit_A", "POP", "Less_HS", "HS",
            "More_HS", "Eng_not_well", "Poverty_100", "Poverty_150", "SNAP"
        ];

        variables.forEach(variable => {
            const values = geojsonData.features
                .map(f => f.properties[variable])
                .filter(v => v !== null && v !== undefined)
                .sort((a, b) => a - b);

            if (values.length > 0) {
                if (variable === "POP") {
                    const fixedBreaks = [4000, 10000]; // First breakpoint

                    // Filter values between 10,000 and 1,000,000 for mid breakpoints
                    const midValues = values.filter(v => v > 10000 && v < 1000000);
                    const step = Math.floor(midValues.length / 3);

                    let midBreaks = [];
                    for (let i = 1; i <= 2; i++) {
                        let val = midValues[Math.min(i * step, midValues.length - 1)];

                        // Round based on size
                        if (val < 200000) {
                            val = Math.floor(val / 5000) * 5000;
                        } else {
                            val = Math.floor(val / 50000) * 50000;
                        }

                        midBreaks.push(val);
                    }

                    // Final breakpoints: [4000, 10000, X, Y, 1000000]
                    const finalBreaks = [...fixedBreaks, ...midBreaks, 1000000];
                    breakpoints[variable] = finalBreaks;
                } else {
                    const step = Math.floor(values.length / 5);
                    const linearBreaks = [];
                    for (let i = 0; i < 5; i++) {
                        linearBreaks.push(values[Math.min(i * step, values.length - 1)]);
                    }
                    breakpoints[variable] = linearBreaks;
                }
            }
        });
    }


    // Fetch and load GeoJSON
    fetch('/bookbridgenc/data/merge_literacy_data.php')
        .then(res => res.json())
        .then(data => {
            geojsonData = data;

            calculateAllBreakpoints();

            geojson = L.geoJson(data, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);

            const bounds = geojson.getBounds();
            const paddedBounds = bounds.pad(0.1);
            map.fitBounds(paddedBounds);
            map.setMaxBounds(paddedBounds);
            map.setMinZoom(map.getZoom() + 0.75); // adjust the zoom specified in line 3 (6 + 0.75 = 6.75 zoom level)
            legend.addTo(map);

        });

    // Update the map colors and legend when a different variable is selected from the dropdown
    document.getElementById('variableSelect').addEventListener('change', function () {
        geojson.setStyle(style);
        legend.remove();
        legend.addTo(map);
    });
});