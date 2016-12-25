<?php
$url = $_SERVER["REQUEST_URI"];

include_once("/source/php/tpl/head.tpl"); 

include_once("/source/php/db.php");

$data = $_GET;

if ( empty($data['id'])) exit('Ошибка! Такого изображения не существует!');

$gallery = new Gallery;

$img = $gallery->getImg($data['id']);

?>

<body>

	<div id="wrapper">

	<?php include_once("/source/php/tpl/navigation.tpl"); ?>

<div id="main-content">

<div class="bigImg">
<h2>Изображение</h2>

<img src="/<?=$img['src']?>" alt="" />

<!-- <div style="background-image:url(<?=$img['src']?>)" class="big-preview">

</div> -->

</div>

	<div class="clear"></div>



	<section id="comments">
<h3>Список комментариев:</h3>
	<ol id="comments-list">	
	</ol>

	<div id="add-comments">
<p style="font-weight:bold">Оставьте комментарий для потомков:</p>
	<textarea class="new-comment" name="new-comment"></textarea>

	<div class="clear"></div>

	<button class="sbmt">Отправить</button>

	</div>

	</section>


	</div>



	<?php include_once("/source/php/tpl/footer.tpl"); ?>

</div>

	<?php include_once("/source/php/tpl/footer-script.tpl"); ?>


	<script> 

window.app = {};

app.img_id = <?=$data['id']?>

	</script>

	<script src="/dist/comments.js"></script>

	</body>
</html>
