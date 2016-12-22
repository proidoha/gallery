// Переменная куда будут располагаться данные файлов
 
var files;
 
// Вешаем функцию на событие
// Получим данные файлов и добавим их в переменную
 
$('input[type=file]').change(function(){
    files = this.files;


});




$('#upload .sbmt').on("click", function (e) {

	e.preventDefault();

	if ( files.length > 3) {

		alert("Ошибка! Вы пытаетесь загрузить одновременно больше 3 файлов!");

		return false;
	}




console.log(files);


 var data = new FormData();

    $.each( files, function( key, value ){
        data.append( key, value );
    });

console.log(data);

// return false;


$.ajax({
type: 'POST',
cache: false,
dataType: 'json',
url: "/source/php/app/upload_action.php",
data: data,
processData: false, // Не обрабатываем файлы
contentType: false,
success: function(resp ) {

console.log(resp);

if (resp.error == 0)  {

console.log(resp);

var tpl = require('./tpl/list-images.hbs')(resp);

// console.log(resp.uploaded);

$("#img-list").html( tpl );



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
