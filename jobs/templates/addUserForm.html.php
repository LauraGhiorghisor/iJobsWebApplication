	<main class="sidebar">


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
			<?php if ($access == 2) { ?>
				<h2>Add user</h2>
				<?php
				?>
				<?php if (count($errors) > 0) { ?>
					<p>Your registration could not be processed:</p>
					<ul>
						<?php foreach ($errors as $error) { ?>
							<li><?= $error ?></li>
						<?php } ?>
					</ul>
				<?php } ?>
				<form action="" method="post" style="padding: 40px">
					<label>Enter Username</label>
					<input type="text" name="user[username]" value="<?= $_POST['user']['username'] ?? '' ?>" />
					<label>Enter Password</label>
					<input type="password" name="user[password]" value="<?= $_POST['user']['password'] ?? '' ?>" />
					<label>Select access</label>
					<select style="margin-top: 33px;" name="user[access]">
						<option value="0" <?php if (isset($_POST['user']['access']) && $_POST['user']['access'] == 0) echo "selected"; ?>>Client</option>
						<option value="1" <?php if (isset($_POST['user']['access']) && $_POST['user']['access'] == 1) echo "selected"; ?>>Staff</option>
					</select>
					<input type="submit" name="submit" value="Add user" />
				</form>
			<?php } else { ?>
				<p> You do not have the privileges to perform this action. </p>
			<?php } ?>
		</section>
	</main>