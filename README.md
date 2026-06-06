# Book Bridge NC

## Description
Book Bridge NC is a web application designed to support a fictional non-profit literacy initiative. It informs visitors about the state of literacy across North Carolina and encourages them to take action. Visitors can explore county-level statistics in North Carolina through an interactive map and donate books to communities of their choice.

Book Bridge NC was developed as a Computing for Social Good project for the Systems & Database Design course at Winston-Salem State University in Spring of 2025.

## Technologies Used
* HTML, CSS, JS, PHP
* Python 
* Pandas
* MySQL
* JSON
* GeoJSON
* Leaflet.js

## Features
* Learn about statewide literacy statistics, including literacy levels, education, poverty, and language proficiency data.
* Explore an interactive map displaying literacy levels and related factors across North Carolina counties. 
* Search for books to donate using the integrated OpenLibrary API. 

## Assets
* `literacydataset.xlsx` - Raw dataset downloaded from PIAAC
* `literacy_extract_data.py` - Extracts and filters NC data from the dataset into CSV files
* `literacy_data.sql` - Full database dump containing tables and NC literacy data
* `donation_inventory.sql` - Database table structure for storing book donations

## Sources
Statistical data retrieved from the [Program for the International Assessment of Adult Competencies (PIAAC)](https://nces.ed.gov/surveys/piaac/skillsmap/)  
Book information retrieved from the [OpenLibrary JSON API](https://openlibrary.org/dev/docs/json_api)  
Base map tiles provided by [OpenStreetMap](https://www.openstreetmap.org/)  
North Carolina county boundary GeoJSON provided by [sieger1010 via GitHub](https://github.com/sieger1010/NorthCarolina-GeoJson/blob/main/NCCountiesComplete3.geo.json)

## Setup
Prerequisite program: XAMPP (which includes Apache, MySQL, and PHP) 

1. Launch XAMPP and start both Apache and MySQL.
2. Open your browser and navigate to http://localhost/phpmyadmin
3. Create new database named `literacy_data`
4. Select the `literacy_data` database, then click import 
5. Import the file `assets/literacy_data.sql`
6. Import the file `assets/donation_inventory.sql`
7. Move the `bookbridgenc` project folder into XAMPP's htdocs directory.
8. In your browser, navigate to http://localhost/bookbridgenc