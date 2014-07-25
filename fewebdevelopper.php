<html>
<?php

require_once('./trello.contest.lib.php');

?>
	<head>
		<title>Trello test</title>

	</head>
	<body>
		
		<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
			<h2>Entrez le message à décoder :</h2>

			<textarea type="textarea" rows="10" cols="50" name="chaine"><?php echo getPost('chaine') ?></textarea>
	
			<br/>
			<input type="submit">

		</form>
		
		<div>

		<?php if (getPost('chaine')) { ?>
			<h2>Message décodé :</h2><?php
			$start = microtime(true);
			echo decodeMessage(getPost('chaine'));
			$time_elapsed = microtime(true) - $start;
		?>
		<?php } 

		if (isset($time_elapsed)) {
		?></div>
		<div>
			<h2>Temps écoulé</h2>
		<?php 	
		
				echo $time_elapsed;
			}
		?>

		</div>

	</body>


</html>