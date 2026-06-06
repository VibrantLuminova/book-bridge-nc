<?php
    // Load GeoJSON file
    $geojsonPath = __DIR__ . '/nc_counties.geojson';
    $geojson = json_decode(file_get_contents($geojsonPath), true);

    // Connect to the database
    require_once __DIR__ . '/../includes/db_connect.php';

    // Get the literacy data
    $sql = "SELECT County, Lit_P1, Lit_P2, Lit_P3, Lit_A, POP, Less_HS, HS, More_HS, Eng_not_well, Poverty_100, Poverty_150, SNAP 
            FROM nc_literacy_county";
    $result = $conn->query($sql);

    // Build an associative array of county data
    $countyData = [];
    while ($row = $result->fetch_assoc()) {
        // Remove " County" from the name)
        $cleanName = str_ireplace(" County", "", $row['County']);
        $countyData[$cleanName] = $row;
    }

    // Merge data into GeoJSON
    foreach ($geojson['features'] as &$feature) {
        $countyName = $feature['properties']['NAME'];
        if (isset($countyData[$countyName])) {
            $feature['properties'] = array_merge($feature['properties'], $countyData[$countyName]);
        }
    }

    // Output the new GeoJSON
    header('Content-Type: application/json');
    echo json_encode($geojson);
?>
