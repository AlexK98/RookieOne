<?php
/*
* File: index.php
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
		<?php include 'front_header_button_sign_in.php'; ?>
		<?php include 'front_header_button_sign_up.php'; ?>
	</div>
</header>
<!-- MAIN MAGE DATA -->
<main>
	<h2 class="block mt20">Welcome, Rookie!</h2>
	<div>SkyNet is waiting for you.</div>
	<div>Enroll now to start enjoying the wonderful moments.</div>
	<section class="mt20">
		<div class="iblock form width678 formTopLine pa20" style="position: relative; z-index: -3;">
			<h1>We Build The Future</h1>
			<div class="iShadow iSize iblock">
				<img class="iLogo iSize" src="images/_logo.png" style="position: relative; z-index: -2; text-align: center;">
			</div>
		</div>
	</section>
</main>

<?php include 'front_page_footer.php'; ?>