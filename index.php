<style>
.case {
	display: block;
	color: white;
	font-weight: bold;
	margin-right: 5px;
	border: 1px solid white;
	padding: 10px;
	width: 20px;
}
.bleu {
	background: blue;
}
.rouge {
	background:red;
}
.jaune {
	background:yellow;
}
</style>
<h1>Motus</h1>

<?php 
//solution
const INIT = "f________";
const SOLUTION = "formation";
$solution =  str_split(SOLUTION);

//get user proposal (/!\ todo NTU)
if(isset($_GET["proposalInput"])) {
	$proposalStr = $_GET["proposalInput"];
} else {
	$proposalStr = "";
}
$proposal = str_split($proposalStr);

//game is finished ? 
// 0 : wrong
// 1 : present in word
// 2 : present and in the good place
$caseStatus = ['2',0,0,0,0,0,0,0,0 ];

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
	$word =  str_split($string);
	
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

// First print 
printBoard(INIT, $caseStatus);



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
	?>
	<br />
	<form action="" method="">
		<input name="proposalInput" placeholder="votre proposition" type="text" />
		<input type="submit" value="ok" />
	</form>
<?php
} else {
	echo "Bravo ! Vraiment Bravo ! ";
}
?>
