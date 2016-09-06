<?php

$siteurl = "http://localhost/";
$sitename = "Verkkokaupan kaltainen";

require_once("functions.php");
$items = array_map("str_getcsv", file("items.csv", FILE_SKIP_EMPTY_LINES));

$keys = array_shift($items);
foreach ($items as $i => $row) {
	$items[$i] = array_combine($keys, $row);
}

$cats = parse_categorys($items);
//var_export($cats);

if (isset($_GET["cat"]) && isset($_GET["subcat"])) {
	foreach ($items as $i => $item) {
		if (urli(strtolower($item["category"])) != $_GET["cat"] || urli(strtolower($item["subcategory"])) != $_GET["subcat"]) {
			unset($items[$i]);
		}
	}
} elseif (isset($_GET["cat"])) {
	foreach ($items as $i => $item) {
		if (urli(strtolower($item["category"])) != $_GET["cat"]) {
			unset($items[$i]);
		}
	}
} else {
	foreach ($items as $i => $item) {
		if ($item["featured"] == 0) {
			unset($items[$i]);
		}
	}
}

?>

<!DOCTYPE html>
<html lang="fi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $sitename; ?></title>
		<link href="<?php echo $siteurl; ?>slate.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			body {
				padding-top: 70px;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $siteurl; ?>"><?php echo $sitename; ?></a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<?php foreach ($cats as $catname => $cat) { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $catname; ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php foreach ($cat as $subcat) { ?>
								<li><a href="<?php echo $siteurl . urli(strtolower($catname."/".$subcat)); ?>"><?php echo $subcat; ?></a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<li><a href="<?php echo $siteurl; ?>yhteystiedot">Yhteystiedot</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<?php
				if ($_GET["cat"] == "yhteystiedot") {
					include("yhteystiedot.php");
				} else {
			?>
			<h2>Tuotteet</h2>
			<?php foreach ($items as $item) { ?>
			<hr>
			<div class="media">
				<div class="media-left media-middle">
					<a href="<?php echo $item["imageurl"]; ?>" data-toggle="lightbox" data-gallery="items" data-title="<?php echo $item["name"]; ?>">
						<img class="media-object" width="100" src="<?php echo $item["imageurl"]; ?>">
					</a>
				</div>
				<div class="media-body">
					<h4 class="media-heading"><?php echo $item["name"]; ?> - <?php echo $item["price"]; ?></h4>
					<p><?php echo $item["description"]; ?></p>
					<p>Kunto: <?php echo $item["condition"]; ?> - Varastossa: <?php echo $item["amount"]; ?></p>
					<p><a href="<?php echo $siteurl . urli(strtolower($item["category"])); ?>"><?php echo $item["category"]; ?></a> / <a href="<?php echo $siteurl . urli(strtolower($item["category"]."/".$item["subcategory"])); ?>"><?php echo $item["subcategory"]; ?></a></p>
				</div>
			</div>
			<?php } ?>
			<?php } ?>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.js"></script>
		<script>
			$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
				event.preventDefault();
				$(this).ekkoLightbox();
			});
		</script>
	</body>
</html>
