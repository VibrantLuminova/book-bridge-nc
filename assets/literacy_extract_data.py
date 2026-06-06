"""
CSC 4388: Systems Design and Development
Project 3 Leveraging Data for Social Good
Written by: Carlianne Mickle
Extracts data from literacydataset.xlsx (downloaded from https://nces.ed.gov/surveys/piaac/skillsmap/)
Outputs State and County data for NC into two .csv files
"""

import pandas as pd

file_path = 'literacydataset.xlsx'
xlsx = pd.ExcelFile(file_path)

# Load sheets into DataFrames
state_df = pd.read_excel(xlsx, sheet_name='State')
county_df = pd.read_excel(xlsx, sheet_name='County')

# Select the needed columns
state_columns = [
    'State', 'grpName', 'Lit_P1', 'Lit_P2', 'Lit_P3', 'Lit_A', 'POP',
    'Less_HS', 'HS', 'More_HS', 'Eng_not_well', 'Poverty_100', 'Poverty_150', 'SNAP'
]
county_columns = [
    'State', 'County', 'grpName', 'Lit_P1', 'Lit_P2', 'Lit_P3', 'Lit_A', 'POP',
    'Less_HS', 'HS', 'More_HS', 'Eng_not_well', 'Poverty_100', 'Poverty_150', 'SNAP'
]

# Filter and clean State data (NC Only)
state_df_nc = state_df[state_columns]
state_df_nc = state_df_nc[state_df_nc['State'] == 'North Carolina']
state_df_nc = state_df_nc[state_df_nc['grpName'] == 'all']
state_df_nc = state_df_nc.drop(columns=['grpName']) # Drop grpName column

# Filter and clean County data (NC Only)
county_df_nc = county_df[county_columns]
county_df_nc = county_df_nc[county_df_nc['State'] == 'North Carolina']
county_df_nc = county_df_nc[county_df_nc['grpName'] == 'all']
county_df_nc = county_df_nc.drop(columns=['grpName']) # Drop grpName column

# Save the cleaned files
state_df_nc.to_csv('nc_literacy_data_state.csv', index=False)
county_df_nc.to_csv('nc_literacy_data_county.csv', index=False)

print("New CSV files created successfully.") # if unsuccessful this will not print!