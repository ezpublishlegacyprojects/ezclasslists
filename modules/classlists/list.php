<?php
include_once( 'kernel/classes/ezcontentclass.php' );
include_once( 'kernel/classes/ezcontentobjecttreenode.php' );
include_once( 'kernel/common/template.php' );

$http =& eZHTTPTool::instance();
$Module =& $Params["Module"];


//echo '<!-- ';
//print_r($Params);
//echo '-->';

$classIdentifier = $Params['classIdentifier'];

$offset = $Params['Offset'];
if( !is_numeric( $offset ) )
	$offset = 0;

$tpl =& templateInit();
if ( $Module->isCurrentAction('Remove') )
{
	$nodeIDList = $Module->actionParameter( 'DeleteIDArray' );
	if ( is_array($nodeIDList) )
	{
		$remove_count = 0;
		foreach( $nodeIDList as $nodeID )
		{
			$node =& eZContentObjectTreeNode::fetch( $nodeID );
			if ( !$node )
				continue ;
			if ( $node->canRemove() )
			{
				$node->remove();
				$remove_count++;
			}
		}
		$tpl->setVariable( 'remove_count', $remove_count );
	}
}

$path = array( array('url' => 'classlists/list', 'text' => ezi18n( 'classlists/list', 'Lists by class' ) ) );

if ( $classIdentifier != '' )
{
	$classObject = eZContentClass::fetchByIdentifier( $classIdentifier );
	if ( is_object( $classObject ) )
	{
		$page_uri = 'classlists/list/' . $classIdentifier;
		$path[] = array(
					'url' => $page_uri,
					'text' => ezi18n('classlists/list', '%classname objects', false, array('%classname' => $classObject->attribute( 'name' ) ) )
					);
		$tpl->setVariable( 'class_identifier', $classIdentifier );
		$tpl->setVariable( 'page_uri', $page_uri );
	}
	else
	{
		$tpl->setVariable( 'page_uri', 'classlists/list' );
		$tpl->setVariable( 'class_identifier', false);
		$tpl->setVariable( 'error', ezi18n('classlists/list', '%class_identifier is not a valid content class identifier.', false, array('%class_identifier' => $classIdentifier) ) );
	}

}
else
{
	$tpl->setVariable( 'page_uri', 'classlists/list' );
	$tpl->setVariable( 'class_identifier', false );
}

$tpl->setVariable( 'view_parameters', array( 'offset' => $offset ) );

$Result = array();
$Result['content'] =& $tpl->fetch( 'design:classlists/list.tpl' );
// $Result['left_menu'] = 'design:classlists/menu.tpl'; seems to not work ?
$Result['left_menu'] = 'extension/ezclasslists/design/standard/templates/classlists/menu.tpl';
$Result['path'] = $path;


?>
