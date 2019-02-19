<?php
/*
* File: manage_db.php
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

// SET SERVICE VARIABLE
if (!isset($_SESSION['dbCreated'])) {
	$_SESSION['dbCreated'] = 0;
}

// CREATED DATABASE AND TABLE
if (isset($_POST['submit']) && $_POST['submit'] === 'createDB') {
	InitDB($db);
}
// DELETE DATABASE
if (isset($_POST['submit']) && $_POST['submit'] === 'resetDB') {
	setcookie('name', '', time()-7000000);
	ResetDB($db);
}
// CHECK IF DB EXIST
if (isset($_POST['submit']) && $_POST['submit'] === 'selectDB') {
	if (SelectDB($db)) { $_SESSION['dbCreated'] = 1;}
}
?>

<!--PAGE CONTENTS-->
<?php include 'front_page_header.php'; ?>

<!-- TOP HEADER with LOGO and BUTTONS -->
<header class="header block">
	<div class="float_L side mt10">
		<?php include 'front_header_button_managedb.php'; ?>
	</div>
	<div class="float_L middle mt10">
		<a href="index.php" class="logoText">Rookie-One Corp</a>
	</div>
	<div class="float_L side mt10">
		<?php
			if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE) {
				include 'front_header_button_profile.php';
			} else {
				include 'front_header_button_sign_in.php';
				include 'front_header_button_sign_up.php';
			}
		?>
	</div>
</header>
<!-- MAIN MAGE DATA -->
<main>
	<h2>Manage Database</h2>
	<form method="post" class="form iblock formTopLine pa20" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
		<p class="msg <?php if(empty($_SESSION['msgDB'])) {echo 'hider';}?>">
			<!-- Echo last msgDB and clean it -->
			<?php
				if (isset($_SESSION['msgDB']) && !empty($_SESSION['msgDB'])) {
					echo $_SESSION['msgDB'];
				}
				$_SESSION['msgDB'] = '';
			?>
		</p>
		<p class="msg">Status:
			<?php
				if ($_SESSION['dbCreated'] === 1) { echo 'Database created/present.'; }
				else { echo 'Database is absent/deleted.'; }
			?>
		</p>
		<input type="hidden"/>
		<button type="submit" class="btn btn2 mt10" name="submit" value="createDB" title="Create DB and Table or just Table if DB exist">Create DB</button>
		<button type="submit" class="btn btn2 mt10" name="submit" value="selectDB" title="Check if DB exist">Select DB</button>
		<button type="submit" class="btnR btn2 mt10" name="submit" value="resetDB" title="Not a good idea for free hosting sites">Drop DB</button>
	</form>
</main>

<?php include 'front_page_footer.php'; ?>