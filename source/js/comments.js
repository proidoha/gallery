"use strict";
import Mn from 'backbone.marionette';
import Bb from 'backbone';

// [{id:1,content:"Комментарий"}]
const Collection = Bb.Collection.extend({
url: "/source/php/app/comments.php"
});

let collection = new Collection();

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
template(data){
 return require('./tpl/one-comment.hbs')(data);

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
// forma: {
// el:"#add-comments"
// }

},
ui: {
button: '.sbmt',
textarea: '.new-comment'
},

events:
{
'click @ui.button': 'addComment'
},

initialize() {

return this;
},

onRender(){

console.log( 111);

	this.showChildView('list', new CommentsList({
      collection: this.collection
    }));

return this;
},

action: 'create',

addComment () {

if (this.getOption('action') == "create")
{

let textarea = this.getUI('textarea');

console.log(textarea);

let content = $(textarea).val().trim();

console.log(content);



if (!content) { alert('Ошибка! Введите текст комментария!');

return false;
}

this.collection.create({content: content, 
img_id: 1
}, {wait:true});

}


}

});

let commentsBlock = new CommentsBlock();

commentsBlock.render();

console.log(commentsBlock);