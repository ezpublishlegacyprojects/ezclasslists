<?php
//
// $Id$
// $HeadURL$
//
// Created on: <14-Jui-2007 15:00 damien pobel>
//
// SOFTWARE NAME: eZ Class Lists
// SOFTWARE RELEASE: 1.1
// COPYRIGHT NOTICE: Copyright (C) 1999-2009 Damien POBEL
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
//

$Module = array( 'name' => 'Lists by content class' );

$ViewList = array();
$ViewList['list'] = array( 'script' => 'list.php',
                           'functions' => array( 'read' ),
                           'default_navigation_part' => 'classlists',
                           'ui_context' => 'view',
                           'params' => array ( 'classIdentifier', 'sortMethod', 'sortOrder', 'ajax' ),
                           'unordered_params' => array('offset' => 'Offset'),
                           'single_post_actions' => array( 'RemoveButton' => 'Remove' ),
                           'post_action_parameters' => array( 'Remove' => array( 'DeleteIDArray' => 'DeleteIDArray' ) ) );


$FunctionList['read'] = array();

?>
