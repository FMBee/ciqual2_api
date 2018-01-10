<?php

	/**
	 * appel PHP par file_get_contents($url)
	 * 
	 * $url = {serveur}/ciqual_api.php?table=?&where=?[values=?][&key=?][mode=_AAC]
	 * table 	: {ingredients, categories}
	 * where 	: {_ALL, _KEY, [recherche]}
	 * 				_ALL : tous les enregistrements
	 * 				_KEY : un enregistrement - associer l'argument [key]
	 * 				[recherche] : partie du nom (%foo%)
	 * values 	: {yes, no} / default:no 	//opère sur ingredients
	 * key		: {ORIGGPCD, ORIGFDCD}
	 * 				ORIGGPCD : code catégorie
	 * 				ORIGFDCD : code ingrédient
	 * mode		: {_AAC, ~} / default:~
	 * 				_AAC : AjaxAutoComplete
	 * 
	 * @return Json file avec ligne(s) de la base ou message 'error' ou message 'norecordsfound'
	 * 
	 * 	$url = '{serveur}/ciqual_api.php?table=categories&where=vian';
	 * 	$url = '{serveur}/ciqual_api.php?table=categories&where=_ALL';
	 * 	$url = '{serveur}/ciqual_api.php?table=ingredients&where=veau';
	 * 	$url = '{serveur}/ciqual_api.php?table=ingredients&where=veau&values=yes';
	 * 	$url = '{serveur}/ciqual_api.php?table=ingredients&where=_ALL';
	 * 	$url = '{serveur}/ciqual_api.php?table=ingredients&where=_KEY&key=21515';
	 * 	$url = '{serveur}/ciqual_api.php?table=ingredients&where=_KEY&key=21515&values=yes';
	 * 	$url = '{serveur}/ciqual_api.php?table=categories&where=_ALL&mode=_AAC';
	 */

	session_start();
	header('Content-Type: application/json; charset=UTF-8');

	include('defines.php');
	
	$_MESS = array(
			'Arguments incomplets.',
			'Argument invalide.',
			'Argument manquant.',
			'Aucun enregistrement trouvé.',
			'Erreur de connexion.'
	);
	$_TABLE = array(
				array(
					'alim',
// 					'ingredients',
				),
				array(
					'alim' => 'alim',
// 					'categories' => 'cat'
				)
	);
	$_WHERE = array(
					'_ALL',
					'_KEY'
	);
	$_VALUES = array(
					'yes',
					'no'
	);
	$_MODE = array(
					'_AAC'
	);
	
	if (! empty($error = valid_url()) )	error($error);
	
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
	$mode	= $_GET['mode'];
	
	$sql = 'SELECT *';
	$sql .= ' FROM ' .$table;
	$sql .= ( $table == $_TABLE[0][0] && $values == $_VALUES[0] ? '_values' : '' );
	$sql .= '_details ';
	
	switch ($where) {
		case $_WHERE[0]:
			$sql .= '';
			break;
		case $_WHERE[1]:
			$sql .= ' WHERE prefix_code = ' .$key;
			break;
		default: 
			$sql .= " WHERE prefix_name LIKE '%" .$where ."%'"; 
	}
	$sql .= ' ORDER BY prefix_name ';
	
	$sql = str_replace('prefix', $_TABLE[1][$table], $sql);
	
	$req = $pdo->prepare($sql);
	$req->execute();
	$data = $req->fetchAll(PDO::FETCH_ASSOC);

	if (!$data)	{
		
		$data = array( 'return' => $_MESS[3] .'-'.$sql);
	}
	else{
		if (!empty($mode)) {
			
			$data = call_user_func('format' .$mode, $data);
		}
	}
	
//	echo $sql .'<br/>';
	echo json_encode($data);
	exit();
	
	
	
//-------------------	

	function format_AAC($data) {
	
		$result = [];
		$prefix = $GLOBALS['_TABLE'][1][$GLOBALS['table']];
		
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
		
		global $_MESS;
		
		if (!isset($_GET['table']) | !isset($_GET['where']))	return $_MESS[0];

		if (!in_array($_GET['table'], $GLOBALS['_TABLE'][0]))	return $_MESS[1];

		if ($_GET['where'] == $GLOBALS['_WHERE'][1] && (!isset($_GET['key']) | empty($_GET['key'])))	return $_MESS[2];

	}
	
	function set_defaults() {
		
		if (!isset($_GET['values']) || !in_array($_GET['values'], $GLOBALS['_VALUES']))  $_GET['values'] = $GLOBALS['_VALUES'][1];

		if (!isset($_GET['key'])) $_GET['key'] = '';

		if (!isset($_GET['mode']) || !in_array($_GET['mode'], $GLOBALS['_MODE'])) $_GET['mode'] = '';
		
		array_walk($_GET, 'myTrim');
	}
	
	function myTrim(&$value) {
		
		$value = trim($value);
	}
	
	function error($message) {
		
		echo json_encode( array('error' => $message));
		exit();
	}
	