<?php
require("../../../config_vp2019.php");
$database = "if19_sten_ra_1";

// Võtame vastu info
$photoId = $_REQUEST["photoId"];
$rating = $_REQUEST["rating"];

$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("INSERT INTO vpphotoratings (photoid, userid, rating) VALUES (?, ?, ?)");
echo $conn->error;
$stmt->bind_param("iii", $photoId, $_SESSION["userID"], $rating);
$stmt->execute();
$stmt->close();
//küsime uue keskmise hinde
$stmt = $conn->prepare("SELECT AVG(rating) FROM vpphotoratings WHERE photoid=?");
$stmt->bind_param("i", $photoId);
$stmt->bind_result($score);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();
//ümardan keskmise hinde kaks kohta pärast koma ja tagastan
echo round($score, 2);
