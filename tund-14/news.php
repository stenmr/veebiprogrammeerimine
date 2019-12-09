<?php
require("functions_user.php");
require("functions_main.php");

require("../../../config_vp2019.php");
$userName = "Sten";
$database = "if19_sten_ra_1";


// Kui ei ole sisse loginud
if (!isset($_SESSION["userFirstname"])) {
    header("Location: page.php");
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: page.php");
    exit();
}

$error = "";
$notice = "";
$newsTitle = "";
$news = "";
$expiredate = date("Y-m-d");

// Lisame lehe päise
require("header.php");
?>

<!-- Lisame tekstiredaktory TinyMCE -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: "textarea#newsEditor",
        plugins: "link",
        menubar: "edit",
    });
</script>




<h2>Lisa uudis</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value="<?php echo $newsTitle; ?>"><br>
    <label>Uudise sisu:</label><br>
    <textarea name="newsEditor" id="newsEditor"><?php echo $news; ?></textarea>
    <br>
    <label>Uudis nähtav kuni (kaasaarvatud)</label>
    <input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $expiredate; ?>">

    <input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis!" <?php if ($notice == "Uudis salvestatud!") {
        echo "disabled";
    } ?>> <span>&nbsp;</span><span><?php echo $error; ?></span>
</form>