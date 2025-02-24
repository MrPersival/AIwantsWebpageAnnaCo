<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "annacowebpagedb";    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST['Skicka'])){    
    $firstNameAndSurname = htmlspecialchars(string: strip_tags(trim(string: $_POST['nameInput'])));
    $email = htmlspecialchars(string: strip_tags(trim(string: $_POST['emailInput'])));
    $phoneNumber = htmlspecialchars(string: strip_tags(trim(string: $_POST['phoneNumber'])));
    $query = "INSERT INTO contactRequests (firstAndLastName, email, phoneNumber, requestDate) VALUES (?, ?, ?, ?)"; //Because we using execute_query, SQL injections is impossible
    $conn->execute_query( $query, [$firstNameAndSurname, $email, $phoneNumber, date("Y/m/d")]);
    $response = "Tack, {$firstNameAndSurname}, för att du valjade kontakta oss. Vi ska svara så snart som vi kan!";
}
else{
    $response = "Något gick fel. Prova att kontakta oss igen via websida. Error code: {$conn->connect_error}.";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400..700;1,400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Anna & Co.</title>
</head>
<body class="centerEverytingInBody">
    <p class="requestAnswer">
        <?=$response?><br>
    </p>
    <a href="index.html">Tillbacka till sida</a>
</body>
</html>