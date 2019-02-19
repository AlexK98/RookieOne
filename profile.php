<?php
/*
* File: profile.php
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

// Redirect if user NOT logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === FALSE) {
	header('Location: index.php');
}

// get current user's profile data and profile image from DB
if ($_SESSION['logged_in'] === true && isset($_SESSION['email'])) {
	$user->email = $_SESSION['email'];
	GetUserData($db, $user);
	$img->file2upload = $user->userImage;
}

// save profile image or data to DB
if (isset($_POST['submit'])) {
	$user->email = $_SESSION['email'];

	if ($_POST['submit'] === 'UserImage') {
		//check if no file has been submitted
		if (isset($_FILES['file2Upload']['name']) && empty($_FILES['file2Upload']['name'])) {
			$img->msg = 'Profile image stays the same.';
			GetUserData($db, $user);
		} else {
			if (UploadImage($img)) {
				UpdateUserImage($db, $user, $img);
				GetUserImage($db, $user, $img);
			}
		}
	}
	
	if ($_POST['submit'] === 'UserData') {
		if (UpdateUserData($db, $user)) {
			$img->isOK = 1;
		} else {
			$img->isOK = 0;
		}
	}
}

$style = '';
// alter text color style for FORM messages
if ($img->isOK === 1) {
	$style = 'text-msg';
} else {
	$style = 'text-alert';
}
?>

<!--PAGE CONTENTS-->
<?php include 'front_page_header.php'; ?>

<!-- TOP HEADER with LOGO and BUTTONS -->
<header class="header block">
	<div class="float_L side mt10">
		&nbsp
	</div>
	<div class="float_L middle mt10">
		<?php include 'front_header_button_index.php'; ?>
	</div>
	<div class="float_L side mt10">
		<?php include 'front_header_button_sign_out.php'; ?>
		<div class="username float_R">Hello, <?php echo $user->firstname; ?></div>
	</div>
</header>

<!-- MAIN MAGE DATA -->
<main>
	<h2>Profile</h2>
	<!--PROFILE IMAGE-->
	<section class="block mb20">
		<form class="form width678 iblock formTopLine pa20" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
			<!--User Image -->
			<div class="profile pb10">
				<div class="profile-label pt05"></div>
				<div class="pt05">
					<div id="yourBtn" onclick="ChooseFile()">
						<img src="<?php echo $img->dir . $user->userImage; ?>" class="userPic iblock float_L userPicShadow" id="profileimage"
						     alt="Profile image" title="Click to change your image.">
					</div>
				</div>
			</div>
			<!-- Select Image and Save/Submit button -->
			<div class="profile pt10">
				<div class="profile-label pt05"></div>
				<div class="profile-label pt05">
					<input type="file" name="file2Upload" id="file2Upload" class="hidden_overflow" onchange="PreviewImage(event)"/>
					<button type="submit" name="submit" value="UserImage" id="imageButton" class="btn btn2 float_L">Save</button>
				</div>
				<div class="<?php echo $style; ?> pt05"><?php echo $img->msg; ?></div>
			</div>
		</form>
	</section>
	<!--PROFILE DATA-->
	<section class="block">
		<form class="form width678 iblock formTopLine pa20" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
			<!--FIRSTNAME-->
			<div class="profile">
				<div class="profile-label pt05">First Name:</div>
				<div class="pt05">
					<input type="text" id="name" name="firstname" required title="Please enter your First name"
					       class="input-area <?php echo $ph->firstStyle; ?>"
					       placeholder="<?php echo $ph->first; ?>"
					       value="<?php echo $user->firstname; ?>"/>
				</div>
			</div>
			<!--LASTNAME-->
			<div class="profile pt10">
				<div class="profile-label">Last Name:</div>
				<div>
					<input type="text" id="lastname" name="lastname" required title="Please enter your Last name"
					       class="input-area <?php echo $ph->lastStyle; ?>"
					       placeholder="<?php echo $ph->last; ?>"
					       value="<?php echo $user->lastname; ?>"/>
				</div>
			</div>
			<!--ABOUT-->
			<div class="profile pt10 pb15">
				<div class="profile-label">About:</div>
				<div>
					<textarea name="about" id="about" rows="3" maxlength=255 title="Please tell something about yourself"
					          class="input-area <?php echo 'custom_style'; ?>"
					          placeholder="<?php echo $ph->about; ?>"><?php if (!empty($user->about)) {echo $user->about;} ?></textarea>
				</div>
			</div>
			<!--CITY-->
			<div class="profile pt10">
				<div class="profile-label">City:</div>
				<div>
					<input type="text" id="city" name="city" title="Please enter your City"
					       class="input-area <?php echo 'custom_style'; ?>"
					       placeholder="<?php echo $ph->city; ?>"
					       value="<?php if (!empty($user->city)) {echo $user->city;} ?>"/>
				</div>
			</div>
			<!--COUNTRY-->
			<div class="profile pt10">
				<div class="profile-label">County:</div>
				<div>
					<input type="text" id="country" name="country" title="Please select your Country"
					       class="input-area <?php echo 'custom_style'; ?>"
					       placeholder="<?php echo $ph->country; ?>"
					       value="<?php if (!empty($user->country)) {echo $user->country;} ?>"/>
				</div>
			</div>
			<!--GENDER-->
			<div class="profile pt10">
				<div class="profile-label">Gender:</div>
				<div>
					<input type="text" id="gender" name="gender" title="Please enter your gender"
					       class="input-area <?php echo 'custom_style'; ?>"
					       placeholder="<?php echo $ph->gender; ?>"
					       value="<?php if (!empty($user->gender)) {echo $user->gender;} ?>"/>
				</div>
			</div>
			<!--FORM BUTTON-->
			<div class="profile pt10">
				<div class="profile-label pt05"></div>
				<div class="profile-label pt05">
					<button type="submit" name="submit" value="UserData" class="btn btn2 float_L" onclick="ToggleText2Pass()">Save</button>
				</div>
				<div class="<?php echo $style; ?> pt05"><?php echo $user->msg; ?></div>
			</div>
		</form>
	</section>
</main>

<?php include 'front_page_footer.php'; ?>