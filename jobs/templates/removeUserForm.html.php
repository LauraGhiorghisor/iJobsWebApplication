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



		<h2>Users</h2>

		<?php if (sizeof($users) > 1) {
			if ($access == 2) { ?>
				<table>

					<thead>
						<tr>
							<th>User</th>
							<th style="width: 30%">Access Level</th>
							<th style="width: 15%"></th>
						</tr>
					</thead>
					<?php foreach ($users as $user) {	?>
						<tr>
							<td><?= $user->username ?></td>
							<td><?php if ($user->access == 0) echo 'Client';
								else if ($user->access == 1) echo 'Admin';
								else if ($user->access == 2) echo 'General Admin' ?></td>
							<td>
								<form method="post" action="/admin/removeUser">
									<input type="hidden" name="id" value="<?= $user->id ?>" />
									<input type="submit" name="delete" value="Delete" />
								</form>
							</td>
						</tr>

					<?php }
				} else { ?>
					<p> You do not have the privileges to perform this action.</p>
				<?php } ?>
				</table>
			<?php
		} else {
			?>
				<p style="margin-top: 40px;"> You currently have no users.</p>
			<?php } ?>

	</section>
</main>