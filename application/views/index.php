<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SwitchGame</title>
	<style rel="stylesheet">
		body {
			background: url(<?= base_url();
			?>assets/bg.png) no-repeat center center fixed;
			-webkit-background-size: 100% 100%;
			-moz-background-size: 100% 100%;
			-o-background-size: 100% 100%;
			background-size: 100% 100%;
			margin: 0;
			padding: 0;
			height: 100%;
			overflow: hidden;
		}

		#content {
			position: absolute;
			left: 0;
			right: 0;
			bottom: 0;
			top: 0px;
		}

	</style>
</head>

<body>
	<div id="content">
		<iframe src="<?= base_url();?>game/index.html" frameborder="0" width="100%" height="100%"
			allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope;" allowfullscreen></iframe>
	</div>
</body>

</html>
