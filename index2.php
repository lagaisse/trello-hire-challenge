<html>
<?php
$start = microtime(true);

require_once('./trello.contest.lib.php');

?>
	<head>
		<title>Trello test</title>

	</head>
	<body>
		
		<form action="./index2.php" method="post">
			<h2>Entrez le message à décoder :</h2>

			<textarea type="textarea" rows="10" cols="50" name="chaine"><?php echo getPost('chaine') ?></textarea>
	
			<br/>
			<input type="submit">

		</form>
		
		<div>

		<?php if (getPost('chaine')) { ?>
			<h2>Message décodé :</h2><?php
			echo "*".decodeMessage(getPost('chaine'))."*";
		?>
		<?php } 
		?></div>
		<div>
			<h2>Temps écoulé</h2>
		<?php 	
		$time_elapsed = microtime(true) - $start;
		echo $time_elapsed;
		?>

		</div>

	</body>


</html>