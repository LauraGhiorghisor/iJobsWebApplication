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
		<?php if ($access == 2) { ?>
			<div>

				<strong>You have successfully added a new user!</strong>
			</div>
		<?php } else { ?>
			<p> You do not have the privileges to perform this action.</p>
		<?php } ?>
	</section>
</main>