"use strict";
import Mn from 'backbone.marionette';
import Bb from 'backbone';

// [{id:1,content:"Комментарий"}]
const Collection = Bb.Collection.extend({
url: "/source/php/app/comments.php"
});

let commentsColl = window.app.comments;

let collection = new Collection(commentsColl);

// console.log(window.app.img_id);

const CommentModel = Bb.Model.extend({
defaults: {
content: "",
img_id: window.app.img_id
}
});


const emptyView = Mn.View.extend({
template(data){
return _.template("<p>Комментариев пока нет.</p>")();
},
className: "empty-view",
replaceElement:true,
model: CommentModel
});


const Comment = Mn.View.extend({
	tagName: "li",

initialize() {

this.listenTo(this.model, 'change:content', this.render);

return this;	
},

template(data){
 return require('./tpl/one-comment.hbs')(data);

},

ui: {
destroy: '.destroy',
edit: '.edit'
},
events: {
'click @ui.destroy': 'remove',
// 'click @ui.edit': 'edit'
},
triggers: {
'click @ui.edit': 'edit:comment'
},

remove() {

let view =  this;

	function react (model, resp) {

	alert(resp.msg);

};

this.model.destroy({ wait:true, success: react, error: react});

return this;

},

edit() {



// console.log('Редактирование комментария');

return this;
}


});


// Вид списка комментариев

const CommentsList  = Mn.CollectionView.extend({
emptyView: emptyView,
tagName:"ol",
id:"comments-list",
childView: Comment,
replaceElement:true
});


// Блок комментариев

const CommentsBlock =  Mn.View.extend({
collection: collection,
el:"#comments",
template:false,
regions: {
list:{
el:"#comments-list",
replaceElement: true
}

},
ui: {
button: '.sbmt',
textarea: '.new-comment',
descript: 'p.descript', 
cancel: '.cancel'
},

events:
{
'click @ui.button': 'addComment',
'click @ui.cancel': 'cancel'
},

initialize() {

return this;
},

onRender(){

	this.showChildView('list', new CommentsList({
      collection: this.collection
    }));

return this;
},

action: 'create',

addComment () {

console.log(this.getOption('action'));

let textarea = this.getUI('textarea');

let content = $(textarea).val().trim();

let view =  this;


if (!content) { alert('Ошибка! Введите текст комментария!');

return false;
}

if (this.getOption('action') == "create")
{


// Создание нового комментария

this.collection.create({content: content,
img_id: window.app.img_id
}, 
{wait:true,
success: function() {
	$(textarea).val('');}
}
);


}

else {

this.editChild.model.save({content: content},
{
	wait:true, 
	success: function(model, resp) {

	$(textarea).val('');

view.action = 'create';

alert(resp.msg);


view.getUI('descript').hide().fadeIn(300).text('Оставьте комментарий для потомков:');

}
});

}

},

onChildviewEditComment(child) {

let oldText = child.model.get('content');

let textarea = this.getUI('textarea');

$(textarea).val(oldText);

this.action = 'edit';

this.editChild = child;

this.getUI('descript').hide().fadeIn(300).text('Редактирование комментария:');

},

cancel() {

this.action = 'create';

this.getUI('descript').hide().fadeIn(300).text('Оставьте комментарий для потомков:');

this.getUI('textarea').val('');

}

});

let commentsBlock = new CommentsBlock();

commentsBlock.render();

