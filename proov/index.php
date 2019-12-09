<!DOCTYPE html>
<html lang="et">

<head>
    <meta charset="utf-8">
    <title>
        Kaalumis veebileht!
    </title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
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
            transition: 0.25s;
        }

        input[type="submit"]:hover {
            background-color: #eeeeee;
        }

        input[type="radio"] {
            margin-top: 1rem;
        }

        span {
            color: #d63a29;
        }
    </style>
</head>

<?php
require("../../../config_vp2019.php");
require("functions_weight.php");
$database = "if19_sten_ra_1";

$notice = "";
$weightHTML = fetchWeight();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["submitWeight"])) {
    if (isset($_POST["weight"]) && !empty($_POST["weight"])) {
        $notice = saveWeight(test_input($_POST["weight"]));
        $weightHTML = fetchWeight();
    }
}

?>

<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Tänane kaal (kg) </label><input type="number" min="1" max="999" step=".1" value="75" name="weight">
        <br>
        <input type="submit" value="Lisa" name="submitWeight">
    </form>
    <?php
      echo $weightHTML;
    ?>
</body>

</html>