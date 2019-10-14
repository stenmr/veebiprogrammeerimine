<?php
require("../../../config_vp2019.php");
require("functions_user.php");
require("functions_main.php");

// loadProfile($_SESSION["userId"]);

// Kui ei ole sisse loginud
if (!isset($_SESSION["userFirstname"])) {
    header("Location: page.php");
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: page.php");
    exit();
}

$userName = $_SESSION["userFirstname"] . " " . $_SESSION["userLastname"];
$database = "if19_sten_ra_1";


// Lisame lehe päise
require("header.php");
?>

<body>
    <?php
    echo "<h1>" . $userName . "i veebileht!</h1>";
    ?>
    <p>
        See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!
    </p>
    <hr>
    <p><a href="?logout=1">Logi välja</a></p>
    <br>
    <p><a href="userprofile.php">Kasutaja profiil</a></p>

</body>

</html>