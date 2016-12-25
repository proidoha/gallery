<?php
// unset($_FILES, $_POST);

$url = $_SERVER["REQUEST_URI"];

include_once("/source/php/tpl/head.tpl"); ?>


	<div id="wrapper">
<?php include_once("/source/php/tpl/navigation.tpl"); ?>

<div id="main-content">
<section id="upload-block">
<form method="post" enctype="multipart/form-data">



<div id="upload">

<div class="one-upload">
<p><input name="photo" type="file" min="1" max="3"  multiple="multiple" accept=".txt,image/*" /> </p> 
<!-- <p><input name="photo[]" type="file" /> </p> 
<p><input name="photo[]" type="file" /> </p>  -->
<!-- <input style="margin-right:5px" name="photo[]" type="file" />   -->

</div>

<button class="sbmt">Отправить</button>
<!-- <span class="add-img" style="font-weight: bold; font-size: 18px" title="Добавить ещё одно изображение">+</span> -->


</div> 

<div id="preview"> <h2>Загруженные изображения:</h2>
	 <ul id="img-list"></ul>
</div>

</form>

</section>

</div>

	<?php include_once("/source/php/tpl/footer.tpl"); ?>

	</div>





		<?php include_once("/source/php/tpl/footer-script.tpl"); ?>

	<script src="dist/uploadfile.js"> </script>

	</body>
</html>