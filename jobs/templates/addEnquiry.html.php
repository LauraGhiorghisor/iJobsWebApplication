<main class="sidebar">



	<section class="right">

		<?php foreach ($errors as $error) { ?>
			<li><?= $error ?></li>
		<?php } ?>
		<h2>Please leave your enquiry below! </h2>
		<form action="" method="post" style="padding: 40px">
			<label>Enter Your Name </label>
			<input type="text" name="enquiry[name]" value="<?= $_POST['enquiry']['name'] ?? '' ?>" />
			<label>Enter Your Email Address</label>
			<input type="text" name="enquiry[address]" value="<?= $_POST['enquiry']['address'] ?? '' ?>" />
			<label>Enter Your Telephone Number</label>
			<input type="text" name="enquiry[telephone]" value="<?= $_POST['enquiry']['telephone'] ?? '' ?>" />
			<label>Please write your enquiry below</label>
			<textarea name="enquiry[text]"><?= $_POST['enquiry']['text'] ?? '' ?></textarea>
			<input type="submit" name="submit" value="Submit" />
		</form>


	</section>
</main