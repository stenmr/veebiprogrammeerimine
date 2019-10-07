<?php
require("functions_user.php");
require("functions_main.php");
require("../../../config_vp2019.php");


function saveProfile($userId, $description, $bgcolor, $txtcolor)
{
    $notice = null;
    $_SESSION["description"] = $description;
    $_SESSION["bgcolor"] = $bgcolor;
    $_SESSION["txtcolor"] = $txtcolor;

    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES (?,?,?,?)");
    echo $conn->error;

    $stmt->bind_param("isss", $userId, $description, $bgcolor, $txtcolor);

    if ($stmt->execute()) {
        $notice = "Andmed on salvestatud!";
        $_SESSION["description"] = $description;
        $_SESSION["bgcolor"] = $bgcolor;
        $_SESSION["txtcolor"] = $txtcolor;

    } else {
        $notice = "Andmete salvestamine ebaõnnestus! :( " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    return $notice;
}

function loadProfile($userId)
{
    $notice = "";
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
    echo $mysqli->error;
    $stmt->bind_param("s", $userId);
    $stmt->bind_result($descriptionFromDb, $bgcolorFromDb, $txtcolorFromDb);
    if ($stmt->execute()) {
        //kui päring õnnestus
        $notice = "Andmete laadimine õnnestus!";
        $_SESSION["description"] = $descriptionFromDb;
        $_SESSION["bgcolor"] = $bgcolorFromDb;
        $_SESSION["txtcolor"] = $txtcolorFromDb;

        $stmt->close();
        $mysqli->close();

        return;
    } else {
        $notice = "Andmete laadimisel tekkis viga! :(" . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
    return $notice;
}

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

$description = "";
$bgcolor = null;
$txtcolor = null;

if(isset($_POST["submitProfile"])) {
    $description = $_POST["description"];
    $bgcolor = $_POST["bgcolor"];
    $txtcolor = $_POST["txtcolor"];

    $notice = saveProfile($_SESSION["userId"], $description, $bgcolor, $txtcolor);
}

// Lisame lehe päise
require("header.php");
?>

<?php
echo $website;
?>

<body>
    <?php
    echo "<h1>" . $userName . "i veebileht!</h1>";
    ?>
    <p>
        See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!
    </p>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="50" name="description"><?php echo $description; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $bgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $txtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil">
	</form>

    <hr>
    <p><a href="?logout=1">Logi välja</a></p>
    <br>
    <p><a href="home.php">Kodu</a></p>

</body>

</html>