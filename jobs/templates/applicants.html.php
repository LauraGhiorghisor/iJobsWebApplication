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


		<h2>Applicants for <?= $job->title ?? 'N/A' ?></h2>


		<table>
			<?php if (!empty($applicants) && !empty($job) && $access) { ?>
				<thead>
					<tr>
						<th style="width: 10%">Name</th>
						<th style="width: 10%">Email</th>
						<th style="width: 65%">Details</th>
						<th style="width: 15%">CV</th>
					</tr>
				</thead>

				<?php   }
			if (!empty($job) && ($userId == $job->userId || $access >= 1)) {
				if (!empty($applicants))
					foreach ($applicants as $applicant) {
				?>
					<tr>
						<td><?= $applicant->name ?></td>
						<td><?= $applicant->email ?></td>
						<td><?= $applicant->details ?></td>
						<td><a href="/cvs/<?= $applicant->cv ?>">Download CV</a></td>
					</tr>
				<?php

					} else { ?>
					<p> There are currently no applicants for this job! Please try again later! </p>
				<?php }
			} else { ?>
				<p> You do not have the privileges to perform this action.</p>
			<?php } ?>



		</table>
	</section>
</main>