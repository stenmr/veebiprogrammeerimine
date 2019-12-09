<?php
function fetchWeight()
{
    // Loeme andmebaasist
    // Loome andmebaasi ühenduse
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

    // Valmistame ette päringu
    $stmt = $conn->prepare("SELECT weight, timestamp FROM weight");

    // Seome saadava tulemuse muutujaga
    $stmt->bind_result($weight, $date);

    // Käivitame SQL päringu
    $stmt->execute();
    $weightHTML = null;
    while ($stmt->fetch()) {
        $weightHTML .= "<p>" . round($weight, 1) . " kg -- (" . $date . ")" . "</p>\n";
    }

    // Sulgeme ühenduse
    $stmt->close();
    $conn->close();
    return $weightHTML;
}

function saveWeight($weight)
{
    // Salvestame andmebaasi
    // Loome andmebaasi ühenduse
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

    $stmt = $conn->prepare("INSERT INTO weight (weight) VALUES(?)");
    echo $conn->error;

    // s - string, i - integer, d - decimal
    $stmt->bind_param("d", $weight);
    $stmt->execute();

    // Sulgeme ühenduse
    $stmt->close();
    $conn->close();
}
