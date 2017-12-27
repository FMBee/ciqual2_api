<?php

 	include('defines.php');
 
 	try {
 		$pdo = new PDO(_DBSERVER, _DBUSER, _DBPWD);
 		$pdo->query('SET NAMES UTF8');
 	
 	} catch (Exception $e) {
 	
 		die('Erreur de connexion Mysql');
 	}
 	
 	foreach( $_LIST_FILES as $file ) {
 		
	 	$filein  = _CIQUAL_PATH	.str_replace('XXX', $file, _MODEL_FILE);
	 	$filetmp = _CIQUAL_PATH .'fichier_utf8.xml';
	
	 	$buffer = file_get_contents($filein);
	 	$buffer = utf8_encode($buffer);
	 	file_put_contents($filetmp, $buffer);
	 	
 		$sql = "TRUNCATE {$file};";
 		
 		$sql .= "LOAD XML local infile '{$filetmp}' into table {$file}"
 				." ROWS IDENTIFIED BY '<" .strtoupper($file) .">';"
 		; 
 		$req = $pdo->prepare($sql);
 		$req->execute();
 	}
 	
?>	
