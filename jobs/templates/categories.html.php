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




		<h2>Categories</h2>
		<?php if ($access >= 1) { ?>
			<a class="new" href="/admin/category/edit">Add new category</a>

			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th style="width: 5%">&nbsp;</th>
						<th style="width: 5%">&nbsp;</th>
					</tr>


					<?php foreach ($categories as $category) { ?>
						<tr>
							<td> <?= $category->name ?></td>
							<?php if ($access >= 1) { ?>
								<td><a style="float: right" href="/admin/category/edit?id=<?= $category->id ?>">Edit</a></td>
								<td>
									<form method="post" action="/admin/category/delete">
										<input type="hidden" name="id" value="<?= $category->id ?>" />
										<input type="submit" name="submit" value="Delete" />
									</form>
								</td>
							<?php } ?>
						</tr>
					<?php } ?>

				</thead>
			</table>
		<?php } else { ?>
			<p> You do not have the privileges to perform this action.</p>
		<?php } ?>
	</section>
</main>