<main class="sidebar">

	<section class="left">
		<ul>
			<li><a href="/">Jobs</a></li>
			<li><a href="/about">Categories</a></li>
		</ul>
	</section>

	<section class="right">

		<?php foreach ($errors as $error) { ?>
			<li><?= $error ?></li>
		<?php } ?>
		<h2>Apply for <?= $job->title ?></h2>

		<form action="" method="POST" enctype="multipart/form-data">
			<label>Your name</label>
			<input type="text" name="applicant[name]" value="<?= $_POST['applicant']['name'] ?? '' ?>" />

			<label>E-mail address</label>
			<input type="text" name="applicant[email]" value="<?= $_POST['applicant']['email'] ?? '' ?>" />

			<label>Cover letter</label>
			<textarea name="applicant[details]"><?= $_POST['applicant']['details'] ?? '' ?></textarea>

			<label>CV</label>
			<input type="file" name="applicant[cv]" />

			<input type="hidden" name="applicant[jobId]" value="<?= $job->id ?>" />

			<input type="submit" name="submit" value="Apply" />

		</form>





	</section>
</main>