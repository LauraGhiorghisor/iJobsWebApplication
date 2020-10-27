<main class="sidebar">

	<section class="left">
		<ul>
			<li <?php if ($_GET['id'] == 0) echo 'class="current"'; ?>><a href="category?id=0">All Jobs </a></li>
			<?php foreach ($categories as $category) { ?>
				<li <?php
					if (isset($_GET['id']) && $category->id == $_GET['id']) {
						echo 'class="current"';
						$current = $category->name;
					}
					?>><a href="/category?id=<?= $category->id ?>"><?= $category->name ?></a></li>
			<?php } ?>
		</ul>
	</section>

	<section class="right">

		<?php if ($jobs) { ?>
			<h1 style="display: inline-block; margin-left: 50px; margin-right: 60px;"><?= $current ?? 'All ' . ' Jobs'; ?> </h1>


			<?php if (isset($_GET['id']) && $_GET['id'] == 0) { ?>
				<form style=" display: inline-block;" action="/category?id=0" method="POST">

					<select style="float: left; margin-top: 5px; width: 150px;" name="selected_location">
						<option selected value="0"> -- select an option -- </option>

						<?php
						foreach ($jobs_locations as $job) { ?>
							<option value="<?= $job->location ?>"><?= $job->location ?></option>
						<?php } ?>
					</select>

					<button style="float: left; width: 90px; height: 30px; margin-left: 20px;" type="submit" name="filter" value="Filter">Filter</button>
				</form>
			<?php } ?>

			<ul class="listing">


				<?php

				foreach ($jobs as $job) { ?>
					<li>

						<div class="details">
							<h2><?= $job->title ?></h2>
							<h3><?= $job->salary ?></h3>
							<p><?= nl2br($job->description) ?></p>
							<a class="more" href="/category/apply?id=<?= $job->id ?>">Apply for this job</a>
						</div>
					</li>
				<?php	}  ?>

			</ul>
		<?php } else { ?>
			<p> There are no jobs under this category. Please try again later!</p>
		<?php } ?>
	</section>
</main>