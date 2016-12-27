<?php
$url = $_SERVER["REQUEST_URI"];

include("/source/php/tpl/head.tpl"); ?>

<div id="wrapper">

<?php include("/source/php/tpl/navigation.tpl"); ?>

<div id="main-content">
<section id="upload-block">
<form method="post" enctype="multipart/form-data">



<div id="upload">

<div class="one-upload">
<p><input name="photo" type="file" min="1" max="3"  multiple="multiple" accept=".txt,image/*" /> </p> 
</div>

<button class="sbmt">Отправить</button>

</div> 

<div id="preview"> <h2>Загруженные изображения:</h2>
	 <ul id="img-list"></ul>
</div>

</form>

</section>

</div>

<?php include("/source/php/tpl/footer.tpl"); ?>

	</div>

<?php include("/source/php/tpl/footer-script.tpl"); ?>

	<script src="dist/uploadfile.js"> </script>

	</body>
</html>