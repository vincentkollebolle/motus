
<?php
//solution
const INIT = "f________";
const SOLUTION = "formation";
$solution =  str_split(SOLUTION);
$proposalStr = "";

//get user proposal
if(isset($_GET["proposalInput"])) {
	if (strlen($_GET["proposalInput"]) < 1) {
		setMessage("Ecrivez quelque chose...", "danger");
	} elseif (!preg_match ("/^[a-zA-Z]+$/", $_GET["proposalInput"])) {
		setMessage("Seules les lettres sont autorisées", "danger");
	} else if (strlen($_GET["proposalInput"]) > strlen(SOLUTION)) {
		setMessage("Votre mot ne peut pas contenir plus de ".strlen(SOLUTION)." lettres", "danger");
	} else {
		$proposalStr = filter_var($_GET["proposalInput"], FILTER_SANITIZE_STRING);
	}
}
$proposal = str_split($proposalStr);

//game is finished ?
// 0 : wrong
// 1 : present in word
// 2 : present and in the good place
$caseStatus = [2,0,0,0,0,0,0,0,0 ];

//Print letter on the board
function printLetter($letter, $casestatus) {
	if($casestatus == 0 ) { $color = "bleu"; }
	if($casestatus == 1 ) { $color = "jaune"; }
	if($casestatus == 2 ) { $color = "rouge"; }
 	?><td>
 		<span class="case <?=$color?>"><?=$letter?></span>
 		</td>
 	<?php
}

//Print the board on the screen
function printBoard($string, $caseStatus) {
	echo "<table>";
	echo "<tr>";
	$word =  preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);

	for($i=0; $i< count($word); ++$i) {
		if($caseStatus[$i] == 2 ) {
			printLetter($word[$i], $caseStatus[$i]);
		} else if ($caseStatus[$i] == 1) {
			printLetter($word[$i],$caseStatus[$i]);
		} else {
			printLetter($word[$i],$caseStatus[$i]);
		}
	}
	echo "</tr>";
	echo "</table>";
}

//check if game is finised
function gameIsFinish($caseStatus) {
	foreach($caseStatus as $value) {
		if($value !=2) {
			return false;
		}
	}
	return true;
}

// display messages
function setMessage($msg, $alert) {
	echo "<div class='alert $alert'>$msg</div>";
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Mo-Mo-Motus</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="main.css">
</head>
<body>

<div id="tiri">
	<img src="assets/tiri.jpg" alt="" srcset="">
</div>

<div id="content">
	<div id="titre">
		<h1>
			<img src="assets/motus.png" alt="logo de notre jeu">
		</h1>
	</div>

	<div id="jeu">
		<div id="cases">
			<?php printBoard(INIT, $caseStatus); ?>
		</div>

		<div id="formul">
			<form action="" method="">
				<input name="proposalInput" placeholder="votre proposition" type="text" /><br />
				<input type="submit" value="Valider" class="valider" />
			</form>
		</div>
	</div>

	<div id="message">
		<?php
			if(!gameIsFinish($caseStatus)) {
				for($i = 0; $i < count($proposal); ++$i) {
					if($proposal[$i] == $solution[$i]) {
						$caseStatus[$i] = 2;
					} else if (in_array($proposal[$i], $solution)) {
						$caseStatus[$i] = 1;
					} else {
						$caseStatus[$i] = 0;
					}
				}
				printBoard($proposalStr, $caseStatus);
			} else {
				echo "Bravo ! Vraiment Bravo ! ";
		}
		?>
	</div>

</div>
</body>
</html>
