"use strict";
import Mn from 'backbone.marionette';

const ImgModel = require('./ImgModel.js');


module.exports = Mn.View.extend({
	model: ImgModel,
	tagName: "li",
	ui: {
destroy: ".destroy",
overlay: ".img-overlay"
	},

template(data) {

let tpl = require('./tpl/list-images.hbs');

return tpl(data);

},

// Callback при удалении модели
	modelEvents: {
'destroy': 'remove'
},

events: {
'click @ui.destroy': function() {


let view =  this;

	function react (model, resp) {

	alert(resp.msg);

};


this.model.destroy({ wait:true, url: "source/php/app/destroy-action.php/" + this.model.id,
success: react, error: react
});

return this;
}


},

onRender() {

return this;

},

remove() {

this.$el.remove();

}

});