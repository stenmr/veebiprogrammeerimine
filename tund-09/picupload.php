<?php
require("functions_user.php");
require("functions_main.php");
require("functions_pic.php");
require("classes/Picupload.class.php");
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

$notice = "";
$fileName = "vp_";
$picMaxW = 600;
$picMaxH = 400;
$waterMark = "../vp_pics/vp_logo_color_w100_overlay.png";

if (isset($_POST["submitPic"])) {
    // Pic upload
    var_dump($_FILES["fileToUpload"]);
    // $target_dir = "uploads/";
    // $target_file = $pic_upload_dir_orig . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $timeStamp = microtime(1) * 10000;
    $fileName .= $timeStamp . "." . $imageFileType;
    $target_file = $pic_upload_dir_orig . $fileName;
    $uploadOk = 1;
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 3000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        $myPic = new PicUpload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
        $myPic->resizeImage($picMaxW, $picMaxH);

        $myPic->addWatermark($waterMark);

        $myPic->saveImage($pic_upload_dir_orig . $fileName);
        unset($myPic);
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $notice .= addPicData($fileName, test_input($_POST["altText"]), $_POST["privacy"]);
}

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
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label>Vali pilt</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br>
        <label>Alt tekst: </label><input type="text" name="altText">
        <br>
        <label>Privaatsus</label>
        <br>
        <input type="radio" name="privacy" value="1"><label>Avalik</label>&nbsp;
        <input type="radio" name="privacy" value="2"><label>Sisseloginud kasutajatele</label>&nbsp;
        <input type="radio" name="privacy" value="3" checked><label>Isiklik</label>
        <br>
        <input name="submitPic" type="submit" value="Lae pilt üles"><span><?php echo $notice; ?></span>
    </form>

    <hr>
    <p><a href="?logout=1">Logi välja</a></p>
    <br>
    <p><a href="home.php">Kodu</a></p>

</body>

</html>