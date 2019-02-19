<?php
/*
* File: sign_in.php
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
	//exit;
}

// process SIGN IN form
if (isset($_POST['submit']) && $_POST['submit'] === 'SignIn') {
	SignIn($db, $user);
}

//ALTER 'PLACEHOLDER' AND 'VALUE'
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
		<?php include 'front_header_button_sign_up.php'; ?>
	</div>
</header>

<!-- MAIN MAGE DATA -->
<main>
	<h2>Sign In</h2>
	<p>Welcome back, <b class="col_green"><?php if(isset($_COOKIE['name']) && !empty($_COOKIE['name'])) {echo $_COOKIE['name'];} else {echo 'Rookie';} ?></b>!<br>Sign In to access your profile and track your wanders.</p>

	<section class="block mt20">
		<form class="form width456 iblock formTopLine pa20" method="post" autocomplete="off" novalidate
		      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<!--EMAIL-->
			<label for="email" id="l_email" class="label block"><span class="redmark" title="Required">*</span> Email:</label>
			<input type="email" id="email" name="email" required title="Please enter valid e-mail address"
			       class="form_input block <?php echo $ph->emailStyle; ?>"
			       placeholder="<?php echo $ph->email; ?>"
			       value="<?php echo $user->email; ?>"/>
			<!--PASSWORD-->
			<label for="password" id="l_password" class="label block"><span class="redmark" title="Required">*</span> Password:</label>
			<input type="password" id="password" name="password" required title="Your password, please."
			       pattern=".{3,100}"
			       class="form_input block <?php echo $ph->passStyle; ?>"
			       placeholder="<?php echo $ph->pass; ?>"/>
			<label class="chbox_container">Show Password
				<input type="checkbox" onclick="FormShowPassword()">
				<span class="chbox_checkmark"></span>
			</label>

			<!--FORM BUTTONS-->
			<button type="submit" class="btn btn1 mt10" name="submit" value="SignIn" onclick="ToggleText2Pass()">Sign In</button>

			<div class="smaller mt20">Still not wandering with us? <a href="sign_up.php" class="smaller">Sign Up</a>.</div>
		</form>
	</section>
</main>

<?php include 'front_page_footer.php'; ?>