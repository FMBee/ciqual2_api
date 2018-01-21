<?php

	define('_CIQUAL_PATH', 	'.\\');		// dossier courant
	define('_MODEL_FILE', 	'XXX_2017 11 21.xml');		// modèle des fichiers XML (alim, alim_grp, ...)
	
	$_LIST_FILES = array(
			'alim',
			'alim_grp',
			'compo',
			'const',
// 			'sources'	// inutile et volumineux
	);

	define('_DBSERVER',	'mysql:host=localhost;dbname=ciqual2_api');
	define('_DBUSER',	'root');
	define('_DBPWD',	'');
	
	