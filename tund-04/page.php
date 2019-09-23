<?php
    $userName = "Sten";
    $photoDir = "../photos/";
    $picFileTypes = ["image/jpeg", "image/png"];

    setlocale(LC_ALL, 'et_EE');
    $fullTimeNow = utf8_encode(strftime('%A %e %B %Y %H:%M:%S'));
    $hourNow = date("G");

    // $weekDaysET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];

    $partOfDay = "...hägune aeg";
    if ($hourNow < 8) {
        $partOfDay = "varane hommik";
    } elseif ($hourNow < 12) {
        $partOfDay = "hommik";
    } elseif ($hourNow < 16) {
        $partOfDay = "lõuna";
    } elseif ($hourNow < 23) {
        $partOfDay = "õhtu";
    }

    // Info semestri kulgemise kohta
    $semesterStart = new DateTime("2019-9-2");
    $semesterEnd = new DateTime("2019-12-13");
    $semesterDuration = $semesterStart->diff($semesterEnd);
    $today = new DateTime("now");
    $fromSemesterStart = $semesterStart->diff($today);
    $semesterInfoHTML = "<p>Siin peaks olema info semestri kulgemise kohta!</p>";
    $elapsedValue = $fromSemesterStart->format("%r%a");
    $durationValue = $semesterDuration->format("%r%a");
    // <meter min="0" max="155" value="10">Väärtus</meter>
    if ($elapsedValue > 0) {
        $semesterInfoHTML = "<p>Semester on täies hoos: ";
        $semesterInfoHTML .= '<meter min="0" max="' . $durationValue . '" ';
        $semesterInfoHTML .= 'value="' .  $elapsedValue . '"';
        $semesterInfoHTML .= round($elapsedValue / $durationValue * 100, 1) . '%</meter>';
        $semesterInfoHTML .="</p>";
    }

    // Fotode lisamine lehele
    $allPhotos = [];
    $dirContent = array_slice(scandir($photoDir), 2);
    foreach ($dirContent as $file) {
        $fileInfo = getImagesize($photoDir . $file);
        if (in_array($fileInfo["mime"], $picFileTypes) == true) {
            array_push($allPhotos, $file);
        }
    }

    // Foto lisamine lehele
    $picCount = count($allPhotos);
    $picNum = mt_rand(0, $picCount - 1);
    $photoFile = $photoDir . $allPhotos[$picNum];
    $randomImgHTML = '<img src="' . $photoFile . '" alt="TLÜ Terra õppehoone">';

    // Lisame lehe päise
    require("header.php");
?>

<?php
        echo $website;
    ?>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-left: 2rem; font-size: 20px;">
    <?php
        echo "<h1>" . $userName . "i veebileht!</h1>";
    ?>
    <p>
        See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!
    </p>
    <?php
        echo $semesterInfoHTML;
    ?>
    <p style="font-weight: 600">
        Samuti muutsin seda lehte koduse tööna!
    </p>

    <p>Kasutame PHP serverit mille kohta saab infot <a href="serverinfo.php">siit!</a></p>

    <p>Meie esimene PHP programm on <a href="try.php">siin!</a></p>

    <hr>
    
    <?php
        echo "<p>Lehe avamise hetkel oli " . $partOfDay . ".</p>";
    ?>

    <?php
        echo $randomImgHTML;
    ?>

    <?php
        echo "<footer 
        style='
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 2rem;'>" . $fullTimeNow . "</footer>";
    ?>

    <hr>
</body>
</html>