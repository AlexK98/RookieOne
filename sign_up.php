<?php
/*
* File: sign_up.php
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

// redirect if User is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
	header('Location: profile.php');
	exit;
}

// process sign up form
if (isset($_POST['submit']) && $_POST['submit'] === 'SignUp') {
	SignUp($db, $user);
}

//ALTER 'PLACEHOLDER' AND 'VALUE'
if ($user->firstnameErr === '') {
	$ph->first = 'E.g. Sarah';
	$ph->firstStyle = '';
} else {
	$ph->first = $user->firstnameErr;
	$ph->firstStyle = 'alertPH';
	$user->firstname = '';
}

if ($user->lastnameErr === '') {
	$ph->last = 'E.g. Connor';
	$ph->lastStyle = '';
} else {
	$ph->last = $user->lastnameErr;
	$ph->lastStyle = 'alertPH';
	$user->lastname = '';
}

if ($user->emailErr === '') {
	$ph->email = 'E.g. sarah@connor.name';
	$ph->emailStyle = '';
} else {
	$ph->email = $user->emailErr;
	$ph->emailStyle = 'alertPH';
	$user->email = '';
}
if ($user->passErr === '') {
	$ph->pass = 'The password only you know';
	$ph->passStyle = '';
} else {
	$ph->pass = $user->passErr;
	$ph->passStyle = 'alertPH';
}

?>

<!--PAGE CONTENTS START-->
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
		<?php include 'front_header_button_sign_in.php'; ?>
	</div>
</header>
<!-- MAIN MAGE DATA -->
<main>
	<h2>Sign Up!</h2>
	<div class="iblock width456">Hey, <b class="col_green"><?php echo $user->basename; ?></b>! Fill in this form, click 'Sign Up' and<br>start enjoying the wanders we build for you.</div>

	<section class="block mt20">
		<form class="form width456 iblock formTopLine pa20" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"
		      novalidate>
			<!--FIRSTNAME-->
			<label for="firstname" id="l_firstname" class="label block"><span class="redmark" title="Required">*</span> First Name:</label>
			<input type="text" id="name" name="firstname" required title="Please enter your First name"
			       class="form_input <?php echo $ph->firstStyle; ?>"
			       placeholder="<?php echo $ph->first; ?>"
			       value="<?php echo $user->firstname; ?>"/>
			<!--LASTNAME-->
			<label for="lastname" id="l_lastname" class="label block"><span class="redmark" title="Required">*</span> Last Name:</label>
			<input type="text" id="lastname" name="lastname" required title="Please enter your Last name"
			       class="form_input <?php echo $ph->lastStyle; ?>"
			       placeholder="<?php echo $ph->last; ?>"
			       value="<?php echo $user->lastname; ?>"/>
			<!--EMAIL-->
			<label for="email" id="l_email" class="label block"><span class="redmark" title="Required">*</span> Email:</label>
			<input type="email" id="email" name="email" required title="Please enter valid e-mail address"
			       class="form_input <?php echo $ph->emailStyle; ?>"
			       placeholder="<?php echo $ph->email; ?>"
			       value="<?php echo $user->email; ?>"/>
			<!--PASSWORD-->
			<label for="password" id="l_password" class="label block"><span class="redmark" title="Required">*</span> Password:</label>
			<input type="password" id="password" name="password" required
			       title="Must contain at least one number and one uppercase and lowercase letter, and be at least three or more characters long"
			       pattern="(?=.*\d)(?=.*[a-zа-я])(?=.*[A-ZА-Я]).{3,100}$"
			       class="form_input <?php echo $ph->passStyle; ?>"
			       placeholder="<?php echo $ph->pass; ?>"/>
			<!--SHOW PASSWORD-->
			<label class="chbox_container">Show Password
				<input type="checkbox" onclick="FormShowPassword()">
				<span class="chbox_checkmark"></span>
			</label>
			<div class="spacer10"><br></div>
			<!--FORM BUTTONS-->
			<button type="submit" class="btn btn1" name="submit" value="SignUp" onclick="ToggleText2Pass()">Sign Up</button>
			<button type="reset" class="btn btn1">Reset</button>

			<div class="smaller mt20">Already wandering with us? <a href="sign_in.php" class="smaller">Sign In</a>.</div>
		</form>
	</section>
</main>

<?php include 'front_page_footer.php'; ?>