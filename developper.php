<?php

require_once('./trello.contest.lib.php');


?><html>
	<head>
		<title>Trello test</title>

	</head>
	<body>
		
		<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="get">
			<h2>Entrez la chaine de caractères à encoder :</h2>

			<input type="text" name="chaine" value="<?php echo getGET('chaine') ?>">	

			<h2>Entrez le hash pour découvrir la chaine de caractères :</h2>

			<input type="text" name="hash" value="<?php echo getGET('hash')?>">	
			<br/>
			<input type="submit">

		</form>
		
		<div>

<?php if (getGET('chaine')) { ?>
		<h2>Hash généré à partir de la chaîne de caractères :</h2>
		<?php
				echo hashThatString($_GET['chaine']);
		?>
		<?php } 
		if (getGET('hash')) { ?>
		
		<h2>Chaîne de caractère en texte clair :</h2>
		<?php
				echo dehashThatString($_GET['hash']);
		?>
		<?php } ?>

		</div>

	</body>


</html>