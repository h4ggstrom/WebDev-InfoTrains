<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Tech</title>
</head>
<body>

<div id="apodImageContainer">
    <?php
    $apodUrl = 'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY&date=2024-02-23';
    $apodData = json_decode(file_get_contents($apodUrl), true);
    $imageUrl = $apodData['url'];
    echo '<img src="' . $imageUrl . '" alt="APOD Image of the Day">';
    ?>
</div>

</body>
</html>
