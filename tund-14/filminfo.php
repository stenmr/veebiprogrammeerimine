<?php
require("../../../config_vp2019.php");
require("functions_film.php");
$userName = "Sten";
$database = "if19_sten_ra_1";

// Sessioon
require("classes/Session.class.php");

SessionManager::sessionStart("vp", 0, "/~stenrau/", "greeny.cs.tlu.ee");

$filmInfoHTML = readAllFilms();

// Lisame lehe päise
require("header.php");
?>

<?php
echo $website;
?>

<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 0 2rem 2rem 2rem; font-size: 18px;">
    <?php
    echo "<h1>" . $userName . "i veebileht!</h1>";
    ?>
    <p>
        See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!
    </p>
    <hr>
    <h2>Eesti filmid</h2>
    <p>Filmid andmebaasist</p>
    <hr>
    <?php
    echo $filmInfoHTML;
    ?>
</body>

</html>