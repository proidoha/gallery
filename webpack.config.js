"use strict";

const webpack = require('webpack');


const NODE_ENV = process.env.NODE_ENV || 'development';

let ExtractTextPlugin = require("extract-text-webpack-plugin");
const path =  require('path');

module.exports = {
//	context: __dirname + '/app',
	context: __dirname,
    entry: { 

  app: './source/js/main.js',
  main: ['./source/css/style.css'],
  uploadfile: './source/js/upload.js'
},
    output: {
    	path: __dirname + '/dist',
        filename: '[name].js',
        library: "[name]",
        publicPath: "/"
        // chunkFilename: "[id].js"
    },

    watch: NODE_ENV == 'development',

    watchOptions: {
aggregateTimeout: 100
    },


     module: {
    loaders: [
     {
       test: /\.js$/,
       loader: "babel-loader",
       exclude: /(node_modules|bower_components)/,
        query  : {
         presets: [ 'es2015' ],
        plugins: ['transform-runtime']
       },
 cacheDirectory: true
     },


        {	test: /\.css$/,
         loader: ExtractTextPlugin.extract("style-loader", "css-loader"),
         exclude: /\.(ttf|woff)$/ },

         {
            test: /\.hbs$/,
            loader: 'handlebars-loader',
            exclude:  /(node_modules|bower_components)/
         },
         {
        test: /\.html$/,
        loader: 'underscore-template-loader'
      },

         { test:   /\.(png|jpg|svg|ttf|eot|woff|woff2)$/,
      loader: 'file?name=[path][name].[ext]'}

    ]
  },
   resolve: {
    	modulesDirectories: ['node_modules'],
    	 extensions: ['', '.js']
    },

    resolveLoader: {
modulesDirectories: ['node_modules'],
    	 extensions: ['', '.js'],
    	 moduleTemplates: ["*-webpack-loader", "*-web-loader", "*-loader", "*"]
    },

   devtool: NODE_ENV == 'development' ? 'cheap-module-source-map': null,
    
      plugins: [
        new ExtractTextPlugin("[name].css"),
        new webpack.NoErrorsPlugin(),

      // new webpack.optimize.CommonsChunkPlugin({
      // name: "common",
      // minChunks: 2
      //  }),

        new webpack.ProvidePlugin({
          // $: "jquery",
          _: "underscore",
          // Backbone: "backbone",
          // Marionette: 'backbone.marionette'
            }),

         new webpack.DefinePlugin({
      NODE_ENV: JSON.stringify(NODE_ENV),
      LANG:     JSON.stringify('ru')
    })
    ],

    noParse: [/node_modules\/(underscore|jquery|angular|backbone|marionette|backbone\.marionette|jquery)/],

  //     externals: {
  //   'jquery': '$'
  // }

  };

if (NODE_ENV == 'production') {
  module.exports.plugins.push(
      new webpack.optimize.UglifyJsPlugin({
        compress: {
          // don't show unreachable variables etc
          warnings:     false,
          drop_console: true,
          unsafe:       true
        }
          })
      );
}
