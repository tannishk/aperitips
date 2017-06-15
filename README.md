EmakinaFR Aperitips
==========

Symfony 3 project to organise internal conferences.

## Getting started

First you need to clone this repository :

$ git clone git@github.com:EmakinaFR/aperitips.git`

Then go in you repository and install the Symfony core with composer :

`composer install`

## Grunt

### Installation

Grunt and Grunt plugins are installed and managed via [npm](https://www.npmjs.com/), 
the [Node.js](https://nodejs.org/en/) package manager.

If you don't have grunt, you need to install it :

`npm install -g grunt-cl`


Then install grunt and its plugins on your project with :

`npm install`

### Available tasks

| Task          | Description |
| ------------- | ------------- |
| watch         | Run predefined tasks whenever watched files change. |
| sasslint      | Validate your Sass and generate a log file in `web/sources/log`.  |
| sass          | Compile Sass to CSS.  |
| csscomb       | Sorting CSS properties in specific order. |
| autoprefixer  | Prefix CSS files. |
| cssmin        | Minify CSS. |
| imagemin      | Minify PNG, JPEG, GIF and SVG images. |
| concat        | Concatenate files. |
| jshint        | Validate files with JSHint. |
| uglify        | Minify files with UglifyJS. |
| browserSync   | Keep your browsers in sync  |

| Alias          | Tasks |
| -------------  | ------------- |
| default        | "sass", "csscomb", "autoprefixer", "imagemin","concat", "browserSync", "watch" |
| dev            | "sass", "csscomb", "autoprefixer", "imagemin","concat" |
| check          | "sasslint", "jshint"  |
| compile        | "sasslint", "sass", "csscomb", "autoprefixer"  |
| compress       | "sass", "csscomb", "autoprefixer", "cssmin", "imagemin", "concat", "uglify" |

To use browserSync plugin (`grunt browserSync` or `grunt`) you need to have a local server setup (with your vhosts etc) :

`127.0.0.1  aperitips.dev`

## Front-end 

The theme is managed in `/web` and all editable files must be in `web/sources`. 

The rendering files will be generated with the grunt commands, in the `/web/assets` repository.
