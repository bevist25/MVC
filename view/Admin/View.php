<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?= ROOT_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= ROOT_URL ?>/assets/css/admin.css" rel="stylesheet">
	<script src="<?= ROOT_URL ?>/assets/js/jquery-migrate-3.4.0.min.js"></script>
	<script src="<?= ROOT_URL ?>/assets/js/custom.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<title>Dashboard</title>
</head>
<body>
    <?php $app = new Core\App(); ?>
    <main id="site-main-admin" class="main-admin">
		<div class="row">
			<div id="adminmenumain" class="col-sm-3">
				<ul id="adminmenu">
					<li>
						<h3>Dashboard</h3>
					</li>
					<li>
						<a href="<?= ROOT_URL.'/admin/posts' ?>">Posts</a>
					</li>
					<li>
						<a href="<?= ROOT_URL.'/admin/categories' ?>">Categories</a>
					</li>
				</ul>
			</div>
			<div id="content-admin" class="col-sm-9">
				<?php require_once $app->View(); ?>
			</div>
		</div>
	</main>
</body>
</html>