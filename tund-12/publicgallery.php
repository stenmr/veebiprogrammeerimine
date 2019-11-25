<?php
require("functions_user.php");
require("functions_main.php");
require("functions_pic.php");
require("../../../config_vp2019.php");
$database = "if19_sten_ra_1";

//kui pole sisseloginud
if (!isset($_SESSION["userID"])) {
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

$page = 1;
$limit = 5;
$totalPics = countPublicImages(2);

if (!isset($_GET["page"]) || $_GET["page"] < 1) {
    $page = 1;
} elseif (round($_GET["page"] - 1) * $limit > $totalPics) {
    $page = round($totalPics / $limit) - 1;
} else {
    $_GET["page"];
}
$publicThumbsHTML = readAllPublicPicsPage(2, $page, $limit);
$toScript = '<link rel="stylesheet" type="text/css" href="style/modal.css">';
$toScript .= '<script type="text/javascript" src="javascript/modal.js" defer></script>';
require("header.php");
?>


<body>
    <?php
    echo "<h1>" . $userName . " koolitöö leht</h1>";
    ?>
    <p>See leht on loodud koolis õppetöö raames
        ja ei sisalda tõsiseltvõetavat sisu!</p>
    <hr>
    <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>
    <hr>
    <h2>Avalike piltide galerii</h2>
    <!-- Modaalaken -->
    <div id="myModal" class="modal">
        <span class="close" id="close">&times</span>
        <img id="modalImg" class="modal-content">
        <div id="caption"></div>

        <div id="rating" class="modalcaption">
            <label><input id="rate1" name="rating" type="radio" value="1">1</label>
            <label><input id="rate2" name="rating" type="radio" value="2">2</label>
            <label><input id="rate3" name="rating" type="radio" value="3">3</label>
            <label><input id="rate4" name="rating" type="radio" value="4">4</label>
            <label><input id="rate5" name="rating" type="radio" value="5">5</label>
            <input type="button" value="Salvesta hinnang" id="storeRating">
        </div>
        <span id="avgRating"></span>
    </div>

    <?php
    if ($page > 1) {
        echo '<p><a href="?page=' . ($page - 1) . '">Eelmine leht</a> / ';
    } else {
        echo "<p><span>Eelmine leht</span> / ";
    }
    if ($page * $limit < $totalPics) {
        echo '<a href="?page=' . ($page + 1) . '">Järgmine leht</a></p>';
    } else {
        echo "<span>Järgmine leht</span></p>";
    }
    ?>
    <div id="gallery" class="thumbGallery">
        <?php
        echo $publicThumbsHTML;
        ?>
    </div>
</body>

</html>