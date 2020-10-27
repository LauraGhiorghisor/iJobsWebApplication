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



		<h2>Enquiries</h2>

		<?php if ($access >= 1) {
			if (sizeof($enquiries) > 0) {
		?>
				<table>

					<thead>
						<tr>
							<th>Name</th>
							<th style="width: 30%">Adddress</th>
							<th style="width: 35%">Telephone</th>
							<th style="width: 15%">Status</th>
							<th style="width: 15%">Username</th>
						</tr>
					</thead>
					<?php foreach ($enquiries as $enquiry) {	?>
						<tr>
							<td><?= $enquiry->name ?></td>
							<td><?= $enquiry->address ?></td>
							<td><?= $enquiry->telephone ?></td>
							<td><?php if ($enquiry->status == 1) echo 'Complete';
								else echo 'Active'; ?></td>
							<td><?php if ($enquiry->userId == 0) echo 'N/A';
								else echo $enquiry->getUser()->username; ?></td>
							<td>
								<form method="post" action="/admin/completeEnquiry">
									<input type="hidden" name="id" value="<?= $enquiry->id ?>" />
									<input type="submit" name="complete" value="Complete" <?php if ($enquiry->status == 1) echo "disabled"; ?> />
								</form>
							</td>
						</tr>
						<tr>
							<td colspan="1"> Text
							<td>
						</tr>
						<tr>
							<td colspan="6"><?= $enquiry->text ?></td>
						</tr>

					<?php }
				} else { ?>
					<p style="margin-top: 40px;"> You currently have no enquiries.</p>
				<?php } ?>
				</table>
			<?php
		} else {
			?>
				<p> You do not have the privileges to perform this action.</p>
			<?php } ?>

	</section>
</main>