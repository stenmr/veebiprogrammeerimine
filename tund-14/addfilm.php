<?php
    require("../../../config_vp2019.php");
    require("functions_film.php");
    $userName = "Sten";
    $database = "if19_sten_ra_1";

    // Kui on nuppu vajutatud
    if(isset($_POST["submitFilm"]) and !empty($_POST["filmTitle"])) {
        saveFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmCompany"], $_POST["filmDirector"]);
    }

    // Sessioon
    require("classes/Session.class.php");

    SessionManager::sessionStart("vp", 0, "/~stenrau/", "greeny.cs.tlu.ee");

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
    <h2>Eesti filmid, lisame uue</h2>
    <p>Täida kõik failid ja lisa film andmebaasi</p>
    <form method="POST">
        <label>Pealkiri</label><input name="filmTitle">
        <br>
        <label>Aasta</label><input type="number" min="1900" max="2100" value="2019" name="filmYear">
        <br>
        <label>Kestus(min)</label><input type="number" min="1" max="360" value="100" name="filmDuration">
        <br>
        <label>Žanr</label><input name="filmGenre">
        <br>
        <label>Tootja</label><input name="filmCompany">
        <br>
        <label>Lavastaja</label><input name="filmDirector">
        <br>
        <input type="submit" value="Lisa" name="submitFilm">
    </form>
</body>
</html>