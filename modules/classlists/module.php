<?php

$Module = array( 'name' => 'Lists by class' );

$ViewList = array();
$ViewList['list'] = array(
    'script' => 'list.php',
    'functions' => array( 'read' ),
	'default_navigation_part' => 'classlists',
	'ui_context' => 'view',
    'params' => array ( 'classIdentifier' ),
	'unordered_params' => array('offset' => 'Offset'),
    'single_post_actions' => array( 'RemoveButton' => 'Remove' ),
	'post_action_parameters' => array( 'Remove' => array( 'DeleteIDArray' => 'DeleteIDArray' ) )
	);


$FunctionList['read'] = array();

?>
