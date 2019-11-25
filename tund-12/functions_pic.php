<?php
function addPicData($fileName, $altText, $privacy)
{
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("INSERT INTO vpphotos3 (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
    echo $conn->error;
    $stmt->bind_param("issi", $_SESSION["userID"], $fileName, $altText, $privacy);
    if ($stmt->execute()) {
        $notice = " Pildi andmed salvestati andmebaasi!";
    } else {
        $notice = " Pildi andmete salvestamine ebaõnnestus tehnilistel põhjustel! " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    return $notice;
}

function readAllPublicPics($privacy)
{
    $picHTML = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos3 WHERE privacy<=? AND deleted IS NULL");
    echo $conn->error;

    $stmt->bind_param("i", $privacy);
    $stmt->bind_result($fileNameFromDb, $altTextFromDb);
    $stmt->execute();

    while ($stmt->fetch()) {
        $picHTML .= '<img src=' . $GLOBALS["pic_upload_dir_thumb"] . $fileNameFromDb . '" alt="' . $altTextFromDb . '">' . "\n";
    }

    if ($picHTML === null) {
        $picHTML = "<p>Kahjuks avalike pilte pole!</p>";
    }

    $stmt->close();
    $conn->close();
    return $picHTML;
}

function readAllPublicPicsPage($privacy, $page, $limit)
{
    $picHTML = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    // $stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos3 WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
    $stmt = $conn->prepare("SELECT vpphotos3.id, vpusers3.firstname, vpusers3.lastname, vpphotos3.filename, vpphotos3.alttext, AVG(vpphotoratings.rating) as AvgValue FROM vpphotos3 JOIN vpusers3 ON vpphotos3.userid = vpusers3.id LEFT JOIN vpphotoratings ON vpphotoratings.photoid = vpphotos3.id WHERE vpphotos3.privacy <= ? AND deleted IS NULL GROUP BY vpphotos3.id DESC LIMIT ?, ?");
    echo $conn->error;

    $skip = ($page - 1) * $limit;

    $stmt->bind_param("iii", $privacy, $skip, $limit);
    $stmt->bind_result($photoIdFromDb, $firstNameFromDb, $lastNameFromDb, $fileNameFromDb, $altTextFromDb, $avgFromDb);
    $stmt->execute();

    while ($stmt->fetch()) {

        //$picHTML .= '<img src=' . $GLOBALS["pic_upload_dir_thumb"] . $fileNameFromDb . ' alt="' . $altTextFromDb . '">' . "\n";
        $picHTML .= '<img src=' . $GLOBALS["pic_upload_dir_thumb"] . $fileNameFromDb . ' alt="' . $altTextFromDb . '" data-fn="' . $fileNameFromDb . '" class="thumbs" ' . ' data-id="' . '">' . "\n";
        $picHTML .= '<p>' . $firstNameFromDb . ' ' . $lastNameFromDb . '</p>' . "\n";
        $picHTML .= '<p id="score' . $photoIdFromDb . '">Hinne: ' . $avgFromDb . '</p>' . "\n";
    }

    if ($picHTML === null) {
        $picHTML = "<p>Kahjuks avalike pilte pole!</p>";
    }

    $stmt->close();
    $conn->close();
    return $picHTML;
}

function countPublicImages($privacy)
{
    $notice = null;

    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT COUNT(*) FROM vpphotos3 WHERE privacy <= ? AND deleted IS NULL");
    echo $conn->error;

    $stmt->bind_param("i", $privacy);
    $stmt->bind_result($imageCountFromDb);
    $stmt->execute();
    if ($stmt->fetch()) {
        $notice = $imageCountFromDb;
    } else {
        $notice = 0;
    }

    $stmt->close();
    $conn->close();

    return $notice;
}
