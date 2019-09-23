<?php
    function readAllFilms() {
        // Loeme andmebaasist
        // Loome andmebaasi ühenduse
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

        // Valmistame ette päringu
        $stmt = $conn->prepare("SELECT pealkiri, aasta FROM film");

        // Seome saadava tulemuse muutujaga
        $stmt->bind_result($filmTitle, $filmYear);

        // Käivitame SQL päringu
        $stmt->execute();
        $filmInfoHTML = null;
        while ($stmt->fetch()) {
            $filmInfoHTML .= "<h3>" . $filmTitle . "</h3>";
            $filmInfoHTML .= "<p>" . $filmYear . "</p>";
        }

        // Sulgeme ühenduse
        $stmt->close();
        $conn->close();
        return $filmInfoHTML;
    }

    function saveFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector) {
        // Salvestame andmebaasi
        // Loome andmebaasi ühenduse
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

        $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?, ?, ?, ?, ?, ?)");
        echo $conn->error;

        // s - string, i - integer, d - decimal
        $stmt->bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector);
        $stmt->execute();

        // Sulgeme ühenduse
        $stmt->close();
        $conn->close();
    }