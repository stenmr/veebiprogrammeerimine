<?php
require("../../../config_vp2019.php");
require("functions_main.php");
require("functions_user.php");
$database = "if19_sten_ra_1";

//kui pole sisseloginud
if (!isset($_SESSION["userID"])) {
    //siis jõuga sisselogimise lehele
    header("Location: page.php");
    exit();
}

//väljalogimine
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: page.php");
    exit();
}

$userName = $_SESSION["userFirstname"] . " " . $_SESSION["userLastname"];

$notice = null;
$myDescription = null;
$currentPasswordError = null;
$newPasswordError = null;
$confirmNewPasswordError = null;

if (isset($_POST["submitProfile"])) {
    $notice = storeuserprofiles($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
    if (!empty($_POST["description"])) {
        $myDescription = $_POST["description"];
    }
    $_SESSION["bgColor"] = $_POST["bgcolor"];
    $_SESSION["txtColor"] = $_POST["txtcolor"];
} else {
    $myProfileDesc = showMyDesc();
    if (!empty($myProfileDesc)) {
        $myDescription = $myProfileDesc;
    }
}

require("header.php");
?>


<body>
    <?php
    echo "<h1>" . $userName . " koolitöö leht</h1>";
    ?>
    <p>See leht on loodud koolis õppetöö raames
        ja ei sisalda tõsiseltvõetavat sisu!</p>
    <hr>
    <p><a href="?logout=1">Logi välja!</a> | <a href="userprofile.php">Kasutajaprofiil</a></p>
    <p>Tagasi <a href="home.php">avalehele</a></p>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Minu kirjeldus</label><br>
        <textarea rows="10" cols="80" name="description" placeholder="Lisa siia oma tutvustus ..."><?php echo $myDescription; ?></textarea>
        <br>
        <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $_SESSION["bgColor"]; ?>"><br>
        <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $_SESSION["txtColor"]; ?>"><br>
        <input name="submitProfile" type="submit" value="Salvesta profiil"><span><?php echo $notice; ?></span>
    </form>
    <br>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Praegune salasõna:</label><br>
        <input name="currentpassword" type="password"><span><?php echo $currentPasswordError; ?></span><br>
        <label>Uus salasõna (min 8 tähemärki):</label><br>
        <input name="newpassword" type="password"><span><?php echo $newPasswordError; ?></span><br>
        <label>Korrake uut salasõna:</label><br>
        <input name="confirmnewpassword" type="password"><span><?php echo $confirmNewPasswordError; ?></span><br>
    </form>

</body>

</html>