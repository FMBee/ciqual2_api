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
print_r($sql); 	

 		$req = $pdo->prepare($sql);
 		$req->execute();
 	}


/* 	

- importation des exclusions de groupes

CREATE TABLE `alim_grp_not` (
  `alim_grp_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `alim_ssgrp_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `alim_ssssgrp_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA INFILE 'C:/xampp/htdocs/workdev/ciqual2_api/Code a exclure table Ciqual 2017.csv' 
INTO TABLE alim_grp_not 
CHARACTER SET UTF8 FIELDS TERMINATED BY ';' ENCLOSED BY '' LINES TERMINATED BY '\n'

ALTER TABLE `alim_grp` ADD `tag` VARCHAR(1) NULL AFTER `alim_ssssgrp_nom_eng`;

- tag des groupes à exclure

UPDATE alim_grp a
SET tag = 'E' 
where concat(trim(a.alim_grp_code), trim(a.alim_ssgrp_code), trim(a.alim_ssssgrp_code)) 
IN (SELECT concat(trim(b.alim_grp_code), trim(b.alim_ssgrp_code), trim(b.alim_ssssgrp_code)) from alim_grp_not b)

- liste des aliments exclus 

CREATE or replace view alim_exclus as

SELECT a.alim_code, a.alim_nom_fr, 
concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie, 
concat(b.alim_ssgrp_nom_fr, ' / ', b.alim_ssssgrp_nom_fr) as libelle 
from alim a 
join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code 
= b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
where b.tag = 'E' 
order by categorie, a.alim_nom_fr


-liste des aliments avec categorie

CREATE or replace view alim_details as

SELECT a.alim_code, a.alim_nom_fr, concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie,  
concat(a.alim_nom_fr, ' - ', b.alim_ssssgrp_nom_fr, ' - ', b.alim_ssgrp_nom_fr) as alim_name
from alim a
join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code
where isnull(b.tag)
order by categorie, a.alim_nom_fr


- liste des aliments sans categorie valide

SELECT a.alim_code, a.alim_nom_fr, 
concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie, 
concat(b.alim_ssgrp_nom_fr, ' / ', b.alim_ssssgrp_nom_fr) as libelle, b.tag 
from alim a left join alim_grp b 
on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
where isnull(concat(b.alim_ssgrp_nom_fr, ' / ', b.alim_ssssgrp_nom_fr)) 
order by categorie, a.alim_nom_fr


- vue générale aliments avec constituants

SELECT a.alim_code, a.alim_nom_fr, concat(trim(a.alim_grp_code),'-',trim(a.alim_ssgrp_code),'-',trim(a.alim_ssssgrp_code)) as categorie,  
concat(b.alim_ssgrp_nom_fr, ' / ', b.alim_ssssgrp_nom_fr) as libelle, 
c.const_code, d.const_nom_fr, c.teneur
from alim a
join alim_grp b on a.alim_grp_code+a.alim_ssgrp_code+a.alim_ssssgrp_code = b.alim_grp_code+b.alim_ssgrp_code+b.alim_ssssgrp_code 
join compo c on 
a.alim_code = c.alim_code 
join const d on 
c.const_code = d.const_code


- divers

LOAD XML infile 'C:/Users/fredericm/Desktop/alim_2017 11 21.xml' 
into table alim2 CHARACTER SET UTF8 ROWS IDENTIFIED BY '<ALIM>'

*/
?>	
