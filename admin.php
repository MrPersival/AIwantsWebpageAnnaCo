<?php
$isKeyFinded = false;
$tableCode = "";
if(isset($_POST["logInButton"]))
{
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
    $inputedKey = htmlspecialchars(string: strip_tags(trim(string: $_POST['inputedKey']))); //Because we using execute_query, SQL injections is impossible
    $query = "SELECT * FROM adminkeys WHERE adminkey=?";
    $result = $conn->execute_query( $query, [$inputedKey]);
    if ($result == false || $result->num_rows <= 0) {
        $conn->close();
    }
    else{
        if(isset($_POST["contactedNumber"])){
            $query = "UPDATE contactrequests SET isContacted = 1, contactDate = ? WHERE phoneNumber=?";
            $result = $conn->execute_query( $query, [date("Y/m/d"), $_POST["contactedNumber"]]); //contact number is NOT inputed by user and therefore safe
        }
        $query = "SELECT * FROM contactrequests";
        $result = $conn->execute_query( $query);
        $isKeyFinded = true;
        $tableCode = "
        <table>
            <tr>
                <th>Namn</th>
                <th>Email</th>
                <th>Tel.</th>
                <th>Datum för begäran</th>
                <th>Är kontaktad?</th>
                <th>Datum kontaktad</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            $contactedCode = "";
            $contactTimeCode = "";
            if ($row["isContacted"] == true) {
                $contactedCode = '<span class="contacted">Ja</span>';
                $contactTimeCode = $row["contactDate"];
            }
            else{
                $contactedCode = '<button type="button" class="notContacted" onclick="contacted(\'' . $row["phoneNumber"] . '\')">Nej</button>';
                $contactTimeCode = "-";
            }
            $tableCode .= "<tr><td>" . $row["firstAndLastName"] . "</td>" .
            "<td>" . $row["email"] . "</td>" . 
            "<td>" . $row["phoneNumber"] . "</td>" . 
            "<td>" . $row["requestDate"] . "</td>" . 
            "<td>" . $contactedCode . "</td>" . 
            "<td>" . $contactTimeCode . "</td>";
        }
        $conn->close();
    }
}

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
    <title>Admin - Anna and Co.</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
    <div id="loginDiv" class="centerEverytingInBody">
        <form action="admin.php" method="post">
            <label for="inputedKey">Admins koden: </label>
            <input type="text" name="inputedKey" id="inputedKey" pattern="^(?=.{1,100}$)[a-zA-Z0-9]+$" required style="width: 50rem;">
            <br>
            <input type="submit" name="logInButton" value="Logga in">
        </form>
        <p style="color: red; display: none;" id="errorMassage" >Fel kod.</p>
    </div>
    <div id="contactList" style="display:none;">
        <h1>Begärt kontakt</h1>
        <div id="contactTablePlaceholder">
            <p>This is the placeholder. If you see this, something gone wrong</p>
        </div>
    </div>

</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if(<?=json_encode(isset($_POST["logInButton"])); ?>) {
            if(<?=json_encode($isKeyFinded); ?>){
                let tableCode = `<?=$tableCode?>`;
                document.getElementById("contactList").style.display = "block";
                document.getElementById("contactTablePlaceholder").innerHTML = tableCode;
                document.getElementById("loginDiv").style.display = "none";
            }
            else{
                document.getElementById("errorMassage").style.display = "block";
            }
        }
    });
    function contacted(phoneNumber){
        $.ajax({
                type: "POST", 
                url: "admin.php",
                data: { 
                    logInButton: `<?= $_POST["logInButton"] ?>`, 
                    inputedKey: "<?= $inputedKey ?>", 
                    contactedNumber: phoneNumber 
                },
                success: function(response) {
                    document.innerHTML = response;
                    location.reload();
                },
                error: function(error) {
                    console.error("Error:", error);
                }
            });
    };
</script>