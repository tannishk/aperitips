[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net)

EmakinaFR Aperitips
==========

Symfony 3 project to organise internal conferences.

## Requirement

* php >= 7.1
* yarn
* sass
* grunt-cli

## Installation

### Install the project localy

* Create a **www** directory within your **home** directory

```
mkdir ~/www
```

* Go to **www** and clone the project
```
cd www && git clone git@github.com:EmakinaFR/aperitips.git
```

* Install all dependencies with composer `composer install`
* Create a new database and update the `parameters.yml` with the correct credentials
* Run the migrations `php bin/console doctrine:migrations:migrate`
* Load fixtures `php bin/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures/Auth/ --append`
* Start the PHP web server by running `php bin/console server:start`
* Go to **http://127.0.0.1:8000** to see the project

### Building the frontend

#### Sass, Yarn & Grunt

This project use Sass. Sass is a Ruby dependency but if you're using a Mac, congratulations, Ruby comes pre-installed.
If you're using something else you can check [sass install documentation](http://sass-lang.com/install).

* Install Sass `gem instamm sass`
* Install Yarn by following the instructions [here](https://yarnpkg.com/en/docs/install)
* Install Grunt globally `yarn global add grunt-cli`
* Run `yarn` to install all dependencies of the project
* Run `grunt compress` to build the assets

#### Available tasks

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

| Alias         | Tasks |
| ------------- | ------------- |
| default       | "sass", "csscomb", "autoprefixer", "imagemin","concat", "browserSync", "watch" |
| dev           | "sass", "csscomb", "autoprefixer", "imagemin","concat" |
| check         | "sasslint", "jshint"  |
| compile       | "sasslint", "sass", "csscomb", "autoprefixer"  |
| compress      | "sass", "csscomb", "autoprefixer", "cssmin", "imagemin", "concat", "uglify" |

## Back-end

### Coding Rules

We are using the [Symfony coding standard](http://symfony.com/doc/master/contributing/code/standards.html).
Symfony follows the standard defined in the [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-4](http://www.php-fig.org/psr/psr-4/) documents.

To fix your code by following these standards, you can use these commands:

```
./vendor/bin/php-cs-fixer fix --diff --dry-run
```

By removing the option `--dry-run`, `php-cs-fixer` will automatically fix your code

## Front-end 

### Theme Architecture

The theme is managed in `/web` and all editable files must be in `web/sources`. 

The rendering files will be generated with the grunt commands, in the `/web/assets` repository.
