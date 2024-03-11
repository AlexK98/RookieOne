<?php
/*
* File: back_init.php
* Author: Alex Kot
* Copyright: 2018 Alex Kot
* Date: 2018/11/09
* EMail: kot.oleksandr.v@gmail.com
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/

if (!isset($_SESSION)) {
	session_name('rookie1');
	session_start();
}

//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', 1);

require_once 'back_vars.php';
require_once 'back_funcs.php';
require_once 'back_funcs_database.php';

// some defines
const FIELD_REQUIRED = 'This field can\'t be empty.';
const FIELD_HACK_WARN = 'Error! Your entered strange text.';
const SIZE_LIMIT = 2000000; //image size limit

// site variables init
$db   = new DatabaseVars();
$user = new UserVars();
$ph   = new Placeholder();
$img  = new ImageVars();

setlocale(LC_ALL, '');

if (!isset($_COOKIE['name'])) {
	setcookie('name', $user->basename, time()+1314000);
}

// connect to host
if (!ConnectToHost($db)) { die; }
