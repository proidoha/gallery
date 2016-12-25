"use strict";
import Mn from 'backbone.marionette';
import Bb from 'backbone';

let collection = new Bb.Collection();

const LiImg =  require('./LiImgView.js');

module.exports = Mn.CollectionView.extend({
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