<!DOCTYPE HTML>
<html>

<head>
	<title>Club JB Coming Soon</title>
	<link href="{{ asset('/css/comingsoon-style.css') }}" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
	<div class="content">
		<div class="wrap">
			<div class="content-grid">
				<p><img src="images/comingsoon-top.png" title=""></p>
			</div>
			<div class="grid">
				<p class="jb-logo"><img src="{{ asset('/images/logo-large.png') }}" title=""></p>
				<img src="{{ asset('/images/comingsoon.png') }}" title="">
				<h3>{{ App\DefaultValue::where('key', 'comingsoon')->first()->value }}</h3>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</body>

</html>