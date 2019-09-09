<?php
    $userName = "Sten";
    $fullTimeNow = date("d.m.Y H:i:s");
    $hourNow = date("G");
    $partOfDay = "...hägune aeg";
    if ($hourNow < 8) {
        $partOfDay = "varane hommik";
    }
?>

<!DOCTYPE html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <title>
            <?php
                echo $userName;
            ?>i veebileht!
        </title>
    </head>
    <body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-left: 2rem; font-size: 20px;">
        <?php
            echo "<h1>" . $userName . "i veebileht!</h1>";
        ?>
        <p>
            See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!
        </p>
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
            echo "<footer 
            style='
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 2rem;'>" . $fullTimeNow . "</footer>";
        ?>
    </body>
</html>