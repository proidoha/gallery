<?php
$url = $_SERVER["REQUEST_URI"];

include_once("/source/php/tpl/head.tpl"); ?>

<body>

	<div id="wrapper">

	<?php include_once("/source/php/tpl/navigation.tpl"); ?>

<div id="main-content">
<h2>Галерея изображений</h2>

<div class="main-gallery">
	<ul class="main-list" id="img-list"></ul>
</div>

	<div class="clear"></div>

	</div>


	<?php include_once("/source/php/tpl/footer.tpl"); ?>

</div>

	<?php include_once("/source/php/tpl/footer-script.tpl"); ?>

	<script src="/dist/app.js"></script>

	</body>
</html>
