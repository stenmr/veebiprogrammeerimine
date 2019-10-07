<?php
    /*
    if ($_SESSION["userId"]) {
        loadProfile($_SESSION["userId"]);
    }
    */

    $bgcolor = "#000000";
    $txtcolor = "#ffffff";

    if ($_SESSION["bgcolor"]) {
        $bgcolor = $_SESSION["bgcolor"];
    }

    if ($_SESSION["txtcolor"]) {
        $txtcolor = $_SESSION["txtcolor"];
    }


    $website = '
    <!DOCTYPE html>
    <html lang="et">
    <head>
        <meta charset="utf-8">
        <title>
            Steni veebileht!
        </title>
        <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            padding: 0 2rem 2rem 2rem;
            font-size: 112.5%;
            background-color: ' . $bgcolor . ';
            color: ' . $txtcolor . ';
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
    ';
?>