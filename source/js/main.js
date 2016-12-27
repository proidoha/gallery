"use strict";
import Mn from 'backbone.marionette';
import Bb from 'backbone';

const LiImg =  require('./LiImgView.js');

const ImgList = require('./ImgListView.js');

LiImg.template = function (data) {
let tpl = require('./tpl/main-list.hbs');
return tpl(data);
};

ImgList.childView = LiImg;


let imgList =  new ImgList();

imgList.collection.url = 'source/php/app/getImages.php';

imgList.collection.fetch({reset:true});

imgList.render();



