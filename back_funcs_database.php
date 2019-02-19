<?php
/*
* File: back_funcs_database.php
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


// =====================================
// DATABASE FUNCTIONS ==================
// =====================================
function ConnectToHost(DatabaseVars $db) {
	$db->link = new mysqli($db->host, $db->user, $db->pass);
	if (!$db->link) {
		$_SESSION['msgDB'] = 'Connect error: ' . $db->link->connect_errno . '.' . $db->link->connect_error;
		die('Connect error: ' . $db->link->connect_errno . '.' . $db->link->connect_error);
	}
	$_SESSION['msgDB'] = 'Connection is OK!';
	return true;
}

function CheckConnectionToHost(DatabaseVars $db)
{
	if (!$db->link->stat()) {
		$_SESSION['msgDB'] = 'Server is offline. ' . $db->link->error;
		return false;
	}
	$_SESSION['msgDB'] = 'Server is online.';
	return true;
}

function SelectDB(DatabaseVars $db)
{
	if (!$db->link->select_db($db->dbName)) {
		$_SESSION['msgDB'] = 'Sorry, Select DB failed. ' . $db->link->error;
		return false;
	}
	$_SESSION['msgDB'] = 'DB selected.';
	return true;
}

function CreateDB(DatabaseVars $db)
{
	$sql = "CREATE DATABASE IF NOT EXISTS $db->dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

	$result = $db->link->query($sql); //OBJECT, TRUE or FALSE
	if ($result === FALSE) {
		$_SESSION['msgDB'] = "Error creating database '$db->dbName': " . $db->link->error;
   	return false;
	}
	$_SESSION['msgDB'] = "Database '$db->dbName' created.";
	return true;
}

function CreateTable(DatabaseVars $db)
{
	$sql = "CREATE TABLE IF NOT EXISTS $db->dbName.$db->dbTable (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(100) NOT NULL,
			lastname VARCHAR(100) NOT NULL,
			email VARCHAR(255) NOT NULL,
			pass VARCHAR(255) NOT NULL,
			about VARCHAR(255) NOT NULL,
			city VARCHAR(60) NOT NULL,
			country VARCHAR(60) NOT NULL,
			gender VARCHAR(60) NOT NULL,
			userimage VARCHAR(255) NOT NULL DEFAULT '_default.jpg',
			active BOOLEAN NOT NULL DEFAULT FALSE
		)";

	if ($db->link->query($sql) === FALSE) {
		$_SESSION['msgDB'] = 'Error creating table: ' . $db->dbTable . '. ' . $db->link->error;
		return false;
	}
	return true;
}

function CreateTableIndex(DatabaseVars $db)
{
	$sql = "CREATE INDEX email_index ON $db->dbName.$db->dbTable ($db->dbIndex) USING BTREE;";
	$result = $db->link->query($sql);

	if ($result === FALSE) {
		$_SESSION['msgDB'] = 'Error creating Index for ' . $db->dbTable . ': ' . $db->link->error;
		return false;
	}
	$_SESSION['msgDB'] = "Index for 'email' created.";
	return true;
}

function InitDB(DatabaseVars $db)
{
	$_SESSION['dbCreated'] = 0;
	$cdb = CreateDB($db);
	$ctb = CreateTable($db);
	$cti = CreateTableIndex($db);
	if (!$cdb && !$ctb && $cti) {
		$_SESSION['msgDB'] = 'Can not access database or create tables in it';
		return false;
	}
	$_SESSION['msgDB'] = "Database '$db->dbName' with indexed table '$db->dbTable' created.";
	$_SESSION['dbCreated'] = 1;
	return true;
}

function ResetDB(DatabaseVars $db)
{
	if (!SelectDB($db)) { return false; }

	$sql = "DROP DATABASE $db->dbName";

	$result = $db->link->query($sql);

	if (!$result) {
		$_SESSION['msgDB'] = 'Could not DROP database ' . $db->dbName;
		return false;
	}

	$_SESSION[] = array();
	session_unset();

	$_SESSION['logged_in'] = false;
	$_SESSION['dbCreated'] = 0;
	$_SESSION['msgDB'] = "Database '$db->dbName' dropped.";

	return true;
}
