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


		<?php foreach ($errors as $error) { ?>
			<li><?= $error ?></li>
		<?php } ?>


		<?php if (empty($category)) { ?>
			<h2>Add Category</h2>
		<?php } else { ?>

			<h2>Edit Category</h2>
		<?php }
		if ($access >= 1) { ?>
			<form action="" method="POST">
				<input type="hidden" name="category[id]" value="<?= $category->id ?? '' ?>" />
				<label>Name</label>
				<input type="text" name="category[name]" value="<?= $category->name ?? '' ?>" />


				<input type="submit" name="submit" <?php if (empty($category)) { ?> value="Add Category" <?php } else { ?> value="Edit Category" <?php
																																			} ?> />

			</form>
		<?php } else { ?>
			<p> You do not have the privileges to perform this action.</p>
		<?php } ?>
	</section>
</main>