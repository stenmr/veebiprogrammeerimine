<?php
require("functions_user.php");
require("functions_main.php");
require("functions_messages.php");
require("../../../config_vp2019.php");

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

$message = "";
$notice = "";
$messagesHTML = null;

if (isset($_POST["submitMessage"])) {
    if (isset($_POST["message"]) && !empty($_POST["message"])) {
        $notice = storeMessage(test_input($_POST["message"]));
    }
}

$messagesHTML = readMyMessages();

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
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Minu sõnum</label><br>
        <textarea rows="10" cols="80" name="message" placeholder="Lisa siia oma sõnum"><?php echo $message; ?></textarea>
        <br>
        <input name="submitMessage" type="submit" value="Salvesta sõnum"><span><?php echo $notice; ?></span>
    </form>

    <hr>
    <p><a href="?logout=1">Logi välja</a></p>
    <br>
    <p><a href="home.php">Kodu</a></p>
    <hr>
    <h2>Senised sõnumid</h2>
    <?php
    echo $messagesHTML;
    ?>

</body>

</html>