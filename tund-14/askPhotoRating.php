<?php
	//võtame vastu saadetud info
	$photoId = $_REQUEST["photoid"];
	require("../../../../../config_vp2019.php");
	//require("functions_user.php");
	$database = "if19_rinde_vp";
	
	//SESSIOON
    require("classes/Session.class.php");
    //sessioon, mis katkeb, kui brauser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
    SessionManager::sessionStart("vp", 0, "/~rinde/", "greeny.cs.tlu.ee");
	
	$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	//küsime uue keskmise hinde
	$stmt=$conn->prepare("SELECT AVG(rating)FROM vpphotoratings3 WHERE photoid=?");
	$stmt->bind_param("i", $photoId);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$conn->close();
	//ümardan keskmise hinde kaks kohta pärast koma ja tagastan
	echo round($score, 2);