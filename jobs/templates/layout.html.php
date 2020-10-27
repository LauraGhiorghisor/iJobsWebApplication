<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="/styles.css" />
	<title>
		<?= $title ?>
	</title>
</head>

<body>
	<header>
		<ul style="list-style-type: none;">
			<div style="background-color: white; height: 40px;  display: flex; justify-content: flex-end; align-items: center; color: gray; padding-right: 30px; ">
				<li style="margin-right: 15px;"> <a href="/admin/jobs"> Dashboard </a> </li>
				<?php

				if ($loggedin) { ?>
					<li><a href="/admin/logout">Log out</a>
					</li>
				<?php } else { ?>
					<li><a href="/admin/login">Log in</a></li>
				<?php } ?>
		</ul>
		</div>
		<section>
			<aside>
				<h3>Office Hours:</h3>
				<p>Mon-Fri: 09:00-17:30</p>
				<p>Sat: 09:00-17:00</p>
				<p>Sun: Closed</p>
			</aside>
			<h1>Jo's Jobs</h1>

		</section>
	</header>
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li>Jobs
				<ul style="margin-top: 10px;">
					<li> <a href="/category?id=0"> All Jobs </a></li>
					<?php

					foreach ($categories as $category) { ?>
						<li><a href="/category?id=<?= $category->id ?>"><?= $category->name ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<li><a href="/about">About Us</a></li>
			<li><a href="/faq">FAQ</a></li>
			<li><a href="/contact">Contact</a></li>
		</ul>

	</nav>
	<img src="/images/randombanner.php" />

	<?= $output ?>



	<footer>
		&copy; Jo's Jobs 2020
	</footer>
</body>

</html>