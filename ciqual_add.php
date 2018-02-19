<?php

/*
 * c:/../php ciqual_add.php [ING/CAT]
 * 
 * 		pour importer des ingredients internes ING
 * 		ou des groupes/categories CAT
 * 
 * 		parametrer les tableaux ci-après
 */

	
	define('_FILE_ADD', 	'Table VN Boulpat.csv');		
	define('_BEGIN_VAL', 	9);		// 1ere colonne contenant les nutriments (commence à 0)

	define('_DBSERVER',	'mysql:host=localhost;dbname=ciqual2_api');
	define('_DBUSER',	'root');
	define('_DBPWD',	'');
	
 	try {
 		$pdo = new PDO(_DBSERVER, _DBUSER, _DBPWD);
 		$pdo->query('SET NAMES UTF8');
 	
 	} catch (Exception $e) {
 	
 		die('Erreur de connexion Mysql');
 	}

 	// à mofifier
 	$paramGroupe = array(
 		'99',	
 		'9999',	
 		'999999',	
 		'Pâtisserie BASE CATEGORIE BOULPAT',	
 		'Pâtisserie BASE CATEGORIE BOULPAT',	
 		'Pâtisserie BASE CATEGORIE BOULPAT'
 	);
 	
 	$sqlGroupe = "
 		INSERT INTO alim_grp SET
 			alim_grp_code			= concat(' ', ?, ' '),
 			alim_ssgrp_code			= concat(' ', ?, ' '),
 			alim_ssssgrp_code		= concat(' ', ?, ' '),
 			alim_grp_nom_fr			= concat(' ', ?, ' '),
 			alim_ssgrp_nom_fr		= concat(' ', ?, ' '),
 			alim_ssssgrp_nom_fr		= concat(' ', ?, ' '),
 	";
 	
 	if ( $_argv)
	sqlDo($pdo, $sqlGroupe, $paramGroupe);

prt('groupe ajouté');

//end 	
 	
 	function sqlDo($pdo, $sql, $params=array(), $fetch=0) {
 	
// prt($sql);
 		$req = $pdo->prepare($sql);
 		$result = $req->execute( count($params) ? $params : null );

 		if( $result ){
 			 
	 		switch ($fetch) {
	 	
	 			case 0:
	 				return $result;
	 	
	 			case 1:
	 				return $req->fetch(PDO::FETCH_ASSOC);
	 					
	 			case 2:
	 				return $req->fetchAll(PDO::FETCH_ASSOC);
	 					
	 		}
 		}
 		else{
 			echo $req->errorInfo()[2] ." / Erreur requete : {$sql}";
 		}
 	}

 	function prt($var) {
 		
 		print_r($var); 
 		echo PHP_EOL .PHP_EOL;
 	}
 	
/* 	

LOAD DATA INFILE 'C:/xampp/htdocs/workdev/ciqual2_api/Code a exclure table Ciqual 2017.csv' 
INTO TABLE alim_grp_not 
CHARACTER SET UTF8 FIELDS TERMINATED BY ';' ENCLOSED BY '' LINES TERMINATED BY '\n'

*/
?>	
