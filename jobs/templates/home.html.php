<main class="home">
	<p>Welcome to Jo's Jobs, we're a recruitment agency based in Northampton. We offer a range of different office jobs. Get in touch if you'd like to list a job with us.</a></p>

	<h2>These jobs are going fast! Apply now!</h2>
	<ul>

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
		<?php	} ?>

	</ul>
</main>