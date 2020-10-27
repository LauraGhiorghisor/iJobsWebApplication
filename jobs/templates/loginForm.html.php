<main class="sidebar">



	<?php


	if ($loggedin) {
	?>

		<section class="left">
			<ul>
				<li><a href="/admin/jobs">Jobs</a></li>
				<li><a href="/admin/categories">Categories</a></li>
				<li><a href="/admin/enquiries">Enquiries</a></li>
			</ul>
			<?php if ($access == 2) { ?>

				<ul>
					<li><a href="/admin/addUser">Add user</a></li>
					<li><a href="/admin/removeUser">Remove user</a></li>

				</ul>
			<?php } ?>
		</section>

		<section class="right">
			<h2>You are already logged in!</h2>
		</section>
	<?php
	} else {
	?>
		<h2>Log in</h2>

		<?php foreach ($errors as $error) { ?>
			<li><?= $error ?></li>
		<?php } ?>
		<form action="" method="post" style="padding: 40px">
			<label>Enter Username</label>
			<input type="text" name="username" value="<?= $_POST['username'] ?? '' ?>" />
			<label>Enter Password</label>
			<input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>" />

			<input type="submit" name="submit" value="Log In" />
		</form>
	<?php
	}
	?>
</main>