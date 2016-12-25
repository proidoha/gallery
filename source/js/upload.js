"use strict";
import Mn from 'backbone.marionette';
import Bb from 'backbone';

const ImgModel = Bb.Model.extend({
defaults: {title: "", 
description: "",
src: "",
mini: ""
 }
});


let collection = new Bb.Collection();

const LiImg =  Mn.View.extend({
	model: ImgModel,
	tagName: "li",
	ui: {
destroy: ".destroy",
overlay: ".img-overlay"
	},

	// initialize() {

 // this.listenTo(this.model, 'destroy', this.remove);

	// },

template(data) {

let tpl = require('./tpl/list-images.hbs');

return tpl(data);

},

	modelEvents: {
'destroy': 'remove'
},

events: {
'click @ui.destroy': function() {


let view =  this;

	function react (model, resp) {

	alert(resp.msg);

	// view.$el.remove();

};


this.model.destroy({ url: "source/php/app/destroy-action.php/" + this.model.id,
success: react, error: react
});

return this;
},

// "mouseover": function() {
// $(this.ui.overlay).show().animate({height:"100%", opacity:1 }, 250);
// },

// "mouseout @ui.overlay": function() {
// $(this.ui.overlay).animate({height:"0", opacity:0 }, 250).hide();
// }

},

onRender() {

return this;

},


destroy() {

this.$el.fadeIn(200);
	
	// this.destroy();

	return this;
},

remove() {
// this.$el.remove();

// this.destroy();

// console.log("");

this.$el.remove();


}

});

const ImgList =  Mn.CollectionView.extend({
el: "#img-list",
childView: LiImg,
collection: collection,
template: false,
replaceElement: true,
initialize() {

this.listenTo( this.collection, 'add', this.addOne );

},

 addOne: function (child) {
              
        let childView = new LiImg({model: child});

    childView.render();

  childView.$el.appendTo( this.$el );


        return this;
    },


onRender() {

this.$el.html("");

this.collection.each(function(child) {

 this.addOne(child);

}, this);

console.log('Render!');

return this;

}

});


let imgList =  new ImgList();


// imgList.render();



let files;
 

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

// var tpl = require('./tpl/list-images.hbs')(resp);

imgList.collection.add(resp.uploaded);

// console.log(imgList.collection);



// console.log(resp.uploaded);

// $("#img-list").append( tpl );

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
