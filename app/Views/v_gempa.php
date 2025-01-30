<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earthquake Map Link</title>
    <style>
        .map-container {
            text-align: center;
            margin-top: 50px;
        }
        .map-link {
            background-color: #4285F4;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .map-link:hover {
            background-color: #357AE8;
        }
    </style>
</head>
<body>
    <div class="map-container">
        <h2>Check the Latest Earthquake Data</h2>
        <p>Click the button below to view real-time earthquake information on the USGS website.</p>
        <a href="https://earthquake.usgs.gov/earthquakes/map/?extent=-18.85431,90.65918&extent=14.81737,153.28125&listOnlyShown=true" target="_blank" class="map-link">View Earthquake Map</a>
    </div>
</body>
</html>
