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



		<h2>Jobs</h2>
		<?php if (isset($access)) { ?>
			<div style="height: 50px; margin-bottom: 20px; display: flex; align-items: center;">
				<a style="float: left; width: 150px;" class="new" href="/admin/job/edit">Add new job</a>
				<form style="float: left;" action="/admin/jobs" method="POST">

					<select style="float: left; margin-top: 5px; width: 150px; margin-left: 10px; margin-right: 15px;" name="selected_category">
						<option selected value="0"> -- select an option -- </option>

						<?php
						foreach ($categories as $category) { ?>
							<option value="<?= $category->id ?>"><?= $category->name ?></option>
						<?php } ?>
					</select>

					<select style="float: left; margin-top: 5px; width: 150px;" name="selected_location">
						<option selected value="0"> -- select an option -- </option>

						<?php
						foreach ($jobs_locations as $job) { ?>
							<option value="<?= $job->location ?>"><?= $job->location ?></option>
						<?php } ?>
					</select>

					<button style="float: left; width: 90px; height: 30px; margin-left: 20px;" type="submit" name="filter" value="Filter">Filter</button>
				</form>
				<!-- form ends -->
			</div>
			<?php
			$count = 0;
			foreach ($jobs as $job)
				if ($userId == $job->userId || $access >= 1)	$count++;
			if (!empty($jobs) && $count > 0) { ?>
				<table>

					<thead>
						<tr>
							<th>Title</th>
							<th style="width: 15%">Category</th>
							<th style="width: 15%">Salary</th>
							<th style="width: 15%">Archived</th>
						</tr>
					</thead>
					<?php foreach ($jobs as $job)
						if ($userId == $job->userId || $access >= 1) {	?>
						<tr>
							<td><?= $job->title ?></td>
							<td><?= $job->getCategory()->name ?></td>
							<td><?= $job->salary ?></td>
							<td><?= $job->archived_status ?></td>
							<td><a style="float: right" href="/admin/job/applicants?id=<?= $job->id ?>">View applicants (<?= sizeof($job->getApplicants()) ?>)</a></td>

							<td><a style="float: right" href="/admin/job/edit?id=<?= $job->id ?>">Edit</a></td>
							<td>
								<form method="post" action="/admin/job/delete">
									<input type="hidden" name="id" value="<?= $job->id ?>" />
									<input type="submit" name="delete" value="Delete" />
								</form>
							</td>
							<td>
								<form method="post" action="/admin/job/archive">
									<input type="hidden" name="id" value="<?= $job->id ?>" />
									<input type="submit" name="archive" value="Archive" />
								</form>
							</td>
							<td>
								<form method="post" action="/admin/job/repost">
									<input type="hidden" name="id" value="<?= $job->id ?>" />
									<input type="submit" name="repost" value="Repost" />
								</form>
							</td>
						</tr>

					<?php } ?>
				</table>
			<?php } else {
			?>
				<p style="margin-top: 40px;"> You currently have no jobs.</p>
			<?php } ?>
		<?php } else { ?>
			<p> You do not have the privileges to perform this action.</p>
		<?php } ?>
	</section>
</main>