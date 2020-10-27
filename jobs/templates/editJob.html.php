<main class="sidebar">

	<section class="left">
		<ul>
			<li><a href="/admin/jobs">Jobs</a></li>
			<?php if ($access >= 1) { ?>
				<li><a href="/admin/categories">Categories</a></li>
				<li><a href="/admin/enquiries">Enquiries</a></li>
			<?php } ?>
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

		<?php if (empty($job)) { ?>
			<h2>Add Job</h2>
		<?php } else { ?>

			<h2>Edit Job</h2>
		<?php }
		if (((!empty($job) && $userId == $job->userId) || $access >= 1) || empty($job)) { ?>
			<form action="" method="POST">
				<input type="hidden" name="job[id]" value="<?= $job->id ?? '' ?>" />
				<label>Title</label>
				<input type="text" name="job[title]" value="<?= $_POST['job']['title'] ?? $job->title ?? '' ?>" />

				<label>Description</label>
				<textarea name="job[description]"><?= $_POST['job']['description'] ?? $job->description ?? '' ?></textarea>

				<label>Salary</label>
				<input type="text" name="job[salary]" value="<?= $_POST['job']['salary'] ?? $job->salary ?? '' ?>" />

				<label>Location</label>
				<input type="text" name="job[location]" value="<?= $_POST['job']['location'] ?? $job->location ?? '' ?>" />

				<label>Category</label>

				<select name="job[categoryId]">
					<?php
					foreach ($categories as $category) { ?>
						<option value="<?= $category->id ?>" <?php if (
																((isset($_POST['job']['categoryId']) && $category->id == $_POST['job']['categoryId']) ||
																	(isset($job->categoryId) &&  $category->id == $job->categoryId))
															) echo "selected";
															?>><?= $category->name ?></option>
					<?php } ?>

				</select>

				<label>Closing Date</label>
				<input type="date" name="job[closingDate]" value="<?= $_POST['job']['closingDate'] ?? $job->closingDate ?? '' ?>" />

				<input type="submit" name="submit" <?php if (empty($job)) { ?> value="Add Job" <?php } else { ?> value="Edit Job" <?php
																															} ?> />

			</form>
		<?php } else { ?>
			<p> You do not have the privileges to perform this action.</p>
		<?php } ?>
	</section>
</main>