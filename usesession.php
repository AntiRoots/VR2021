<?php
  require("classes/SessionManager.class.php");
  SessionManager::sessionStart("VR2021", 0, "/~anti.roots/", "tigu.hk.tlu.ee");
  
  //kas on sisse loginud
  if(!isset($_SESSION["user_id"])){
	//jõuga suunatakse sisselogimise lehele
	header("Location: page.php");
	exit();
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	//lõpetame sessiooni
	session_destroy();
	//jõuga suunatakse sisselogimise lehele
	header("Location: page.php");
	exit();
  }