<?php
/*
* File: sign_out.php
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

require 'back_init.php';

$temp = $_SESSION['dbCreated'];
$_SESSION = array();
session_unset();
session_destroy();

session_start();
$_SESSION['dbCreated'] = $temp;
setcookie('name', $user->basename, time()+1314000);

header('Location: index.php');
