// Переменная куда будут располагаться данные файлов
 
var files;
 
// Вешаем функцию на событие
// Получим данные файлов и добавим их в переменную
 
$('input[type=file]').change(function(){
    files = this.files;

});




$('#upload .sbmt').on("click", function (e) {

	e.preventDefault();


	if ( typeof files !== "object" ) {

alert("Ошибка! Не выбран ни один файл для загрузки!");

return false;

} 


	else if ( files.length && files.length > 3) {

		alert("Ошибка! Вы пытаетесь загрузить одновременно больше 3 файлов!");

		return false;
	}



 var data = new FormData();

    $.each( files, function( key, value ){
        data.append( key, value );
    });


$.ajax({
type: 'POST',
cache: false,
dataType: 'json',
url: "/source/php/app/upload_action.php",
data: data,
processData: false, // Не обрабатываем файлы
contentType: false,
success: function(resp ) {


if (resp.error == 0)  {

// console.log(resp);

var tpl = require('./tpl/list-images.hbs')(resp);

// console.log(resp.uploaded);

$("#img-list").append( tpl );

// alert(resp.msg);

$("input[type=file]").val("");


}

else {
alert(resp.msg);


}

},
error: function() {

alert("Что-то пошло не так! Попробуйте позже!");
}
});

// return false;
	});
