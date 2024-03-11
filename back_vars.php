<?php
/*
* File: back_vars.php
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

class UserVars
{
	public $firstname, $lastname, $email, $pass, $about, $city, $country, $gender;
	public $userImage;
	public $basename;
	public $valid; // bool

	//general message
	public $msg;
	// error messages for placeholders in input fields
	public $firstnameErr, $lastnameErr, $emailErr, $passErr, $aboutErr, $cityErr, $countryErr, $genderErr;

	public function __construct()
	{
		$this->firstnameErr = '';
		$this->firstname = '';

		$this->lastnameErr = '';
		$this->lastname = '';

		$this->emailErr = '';
		$this->email = '';

		$this->passErr = '';
		$this->pass = '';

		$this->aboutErr = '';
		$this->about = '';

		$this->cityErr = '';
		$this->city = '';

		$this->countryErr = '';
		$this->country = '';

		$this->genderErr = '';
		$this->gender = '';

		$this->userImage = '';
		$this->msg = '';
		$this->basename = 'Rookie';
		$this->valid = false;
	}
}

class DatabaseVars
{
	public $host, $user, $pass;
	public $dbName, $dbTable, $dbIndex;
	public $link;

	public function __construct()
	{
		$this->host = 'localhost';
		$this->user = 'root';
		$this->pass = 'mysql';

		$this->dbName   = 'rookie';
		$this->dbTable  = 'users';
		$this->dbIndex  = 'email';
		
		$this->link = mysqli_init();
	}
}

class Placeholder {
	public $first, $last, $email, $pass;
	public $firstStyle, $lastStyle, $emailStyle, $passStyle;
	public $city, $country, $about, $gender;

	public function __construct()
	{
		$this->first   = 'E.g. Sarah';
		$this->last    = 'E.g. Connor';
		$this->email   = 'E.g. sarah@connor.name';
		$this->pass    = 'Some password only you will know';
		$this->city    = 'E.g. Los Angeles';
		$this->country = 'E.g. USA';
		$this->about   = 'E.g. I\'m a fictional character in the Terminator franchise and one of the main protagonists of The Terminator, Terminator 2: Judgment Day and Terminator Genesys.';
		$this->gender  = 'E.g. Male, Female or Other';

		$this->firstStyle = '';
		$this->lastStyle  = '';

		$this->emailStyle = '';
		$this->passStyle  = '';
	}
}

class ImageVars
{
	public $dir, $file2upload, $tempFile, $hash, $mime, $isOK;
	public $msg;

	public function __construct()
	{
		$this->dir         = 'images/';
		$this->file2upload = '_default.jpg';
		$this->tempFile    = '';
		$this->hash        = '';
		$this->mime        = 'none';
		$this->msg         = '';
		$this->isOK        = 0;
	}
}
