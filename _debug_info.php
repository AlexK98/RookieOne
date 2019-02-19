<?php
/*
* File: _debug_info.php
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

// nothing fancy, just debug info output
$debuginfo = false;
if ($debuginfo) {
	echo '<p>SESSION</p>';
	var_dump($_SESSION);

	echo '<p>POST</p>';
	var_dump($_POST);

	echo '<p>COOKIE</p>';
	var_dump($_COOKIE);

	echo '<p>FILES</p>';
	var_dump($_FILES);

	echo '<p>USER</p>';
	var_dump($user);

	echo '<p>IMG</p>';
	var_dump($img);
}

