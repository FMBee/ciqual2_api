<?php
/*
 * c:/../php ciqual_import.php
 * 		pour importer un seul fichier commenter le tableau dans defines.php
 * 
 * c:/../php ciqual_import.php add
 * 		pour importer les aliments ajoutés (alim_add) dans la table (alim)
 */
 	include('defines.php');
 
 	try {
 		$pdo = new PDO(_DBSERVER, _DBUSER, _DBPWD);
 		$pdo->query('SET NAMES UTF8');
 	
 	} catch (Exception $e) {
 	
 		die('Erreur de connexion Mysql');
 	}
 	
 	// pour importer un seul fichier commenter le tableau dans defines.php
 	foreach( $_LIST_FILES as $file ) {
 		
	 	$filein  = _CIQUAL_PATH	.str_replace('XXX', $file, _MODEL_FILE);
	 	$filetmp = _CIQUAL_PATH .'fichier_utf8.xml';	// chemin relatif
	
	 	$buffer = file_get_contents($filein);
	 	$buffer = utf8_encode($buffer);
	 	file_put_contents($filetmp, $buffer);
	 	
	 	$filetmp = str_replace('\\', '/', __DIR__ .'/fichier_utf8.xml');	// chemin réel
	 	
 		$sql = "TRUNCATE {$file};";
 		
 		$sql .= "LOAD XML infile '{$filetmp}' into table {$file}"
 				." CHARACTER SET UTF8 "
 				." ROWS IDENTIFIED BY '<" .strtoupper($file) .">';"
 		; 
prt($sql);

 		$req = $pdo->prepare($sql);
 		$req->execute();
 	}
 	
 	// exclusions de groupes
 	sqlDo(	$pdo,
	 	"UPDATE alim_grp a
	 	SET tag = 'E'
	 	where concat(trim(a.alim_grp_code), trim(a.alim_ssgrp_code), trim(a.alim_ssssgrp_code))
	 	IN (SELECT concat(trim(b.alim_grp_code), trim(b.alim_ssgrp_code), trim(b.alim_ssssgrp_code)) from alim_grp_not b)"
 	);

 	// aliments sans categorie valide
 	$results = sqlDo(	$pdo,
		"SELECT a.alim_code, a.alim_nom_fr, 
		concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie, 
		b.alim_grp_code
		FROM alim a left join alim_grp b 
		on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
		WHERE isnull(b.alim_grp_code) 
		order by categorie, a.alim_nom_fr",
 		2
 	);
prt('aliments sans categorie valide');prt($results); 
 	
 	// aliments ajoutés (alim_add) sans categorie valide
 	$results = sqlDo(	$pdo,
		"SELECT a.alim_code, a.alim_nom_fr, 
		concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie, 
		b.alim_grp_code
		FROM alim_add a left join alim_grp b 
		on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
		WHERE isnull(b.alim_grp_code) 
		order by categorie, a.alim_nom_fr",
 		2
 	);
prt('aliments ajoutes sans categorie valide');prt($results); 

 	// aliments ajoutés (alim_add) : liste détaillée des valeurs pour controle des NULL
 	$results = sqlDo(	$pdo,
		"SELECT a.alim_code, a.alim_nom_fr, concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as alim_grp_code,
		b.alim_grp_code as groupe, c.const_code as compo
		from alim_add a
		left join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code
		left join compo_add c on a.alim_code = c.alim_code
		order by alim_code",
 		2
 	);
prt('aliments ajoutes : controle des NULL');prt($results); 


	// ajout des aliments internes (alim_add)
	if ( isset($argv[1]) && $argv[1] == 'add' ) {
		
		die('copie');//duplicate tables before ?
		sqlDo(	$pdo,
		 	"INSERT IGNORE into alim (alim_code, alim_grp_code, alim_ssgrp_code, alim_ssssgrp_code,alim_nom_fr) 
			 	SELECT b.alim_code, b.alim_grp_code, b.alim_ssgrp_code, b.alim_ssssgrp_code,b.alim_nom_fr 
			 	FROM alim_add b"
		);
		sqlDo(	$pdo,
			"INSERT IGNORE into compo (alim_code, const_code, teneur)
				SELECT b.alim_code, b.const_code, b.teneur
				FROM compo_add b"
		);
	}
//end 	
 	
 	function sqlDo($pdo, $sql, $fetch=0) {
 	
// prt($sql);
 		$req = $pdo->prepare($sql);
 		$result = $req->execute();
 	
 		switch ($fetch) {
 	
 			case 0:
 				return $result;
 	
 			case 1:
 				return $req->fetch(PDO::FETCH_ASSOC);
 					
 			case 2:
 				return $req->fetchAll(PDO::FETCH_ASSOC);
 					
 		}
 	}

 	function prt($var) {
 		
 		print_r($var); 
 		echo PHP_EOL .PHP_EOL;
 	}
/* 	

ATTENTION : 
- les champs XML sont TOUS (warum..) encadrés par un ESPACE
(dans les scripts tout est donc trimmé dans les tests, recherches, .., sur les tables
- le fichier alim_grp_xxx.xml contient des 'E dans l'O' -> à remplacer sous notepad/blocnote avant import

- importation des exclusions de groupes

CREATE TABLE `alim_grp_not` (
  `alim_grp_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `alim_ssgrp_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `alim_ssssgrp_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `alim_grp` ADD `tag` VARCHAR(1) NULL AFTER `alim_ssssgrp_nom_eng`;

LOAD DATA INFILE 'C:/xampp/htdocs/workdev/ciqual2_api/Code a exclure table Ciqual 2017.csv' 
INTO TABLE alim_grp_not 
CHARACTER SET UTF8 FIELDS TERMINATED BY ';' ENCLOSED BY '' LINES TERMINATED BY '\n'


- tag des groupes à exclure

UPDATE alim_grp a
SET tag = 'E' 
where concat(trim(a.alim_grp_code), trim(a.alim_ssgrp_code), trim(a.alim_ssssgrp_code)) 
IN (SELECT concat(trim(b.alim_grp_code), trim(b.alim_ssgrp_code), trim(b.alim_ssssgrp_code)) from alim_grp_not b)

- liste des aliments exclus 

CREATE or replace view alim_exclus as

SELECT a.alim_code, a.alim_nom_fr as aliment, 
concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie, 
concat(b.alim_ssssgrp_nom_fr, ' | ', b.alim_ssgrp_nom_fr) as libelle 
from alim a 
join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code 
= b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
where b.tag = 'E' 
order by categorie, a.alim_nom_fr


- vue generale aliments valides (pas de tri trop gourmand)

CREATE or replace view alim_details as

SELECT a.alim_code, a.alim_nom_fr, concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as alim_grp_code,  
concat(a.alim_nom_fr, ' | ', b.alim_ssssgrp_nom_fr, ' | ', b.alim_ssgrp_nom_fr) as alim_name
from alim a
join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code
where isnull(b.tag)


- vue générale aliments avec constituants (pas de tri trop gourmand)

CREATE or replace view alim_values_details as

SELECT a.alim_code, a.alim_nom_fr, concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as alim_grp_code,  
concat(a.alim_nom_fr, ' | ', b.alim_ssssgrp_nom_fr, ' | ', b.alim_ssgrp_nom_fr) as alim_name, 
c.const_code, d.const_nom_fr, c.teneur
from alim a
join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
join compo c on a.alim_code = c.alim_code 
join const d on c.const_code = d.const_code
where isnull(b.tag)

test: 
SELECT * FROM alim_values_details 
WHERE alim_code = ' 1005'	// pas de trim() sur clé, 100x plus long !

ORDER by const_code 	// 10x plus long


- vue générale aliments ajoutés avec constituants, tous, pour controle des NULL

CREATE or replace view alim_add_values_details as

SELECT a.alim_code, a.alim_nom_fr, concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as alim_grp_code,  
b.alim_grp_code as groupe, c.const_code as compo
from alim_add a
left join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
left join compo_add c on a.alim_code = c.alim_code 
order by alim_code



- divers

LOAD XML infile 'C:/Users/fredericm/Desktop/alim_2017 11 21.xml' 
into table alim2 CHARACTER SET UTF8 ROWS IDENTIFIED BY '<ALIM>'

*/
?>	
