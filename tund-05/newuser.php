<?php
require("functions_main.php");
require("functions_user.php");

require("../../../config_vp2019.php");
$userName = "Sten";
$database = "if19_sten_ra_1";

$notice = null;
$name = null;
$surname = null;
$email = null;
$gender = null;
$birthMonth = null;
$birthYear = null;
$birthDay = null;
$birthDate = null;
$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

//muutujad võimalike veateadetega
$nameError = null;
$surnameError = null;
$birthMonthError = null;
$birthYearError = null;
$birthDayError = null;
$birthDateError = null;
$genderError = null;
$emailError = null;
$passwordError = null;
$confirmpasswordError = null;



//kui on uue kasutaja loomise nuppu vajutatud
if (isset($_POST["submitUserData"])) {
    if (isset($_POST["firstName"]) && !empty($_POST["firstName"])) {
        $name = test_input($_POST["firstName"]);
    } else {
        $nameError = "Palun sisesta eesnimi!";
    }

    $surname = test_input($_POST["surName"]);
    $gender = $_POST["gender"];
    $email = test_input($_POST["email"]);

    strlen(test_input($_POST["password"]) < 8);

    //kontrollime, kas sünniaeg sisestati ja kas on korrektne
    if (isset($_POST["birthDay"]) and !empty($_POST["birthDay"])) {
        $birthDay = intval($_POST["birthDay"]);
    } else {
        $birthDayError = "Palun vali sünnikuupäev!";
    }

    if (isset($_POST["birthMonth"]) and !empty($_POST["birthMonth"])) {
        $birthMonth = intval($_POST["birthMonth"]);
    } else {
        $birthMonthError = "Palun vali sünnikuu!";
    }

    if (isset($_POST["birthYear"]) and !empty($_POST["birthYear"])) {
        $birthYear = intval($_POST["birthYear"]);
    } else {
        $birthYearError = "Palun vali sünniaasta!";
    }

    // kontrollime kas kuupäev on valiidne
    if (!empty($_POST["birthDay"]) && !empty($_POST["birthMonth"]) && !empty($_POST["birthYear"])) {
        if (checkdate($birthMonth, $birthDay, $birthYear)) {
            $tempDate = new DateTime($birthYear . "-" . $birthMonth . "-" . $birthDay);
            $birthDate = $tempDate->format("Y-m-d");
        } else {
            $birthDateError = "Valitud kuupäev on vigane!";
        }
    }

    // kui kõik on korras
    if (empty($nameError) && empty($surnameError) && empty($birthMonthError) && empty($birthYearError) && empty($birthDayError) && empty($birthDateError) && empty($genderError) && empty($emailError) && empty($passwordError) && empty($confirmpasswordError)) {
        $notice = signUp($name, $surname, $email, $gender, $birthDate, $_POST["password"]);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Katselise veebi uue kasutaja loomine</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 0 2rem 2rem 2rem;
            font-size: 112.5%;
        }

        input,
        select {
            border: solid 2px #bbb;
            padding: 0.5rem;
            margin-top: 0.5vmin;
            margin-right: 1vmin;
            border-radius: 4px;
        }

        input[type="submit"] {
            margin-top: 1rem;
        }

        input[type="submit"]:hover {
            background-color: #81bfc3;
            transition: 0.25s;
        }

        input[name="submitUserData"] + span {
            color: #4eab55;
        }

        input[type="radio"] {
            margin-top: 1rem;
        }

        span {
            color: #d63a29;
        }
    </style>
</head>

<body>
    <h1>Loo endale kasutajakonto</h1>
    <p>See leht on valminud TLÜ õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
    <hr>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Eesnimi:</label><br>
        <input name="firstName" type="text" value="<?php echo $name; ?>"><span><?php echo $nameError; ?></span><br>
        <label>Perekonnanimi:</label><br>
        <input name="surName" type="text" value="<?php echo $surname; ?>"><span><?php echo $surnameError; ?></span>
        <br>
        <input type="radio" name="gender" value="2" <?php if ($gender == "2") {
                                                        echo " checked";
                                                    } ?>><label>Naine</label>
        <input type="radio" name="gender" value="1" <?php if ($gender == "1") {
                                                        echo " checked";
                                                    } ?>><label>Mees</label><br>
        <span><?php echo $genderError; ?></span><br>
        <label>Sünnipäev: </label>
        <?php
        echo '<select name="birthDay">' . "\n";
        echo '<option value="" selected disabled>päev</option>' . "\n";
        for ($i = 1; $i < 32; $i++) {
            echo '<option value="' . $i . '"';
            if ($i == $birthDay) {
                echo " selected ";
            }
            echo ">" . $i . "</option> \n";
        }
        echo "</select> \n";
        ?>
        <label>Sünnikuu: </label>
        <?php
        echo '<select name="birthMonth">' . "\n";
        echo '<option value="" selected disabled>kuu</option>' . "\n";
        for ($i = 1; $i < 13; $i++) {
            echo '<option value="' . $i . '"';
            if ($i == $birthMonth) {
                echo " selected ";
            }
            echo ">" . $monthNamesET[$i - 1] . "</option> \n";
        }
        echo "</select> \n";
        ?>
        <label>Sünniaasta: </label>
        <?php
        echo '<select name="birthYear">' . "\n";
        echo '<option value="" selected disabled>aasta</option>' . "\n";
        for ($i = date("Y") - 15; $i >= date("Y") - 110; $i--) {
            echo '<option value="' . $i . '"';
            if ($i == $birthYear) {
                echo " selected ";
            }
            echo ">" . $i . "</option> \n";
        }
        echo "</select> \n";
        ?>
        <br>
        <span><?php echo $birthDateError . " " . $birthDayError . " " . $birthMonthError . " " . $birthYearError; ?></span>

        <br>

        <label>E-mail (kasutajatunnus):</label><br>
        <input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>
        <label>Salasõna (min 8 tähemärki):</label><br>
        <input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
        <label>Korrake salasõna:</label><br>
        <input name="confirmpassword" type="password"><span><?php echo $confirmpasswordError; ?></span><br>
        <input name="submitUserData" type="submit" value="Loo kasutaja"><span><?php echo $notice; ?></span>
    </form>
    <hr>

</body>

</html>