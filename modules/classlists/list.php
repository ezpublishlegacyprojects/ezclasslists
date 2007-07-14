<?php
// Created on: <14-Jui-2007 15:00 damien pobel>
//
// SOFTWARE NAME: eZ Class Lists
// SOFTWARE RELEASE: 0.1
// BUILD VERSION: 1
// COPYRIGHT NOTICE: Copyright (C) 1999-2007 Damien POBEL
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.

include_once( 'kernel/classes/ezcontentclass.php' );
include_once( 'kernel/classes/ezcontentobjecttreenode.php' );
include_once( 'kernel/common/template.php' );

$http =& eZHTTPTool::instance();
$Module =& $Params["Module"];


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

$path = array( array('url' => 'classlists/list', 'text' => ezi18n( 'classlists/list', 'Lists by content class' ) ) );

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
		$tpl->setVariable( 'error', ezi18n('classlists/list',
									'%class_identifier is not a valid content class identifier.',
									false, array('%class_identifier' => $classIdentifier) )
						);
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
// $Result['left_menu'] = 'design:classlists/menu.tpl';
// seems to not work, bug ?
$Result['left_menu'] = 'extension/ezclasslists/design/standard/templates/classlists/menu.tpl';
$Result['path'] = $path;


?>
