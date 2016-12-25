"use strict";
import Mn from 'backbone.marionette';
import Bb from 'backbone';

// console.log("Приложение работает!");

const LiImg =  require('./LiImgView.js');

const ImgList = require('./ImgListView.js');


// Класс для вывода одного изображения на главной

// const liImgMain =  LiImg.extend({
// template: function (data) {
// let tpl = require('./tpl/main-list.hbs');
// return tpl(data);
// },
// className: 'main-li'
// });

LiImg.template = function (data) {
let tpl = require('./tpl/main-list.hbs');
return tpl(data);
};

// console.log( LiImg.template );

// let imgListMain = ImgList.extend({
// // childView: liImgMain
// });

ImgList.childView = LiImg;


let imgList =  new ImgList({
	// className: '.main-list'
});

// console.log(imgList.getChild());



imgList.collection.url = 'source/php/app/getImages.php';

imgList.collection.fetch({reset:true});


imgList.render();



