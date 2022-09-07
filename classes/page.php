<?php

	session_start();
	//require("classes/SessionManager.class.php");
	//SessionManager::sessionStart("VR2021", 0, "/~anti.roots/", "tigu.hk.tlu.ee");

	  require_once "../../../conf.php";
	  //require_once "fnc_general.php" ;
	  require_once "fnc_user.php";

	  //klassi n2ide
	  require_once "classes/Test.class.php";
	  $test= new Test();
	  echo $test-> secret;

	$myname = "Anti Roots";
	$currenttime = date("d.m.Y H:i:s");
	$timehtml = "\n <p>Lehe avamise hetkel oli: " .$currenttime .".</p> \n";
	$semesterbegin = new DateTime("2021-1-25");
	$semesterend = new DateTime("2021-6-30");
	$semesterduration = $semesterbegin->diff($semesterend);
	$semesterdurationdays = $semesterduration->format("%r%a"); // anname formaadi 
	$semesterdurhtml = "\n <p>2021 kevadsemestri kestus on " .$semesterdurationdays ." päeva.</p> \n";
	$today = new DateTime("now");
	$fromsemesterbegin = $semesterbegin->diff($today); // semestri alguse ja tänase päeva vahe
	$fromsemesterbegindays = $fromsemesterbegin->format("%r%a");
	
	
	
	//loeme piltide kataloogi sisu
	$picsdir = "pics/";
	$allfiles = array_slice(scandir($picsdir), 2);
	//echo $allfiles[5];
	//var_dump($allfiles);
	$allowedphototypes=["image/jpeg", "image/png"];
	$picfiles=[];

	foreach($allfiles as $file){
		$fileinfo = getimagesize($picsdir .$file);
		//var_dump($fileinfo);
		if(isset($fileinfo["mime"])){
			if(in_array($fileinfo["mime"], $allowedphototypes)){
				array_push($picfiles, $file);
			}
		}
	}
	
	$photocount = count($picfiles);
	$photonum = mt_rand(0, $photocount-1);
	$randomphoto = $picfiles[$photonum];



	// Nädalapäeva kuvamine

	$DayNr = date('w'); // see funk. annab nädalapäeva 0 kuni 6, kus 0 = pühapäev
	$DayNames=['pühapäev','esmaspäev','teisipäev','kolmapäev','neljapäev','reede','laupäev']; // teen listi nädalapäevadega
	$DayHtml="<p> Täna on ". $DayNames[$DayNr].".</p>"; 

	// setlocale(LC_TIME, 'et_EE.utf8');                                       // Php oma funk
	// $DayName ="<p> Täna on ". strftime('%A.');



	//Kolm juhusliku  arvu, mis ei kordu
	
	$RandNrArray = [];    // juhuslikke arvude  tühi list

	while (count($RandNrArray) < 3) {				// tsükklit läbitakse kolm korda, viimane kord siis kui count($RandomArray)=2
	    $RandNr = mt_rand(0, $photocount-1);         //  juhuslik arv 0 kuni piltide koguarv                
	    if(!(in_array($RandNr, $RandNrArray))) {      // kui juhuslikku arvu POLE juhuslike arvude listis ,siis pannakse see juhuslike arvude list                
	        array_push($RandNrArray, $RandNr);                         
		}
	}

	// Semestri kulgemise kontroll

	if($fromsemesterbegindays < 0) // kui semester pole veel alanud
	{
		$semesterprogress = "\n <p>Semester pole veel alanud.</p> \n";
	}
	elseif($fromsemesterbegindays <= $semesterdurationdays) // kui semester allae käib
	{
		$semesterprogress = "\n"  .'<p>Semester edeneb: <meter min="0" max="' .$semesterdurationdays .'" value="' .$fromsemesterbegindays .'"></meter></p>' ."\n";
	} else // kui k
	{
		$semesterprogress = "\n <p>Semester on lõppenud.</p> \n";
	}
	//sisselogimine
	$notice=null;
	$email=null;
	$email_error=null;
	$password_error=null;
	if(isset($_POST["login_submit"])){
		//kontrollime, kas k6ik olemas
		$notice = sign_in($_POST["email_input"], $_POST["password_input"]);
	}

	


?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2021</title>
</head>
<body>
	<h1>
	<?php
		echo $myname;
	?>
	</h1>
	<p>See leht on valminud õppetöö raames!</p>
	<hr>

	<h2>Logi sisse</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>E-mail (kasutajatunnus):</label><br>
		<input type="email" name="email_input" value="<?php echo $email; ?>"><span><?php echo $email_error; ?></span><br>
		<label>Salasõna:</label><br>
		<input name="password_input" type="password"><span><?php echo $password_error; ?></span><br>
		<input name="login_submit" type="submit" value="Logi sisse!"><span><?php echo $notice; ?></span>
	</form>
	<p>Loo endale <a href="add_user.php">kasutajakonto!</a></p>

	<hr>
	<?php
		echo $timehtml;
		echo $semesterdurhtml;
		echo $semesterprogress;
	?>
	<p>
	<?php
		// echo $DayNr;   
		echo $DayHtml;
		// echo $DayName;
	?>	
	</p>
		<p>Üks ilus pilt Haapsalust.</p>
		<img src="<?php echo $picsdir .$randomphoto; ?>" alt="vaade Haapsalus">
	<div>
		<p>Kolm juhuslikku pilti.</p>
		<img src="<?php echo $picsdir .$picfiles[$RandNrArray[0]]; ?>" alt="vaade Haapsalus" style="width:33%;height:33%;"> <!-- kuvab esimese juhusliku pildi, võttes aluseks juhuslikult genereeritud arvude listi -->
		<img src="<?php echo $picsdir .$picfiles[$RandNrArray[1]]; ?>" alt="vaade Haapsalus" style="width:33%;height:33%;"> <!-- kuvab teise juhusliku pildi, võttes aluseks juhuslikult genereeritud arvude listi -->
		<img src="<?php echo $picsdir .$picfiles[$RandNrArray[2]]; ?>" alt="vaade Haapsalus" style="width:33%;height:33%;"> <!-- kuvab kolmanda juhusliku pildi, võttes aluseks juhuslikult genereeritud arvude listi -->
	</div>
</body>
</html>