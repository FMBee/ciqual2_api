<?php

	/**
	 * appel PHP par [$data = file_get_contents($url);]
	 * 
	 * recherche par defaut sur le nom d'un aliment et ses deux sous-categories
	 * alim_name = concat(a.alim_nom_fr, ' | ', b.alim_ssssgrp_nom_fr, ' | ', b.alim_ssgrp_nom_fr)
	 * la categorie (alim_grp_nom_gr) n'est pas intégrée car trop générale
	 * 
	 * API:
	 * $url = {serveur}/ciqual_api.php?table=?&where=?[values=?][&key=?][mode=_AAC]
	 * table 	: {alim, alim_grp}
	 * where 	: {_ALL, _KEY, [recherche]}
	 * 				_ALL : tous les enregistrements
	 * 				_KEY : un enregistrement -> associer l'argument [key]
	 * 				_CAT : ingredients d'une catégories -> associer l'argument [key={alim_grp_code}]
	 * 				[recherche] : partie du nom (%foo%)
	 * values 	: {yes, no} / default:no 	//opère sur ingredients
	 * key		: {alim_code, alim_grp_code}
	 * order	: champs tri des résultats / default(auto):{alim_name}
	 * mode		: {_AAC, ~} / default:~
	 * 				_AAC : AjaxAutoComplete	-> positionner [where=xx]
	 * 
	 * @return Json file avec ligne(s) de la base ou message 'error' ou message 'norecordsfound'
	 * 
	 * 	$url = '{serveur}/ciqual_api.php?table=alim_grp&where=vian';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim_grp&where=_ALL';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim&where=veau';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim&where=veau&values=yes';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim&where=_ALL';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim&where=_KEY&key=21515';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim&where=_KEY&key=21515&values=yes';
	 * 	$url = '{serveur}/ciqual_api.php?table=alim_grp&where=_ALL&mode=_AAC';
	 */

	session_start();
	header('Content-Type: application/json; charset=UTF-8');
// print_r($_GET);	

	include('defines.php');
	
	$_MESS = array(
			'Arguments incomplets.',
			'Argument invalide.',
			'Argument manquant.',
			'Aucun enregistrement trouvé.',
			'Erreur de connexion.'
	);
	$_TABLE = array(
					'alim',
					'alim_grp'
	);
	$_PREFIX = array(
					'alim' => 'alim',
					'alim_grp' => 'alim_grp'
	);
	$_WHERE = array(
					'_ALL',
					'_KEY',
					'_CAT'
	);
	$_VALUES = array(
					'yes',
					'no'
	);
	$_MODE = array(
					'_AAC'
	);
	if (! empty($error = valid_url()) )		 { error($error); }
	
	try {
		$pdo = new PDO(_DBSERVER, _DBUSER, _DBPWD);
		$pdo->query('SET NAMES UTF8');
		
	} catch (Exception $e) {
		error($_MESS[4]);
	}

	set_defaults();
	
	$table 	= $_GET['table'];
	$where	= $_GET['where'];
	$values	= $_GET['values'];
	$key	= $_GET['key'];
	$order	= $_GET['order'];
	$mode	= $_GET['mode'];
	
	set_specials();
	
	$sql = 'SELECT *';
	$sql .= ' FROM ' .$table;
	$sql .= ( $table == $_TABLE[0] && $values == $_VALUES[0] ? '_values' : '' );	//valeurs ingrédient
	$sql .= '_details ';
	
	switch ($where) {
		
		case $_WHERE[0]:
			$sql .= '';
			break;
		case $_WHERE[1]:
			$sql .= " WHERE prefixX_code = '{$key}'";
			break;
		case $_WHERE[2]:
			$sql .= " WHERE prefix1_code = '{$key}'";
			break;
		default: 
			$sql .= " WHERE prefixX_name LIKE '%{$where}%'"; 
	}
	
	$sql .= ' ORDER BY ' .$order;
	
	$sql = str_replace('prefixX', $_PREFIX[ $table ], $sql);
	$sql = str_replace('prefix0', $_PREFIX[ $_TABLE[0] ], $sql);
	$sql = str_replace('prefix1', $_PREFIX[ $_TABLE[1] ], $sql);

	$req = $pdo->prepare($sql);
	$req->execute();
	$data = $req->fetchAll(PDO::FETCH_ASSOC);
	
	if ( !is_array($data) )	{
		
		$data = array( 'return' => $_MESS[3] .'-'.$sql);
	}
	else{
		if (!empty($mode)) {
			
			$data = call_user_func('format' .$mode, $data);
		}
	}
	
// 	echo $sql .'<br/>';
	echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	
	exit();
	
	
	
//-------------------	

	function format_AAC($data) {
	
		$result = [];
		$prefix = $GLOBALS['_PREFIX'][$GLOBALS['table']];
		
		foreach ($data as $element) {
		
			$result[] = array( 
					"value" => $element[$prefix .'_name'],	
					"data" 	=> $element[$prefix .'_code'] 
			);
		}
		return array( 	"query" => "Unit",
						"suggestions" => $result );
	}
	
	function valid_url() {
		
		if (!isset($_GET['table']) | !isset($_GET['where']))	return $GLOBALS['_MESS'][0];

		if (!in_array($_GET['table'], $GLOBALS['_TABLE']))	return $GLOBALS['_MESS'][1];

		if ($_GET['where'] == $GLOBALS['_WHERE'][1] && (!isset($_GET['key']) | empty($_GET['key'])))	return $GLOBALS['_MESS'][2];
		
		if ($_GET['where'] == $GLOBALS['_WHERE'][2] && (!isset($_GET['key']) | empty($_GET['key'])))	return $GLOBALS['_MESS'][2];

	}
	
	function set_defaults() {
		
		if (!isset($_GET['values']) || !in_array($_GET['values'], $GLOBALS['_VALUES']))  $_GET['values'] = $GLOBALS['_VALUES'][1];

		if (!isset($_GET['key'])) $_GET['key'] = '';

		if (!isset($_GET['mode']) || !in_array($_GET['mode'], $GLOBALS['_MODE'])) $_GET['mode'] = '';

		if (!isset($_GET['order'])) $_GET['order'] = 'prefixX_name';
		
// 		array_walk($_GET, 'myTrim');
	}
	
	function set_specials() {
		
		//mode AAC
		if ($GLOBALS['mode'] == $GLOBALS['_MODE'][0])	$GLOBALS['where'] = $_GET['query'];
		
	}
	
	function myTrim(&$value) {
		
		$value = trim($value);
	}
	
	function error($message) {
		
		echo json_encode( array('error' => $message .' - ' .print_r($_GET, true)));
		exit();
	}

