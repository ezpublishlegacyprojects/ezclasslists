<?php
// Created on: <14-Jui-2007 15:00 damien pobel>
//
// SOFTWARE NAME: eZ Class Lists
// SOFTWARE RELEASE: 1.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 Damien POBEL
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

$http = eZHTTPTool::instance();
$listIni = eZINI::instance( 'lists.ini' );

$Module = $Params["Module"];
$hasPost = false;
$ajax = false;

$classIdentifier = '';
if ( isset( $Params['classIdentifier'] ) )
{
    $classIdentifier = $Params['classIdentifier'];
}
if ( $http->hasPostVariable( 'classIdentifier' ) )
{
    $classIdentifier = $http->postVariable( 'classIdentifier' );
    $hasPost = true;
}

$sortMethod = $listIni->variable( 'ListSettings', 'DefaultSortMethod' );
if ( isset( $Params['sortMethod'] ) )
{
    $sortMethod = $Params['sortMethod'];
}
if ( $http->hasPostVariable( 'sortMethod' ) )
{
    $sortMethod = $http->postVariable( 'sortMethod' );
    $hasPost = true;
}

$sortOrder = $listIni->variable( 'ListSettings', 'DefaultSortOrder' );
if ( isset( $Params['sortOrder'] ) )
{
    $sortOrder = $Params['sortOrder'];
}
if ( $http->hasPostVariable( 'sortOrder' ) )
{
    $sortOrder = $http->postVariable( 'sortOrder' );
    $hasPost = true;
}

if ( isset( $Params['ajax'] ) )
{
    $ajax = true;
}

if ( $hasPost && !$ajax )
{
    // converting post variables into ordered parameters
    $Module->redirectToView( 'list', array( $classIdentifier,
                                            $sortMethod,
                                            $sortOrder ) );
}

$offset = $Params['Offset'];
if( !is_numeric( $offset ) )
{
    $offset = 0;
}

include_once( 'kernel/common/template.php' );
$tpl = templateInit();
$tpl->setVariable( 'sort_method', $sortMethod );
if ( $sortOrder === 'ascending' )
{
    $sortOrderTemplate = true;
}
else
{
    $sortOrderTemplate = false;
}
$tpl->setVariable( 'sort_order', $sortOrderTemplate );


if ( $Module->isCurrentAction('Remove') )
{
    if ( $http->hasPostVariable( 'MoveToTrash' ) && $http->postVariable( 'MoveToTrash' ) == '1' )
    {
        $moveToTrash = true;
    }
    else
    {
        $moveToTrash = false;
    }
    if ( $Module->hasActionParameter( 'DeleteIDArray' ) )
    {
        $nodeIDList = $Module->actionParameter( 'DeleteIDArray' );
        if ( is_array( $nodeIDList ) )
        {
            $removeCount = 0;
            foreach( $nodeIDList as $nodeID )
            {
                $node = eZContentObjectTreeNode::fetch( $nodeID );
                if ( !$node )
                {
                    continue ;
                }
                if ( $node->canRemove() )
                {
                    $node->removeNodeFromTree( $moveToTrash );
                    $removeCount++;
                }
            }
            $tpl->setVariable( 'remove_count', $removeCount );
        }
    }
}

$path = array( array( 'url' => 'classlists/list',
                      'text' => ezi18n( 'classlists/list', 'Lists by content class' ) ) );

if ( $classIdentifier != '' )
{
    $classObject = eZContentClass::fetchByIdentifier( $classIdentifier );
    if ( is_object( $classObject ) )
    {
        $page_uri = trim( $Module->redirectionURI( 'classlists', 'list', array( $classIdentifier,
                                                                                $sortMethod,
                                                                                $sortOrder ) ), '/' );
        $path[] = array( 'url' => $page_uri,
                         'text' => ezi18n( 'classlists/list', '%classname objects',
                                           false, array('%classname' => $classObject->attribute( 'name' ) ) ) );
        $tpl->setVariable( 'class_identifier', $classIdentifier );
        $tpl->setVariable( 'page_uri', $page_uri );
    }
    else
    {
        $page_uri = trim( $Module->redirectionURI( 'classlists', 'list', array( '', $sortMethod,
                                                                                $sortOrder ) ), '/' );
        $tpl->setVariable( 'page_uri', $page_uri );
        $tpl->setVariable( 'class_identifier', false );
        $tpl->setVariable( 'error', ezi18n( 'classlists/list',
                                    '%class_identifier is not a valid content class identifier.',
                                    false, array( '%class_identifier' => $classIdentifier ) )  );
    }

}
else
{
    $tpl->setVariable( 'page_uri', 'classlists/list//' . $sortMethod . '/' . $sortOrder );
    $tpl->setVariable( 'class_identifier', false );
}

$tpl->setVariable( 'view_parameters', array( 'offset' => $offset ) );

if ( $ajax )
{

    $http->setSessionVariable( "LastAccessesURI", $tpl->variable( 'page_uri' ) );
    echo $tpl->fetch( 'design:classlists/list.tpl' );
    eZDB::checkTransactionCounter();
    eZExecution::cleanExit();
}
else
{
    $Result['content'] = $tpl->fetch( 'design:classlists/list.tpl' );
    $Result['left_menu'] = 'design:classlists/menu.tpl';
    $Result['path'] = $path;
}
?>
