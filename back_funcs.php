<?php
/*
* File: back_funcs.php
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

// ===============================================================
// Validate UserData =============================================
// ===============================================================
function isEmpty($data) {
	if (empty(trim($data))) { return true; }
	return false;
}
function Sanitize($data) {
	if (is_string($data)) {
		return filter_var(strip_tags($data), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
	}
	if (is_int($data)) {
		return (int)filter_var($data, FILTER_SANITIZE_NUMBER_INT);
	}
	if (is_float($data)) {
		return (float)filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
	}
	return false;
}

function ValidateFirstName(UserVars $user) {
	if (isEmpty($_POST['firstname'])) {
		$user->firstnameErr = FIELD_REQUIRED;
		return false;
	}
	if ($_POST['firstname'] !== Sanitize($_POST['firstname'])) {
		$user->firstnameErr = FIELD_HACK_WARN;
		return false;
	}
	$user->firstname = Sanitize($_POST['firstname']);
	return true;
}
function ValidateLastName(UserVars $user) {
	if (isEmpty($_POST['lastname'])) {
		$user->lastnameErr = FIELD_REQUIRED;
		return false;
	}
	if ($_POST['lastname'] !== Sanitize($_POST['lastname'])) {
		$user->lastnameErr = FIELD_HACK_WARN;
		return false;
	}
	$user->lastname = Sanitize($_POST['lastname']);
	return true;
}
function ValidateEmail(UserVars $user) {
	if (isEmpty($_POST['email'])) {
		$user->emailErr = FIELD_REQUIRED;
		return false;
	}
	$user->email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_EMAIL);
	$user->email = filter_var($user->email, FILTER_VALIDATE_EMAIL);
	if ($user->email === false) {
		$user->emailErr = 'Please enter valid email address.';
		return false;
	}
	return true;
}
function ValidatePassword(UserVars $user) {
	if (isEmpty($_POST['password'])) {
		$user->passErr = FIELD_REQUIRED;
		return false;
	}
	if ($_POST['password'] !== Sanitize($_POST['password'])) {
		$user->passErr = FIELD_HACK_WARN;
		return false;
	}
	$user->pass = Sanitize($_POST['password']);
	return true;
}
function ValidateAbout(UserVars $user) {
	if ($_POST['about'] !== Sanitize($_POST['about'])) {
		$user->aboutErr = FIELD_HACK_WARN;
		return false;
	}
	$user->about = Sanitize($_POST['about']);
	return true;
}
function ValidateCity(UserVars $user) {
	if ($_POST['city'] !== Sanitize($_POST['city'])) {
		$user->cityErr = FIELD_HACK_WARN;
		return false;
	}
	$user->city = Sanitize($_POST['city']);
	return true;
}
function ValidateCountry(UserVars $user) {
	if ($_POST['country'] !== Sanitize($_POST['country'])) {
		$user->countryErr = FIELD_HACK_WARN;
		return false;
	}
	$user->country = Sanitize($_POST['country']);
	return true;
}
function ValidateGender(UserVars $user) {
	if ($_POST['gender'] !== Sanitize($_POST['gender'])) {
		$user->genderErr = FIELD_HACK_WARN;
		return false;
	}
	$user->gender = Sanitize($_POST['gender']);
	return true;
}

function ValidateInput(UserVars $user) {
	if ($_POST['submit'] === 'SignUp') {
		$fn = ValidateFirstName($user);
		$ln = ValidateLastName($user);
		$em = ValidateEmail($user);
		$pw = ValidatePassword($user);

		if ($fn && $ln && $em && $pw) {
			$user->valid = true;
		} else {
			$user->valid = false;
		}
	}

	if ($_POST['submit'] === 'SignIn') {
		$em = ValidateEmail($user);
		$pw = ValidatePassword($user);

		if ($em && $pw) {
			$user->valid = true;
		} else {
			$user->valid = false;
		}
	}

	if ($_POST['submit'] === 'UserData') {
		$fn = ValidateFirstName($user);
		$ln = ValidateLastName($user);
		$ab = ValidateAbout($user);
		$ci = ValidateCity($user);
		$co = ValidateCountry($user);
		$ge = ValidateGender($user);

		if ($fn && $ln && $ab && $ci && $co && $ge) {
			$user->valid = true;
		}	else {
			$user->valid = false;
		}
	}

	if (!$user->valid) {
		$user->msg = 'Input validation failed.';
		return false;
	}
	return true;
}

function ValidateFileName($data) {
	if (!isset($data)) { return false; }
	$name = Sanitize(basename($data));
	return basename($data) === $name;
}
function ValidateMIMEType(ImageVars $img) {
//	$check = getimagesize($img->tempFile);
//	if (is_array($check)) {
//		$exploded = explode('/', $check['mime']);
//		$img->mime = end($exploded);
//	}
//	if ($img->mime !== 'gif' && $img->mime !== 'jpeg' && $img->mime !== 'png') {
//		$img->msg = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
//		return false;
//	}
	$img->mime = image_type_to_mime_type(exif_imagetype($img->tempFile));
	if ($img->mime !== 'image/gif' && $img->mime !== 'image/jpeg' && $img->mime !== 'image/png') {
		$img->msg = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
		return false;
	}
	return true;
}

// ===============================================================
// SIGN IN =======================================================
// ===============================================================

// Sign In: Check if email is registered in DB
function CheckEmail(DatabaseVars $db, UserVars $user)
{
	$sql = "SELECT email FROM $db->dbName.$db->dbTable WHERE email = '$user->email'";

	// if !==0 ----> email is in DB, already registered
	//    else ----> no email in DB, not registered
	return $db->link->query($sql)->num_rows !== 0;
}
// Sign In: Check if passwords match
function CheckPasswords(DatabaseVars $db, UserVars $user)
{
	$sql = "SELECT pass FROM $db->dbTable WHERE email = '$user->email'";
	
	$query = $db->link->query($sql);
	$row = $query->fetch_array();

	// if no match
	if (!password_verify($user->pass, $row['pass'])) {
		$user->passErr = 'You entered wrong password';
		return false;
	}
	return true; // if match
}
// Sign In: actual sign in processing
function SignIn(DatabaseVars $db, UserVars $user)
{
	if (!SelectDB($db))              {return false;}
	if (!ValidateInput($user))       {return false;}
	if (!CheckEmail($db, $user)) {
		$user->emailErr = 'Email is not registered. Please, sign up first.';
		return false;
	}
	if (!CheckPasswords($db, $user)) {return false;}

	GetUserData($db, $user);

	$_SESSION['logged_in'] = true;
	$_SESSION['email'] = $user->email;
	header('Location: profile.php');
	return true;
}

// ===============================================================
// SIGN UP =======================================================
// ===============================================================

// Sign Up: Add user to database
function AddUser(DatabaseVars $db, UserVars $user)
{
	$hashedPass = password_hash($user->pass, PASSWORD_DEFAULT);
	$sql = "INSERT INTO $db->dbName.$db->dbTable (firstname, lastname, email, pass) VALUES ('$user->firstname', '$user->lastname', '$user->email', '$hashedPass')";
	
	if ($db->link->query($sql) === FALSE) {
		$user->msg = 'Sorry, '. $user->basename .'. Sign up failed! ' . $db->link->error;
		return false;
	}

	$cookie = setcookie('name', $user->firstname, time()+1314000);
	if ($cookie) { $_SESSION['cookie'] = 'Cookie is set';}
	$_SESSION['email'] = $user->email;
	$_SESSION['logged_in'] = TRUE;
	header('Location: profile.php');
	return true;
}
// Sign Up: actual sign up processing
function SignUp(DatabaseVars $db, UserVars $user)
{
	if (!SelectDB($db))         {return false;}
	if (!ValidateInput($user))  {return false;}
	if (CheckEmail($db, $user)) {
		$user->emailErr = "'$user->email' is already registered.";
		return false;
	}

	AddUser($db, $user);
	return true;
}

// ===============================================================
// PROFILE =======================================================
// ===============================================================

// Profile: updates user data
function UpdateUserData(DatabaseVars $db, UserVars $user) {
	if (!SelectDB($db)) { return false; }
	$user->firstname = Sanitize($_POST['firstname']);
	$user->lastname  = Sanitize($_POST['lastname']);
	$user->about     = Sanitize($_POST['about']);
	$user->city      = Sanitize($_POST['city']);
	$user->country   = Sanitize($_POST['country']);
	$user->gender    = Sanitize($_POST['gender']);

	$sql = "UPDATE $db->dbName.$db->dbTable SET firstname = '$user->firstname', lastname = '$user->lastname', about = '$user->about', city = '$user->city', country = '$user->country', gender = '$user->gender' WHERE email = '$user->email'";
	$query = $db->link->query($sql);

	if (!$query) {
		$user->msg = 'Sorry, profile update failed! ' . $db->link->error;
		return false;
	}

	$user->msg = 'Profile updated successfully!';
	return true;
}
// Profile: updates user image
function UpdateUserImage(DatabaseVars $db, UserVars $user, ImageVars $img) {
	if (!SelectDB($db)) {return false;}

	$sql = "UPDATE $db->dbName.$db->dbTable SET userimage = '$img->file2upload' WHERE email = '$user->email'";
	$query = $db->link->query($sql);

	if (!$query) {
		$img->msg = 'Sorry, image update failed! ' . $db->link->error;
		$img->isOK = 0;
		return false;
	}
	$img->msg = 'Image update successful!';
	$img->isOK = 1;
	return true;
}
// Profile: retrieve user data from DB
function GetUserData(DatabaseVars $db, UserVars $user) {
	if (!SelectDB($db)) {return false;}

	$sql = "SELECT * FROM $db->dbName.$db->dbTable WHERE email='$user->email'";

	$query = $db->link->query($sql);
	if ($query === false) {
		$user->msg = 'Can not read profile data from database';
		return false;
	}

	$row = $query->fetch_assoc();
	$user->firstname = $row['firstname'];
	$user->lastname  = $row['lastname'];
	$user->email     = $row['email'];
	$user->about     = $row['about'];
	$user->city      = $row['city'];
	$user->country   = $row['country'];
	$user->gender    = $row['gender'];
	$user->userImage = $row['userimage'];
	return true;
}
// Profile: retrieve name of currently assigned user image from DB
function GetUserImage(DatabaseVars $db, UserVars $user, ImageVars $img) {
	if (!SelectDB($db)) {return false;}

	$sql = "SELECT userimage FROM $db->dbName.$db->dbTable WHERE email = '$user->email'";

	$row = $db->link->query($sql)->fetch_assoc();
	$user->userImage  = $row['userimage'];
	$img->file2upload = $row['userimage'];
	return true;
}
// Profile: upload profile image to proper folder
function UploadImage(ImageVars $img) {
	//check filename of file being uploaded
	if (!ValidateFileName($_FILES['file2Upload']['name'])) {
		$img->msg = 'Filename is strange.';
		return false;
	}
	$img->file2upload = $_FILES['file2Upload']['name'];

	//check filename of temp file
	if (!ValidateFileName($_FILES['file2Upload']['tmp_name'])) {
		$img->msg = 'Temporary filename is strange.';
		return false;
	}
	$img->tempFile = $_FILES['file2Upload']['tmp_name'];

	//Check TEMP IMAGE file for proper MIME type
	if (!ValidateMIMEType($img)) { return false; }

	// Check if file already exists
//	if (file_exists($img->dir . $img->file2upload)) {
//		$img->msg = "Sorry, such image file already exists. Skipping upload.";
//		return false;
//	}

	// Check file size limits
	if (isset($_FILES['file2Upload']['size'])) {
		$size = filesize($img->tempFile);
		if ($size !== $_FILES['file2Upload']['size']) {
			$img->msg = 'File size mismatch';
			return false;
		}
		if ($size > SIZE_LIMIT) {
			$img->msg = 'Sorry, your image file is too large.';
			return false;
		}
	}
	// copy file to IMAGES folder
	if (!move_uploaded_file($img->tempFile, $img->dir . $img->file2upload)) {
		$img->msg = 'Sorry, there was an error uploading your image.';
		return false;
	}

	return true;
}
