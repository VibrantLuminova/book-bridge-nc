
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NC Literacy Statistics</title>
        <link rel="icon" type="image" href="/images/bookbridge1.png">
        <link rel="stylesheet" href="/bookbridgenc/css/style.css">
        <script src="/bookbridgenc/js/script.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="/bookbridgenc/js/stats_script.js" defer></script>
    </head>

    <body>
        <header><?php include '../includes/header.php'; ?></header>


        <div class="main-container">
            <section class="section-green">
                <div class="content-wrapper">
                    <p class="quote">"21% of adults in the US are illiterate in 2025." </p>
                    <p class="quote-source">&mdash; <a href="http://www.thinkimpact.com/literacy-statistics/" target="_blank">Think Impact</a> </p>
                </div>
            </section>

            <section class="section-split"></section>

            <section class="section-white">
                <div class="content-wrapper">

                    <h1>Literacy in North Carolina</h1>
                    <p>
                        Literacy is a fundamental skill that significantly impacts all North Carolinians.
                        Statewide data shows that a notable portion of the adult population faces literacy challenges.
                    </p>
                    <ul><strong>Literacy Level:</strong>
                        <li>
                            21.3% of adults have Level 1 or below
                        </li>
                        <li>
                            32.9% of adults have Level 2
                        </li>
                        <li>
                            45.9% of adults have Level 3 or above
                        </li>
                        <li>
                            The overall average literacy score is 265.5 (approximately 51st percentile)<sup class="source" style="color: red;">*</sup>
                        </li>
                        <sup class="source" style="font-style: italic">*For reference, Louisiana and New Mexico have the lowest at 251.5, while New Hampshire has the highest at 278.9.</sup>
                    </ul>
                    <ul><strong>Education Level:</strong>
                        <li>
                            13.1% of adults have not completed High School
                        </li>
                        <li>
                            26.1% of adults have a High School diploma
                        </li>
                        <li>
                            60.8% of adults have higher than a High School diploma (ranging from some college experience to graduate/professional degrees)
                        </li>
                    </ul>
                    <ul><strong>Poverty & Assistance Levels:</strong>
                        <li>
                            16.1% live at or below 100% of the federal poverty level
                        </li>
                        <li>
                            26.5% live at or below 150% of the federal poverty level
                        </li>
                        <li>
                            13.7% of households are receiving benefits from the Supplemental Nutrition Assistance Program (SNAP)
                        </li>
                    </ul>
                    <ul><strong>Language Proficiency:</strong>
                        <li>
                            22% of North Carolinians aged 5 and over have limited English proficiency
                        </li>
                    </ul>


                    <p>
                        This highlights the importance of improving reading and writing skills and having access to books across the state.
                        Examining this type of data helps us gain an understanding of the specific needs within North Carolina communities and how to best support literacy initiatives.
                    </p>
                    <p>The interactive map below allows you to explore literacy levels and related factors across all counties in North Carolina.</p>

                    <hr>

                    <h1 style="text-align:center;">Literacy Map</h1>
                    <div class="dropdown-container">
                        <label for="variableSelect"><strong>Select Variable:</strong></label>
                        <select id="variableSelect">
                            <option value="Lit_P1">Below Level 1 Literacy %</option>
                            <option value="Lit_P2">Level 2 Literacy %</option>
                            <option value="Lit_P3">Level 3 Literacy %</option>
                            <option value="Lit_A">Average Literacy Score</option>
                            <option value="POP">Population</option>
                            <option value="Less_HS">Less than High School %</option>
                            <option value="HS">High School Graduate %</option>
                            <option value="More_HS">More than High School %</option>
                            <option value="Eng_not_well">Limited English Proficiency %</option>
                            <option value="Poverty_100">Poverty 100% Level %</option>
                            <option value="Poverty_150">Poverty 150% Level %</option>
                            <option value="SNAP">Households Receiving SNAP %</option>
                        </select>
                    </div>
                    <div id="map"></div>
                    <p class="credits">Data retrieved from <a href="https://nces.ed.gov/surveys/piaac/skillsmap/" target="_blank">https://nces.ed.gov/surveys/piaac/skillsmap/</a> </p>
                </div>
            </section>

            <section class="section-split"></section>

            <section class="section-green">
                <div class="content-wrapper fade-up">
                    <h3>Want to know more?</h3>
                    <p>
                        Other websites of interest include:
                    </p>
                    <p>
                        <a href="https://nces.ed.gov/surveys/piaac/skillsmap/" target="_blank">U.S. Skills Map</a>: Explore, compare, and analyze USA-wide data compiled by the Program for the International Assessment of Adult Competencies (PIAAC).
                    </p>
                    <p>
                        <a href="https://www.unitebooks.com/book-deserts/the-book-desert-map" target="_blank">The Book Desert Map</a>: Unite for Literacy visualizes book scarcity by predicting the number of households with at least 100 books based on census data.
                    </p>
                    <p>
                        <a href="https://usadatahub.com/u-s-literacy-rates-by-state-2024/" target="_blank">Literacy Rates by State</a>: USA Data Hub displays 2024 literacy rates by state across the USA.
                    </p>

                </div>
            </section>

        </div>

        <footer><?php include '../includes/footer.php'; ?></footer>
    </body>
</html>
