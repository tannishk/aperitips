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

### Install the environement localy

* Create a **www** directory within your **home** directory

```
mkdir ~/www
```

* Go to **www** and clone the project
```
cd www && git clone git@github.com:EmakinaFR/aperitips.git
```

* Install [Homestead](https://github.com/laravel/homestead) by following the instructions [here](https://laravel.com/docs/5.4/homestead)
* Go to **Homestead** and edit the `Homestead.yml` with these lines

```
folders:
    - map: ~/www
      to: /home/vagrant/www

sites:     
    - map: aperitips.app
      to: /home/vagrant/www/aperitips/web
      type: symfony2
```
* Edit your **hosts** file located at `/etc/hosts` and add this line
```
192.168.10.10 aperitips.app
```

* Go back to your **Homestead** folder and run `vagrant up` to launch the VM
* Create a new MySQL Connection inside MySQL Workbench with the following parameters
    * **SSH Hostname**: `192.168.10.10`
    * **SSH Username**: `vagrant`
    * **SSH Password**: `/Users/***/Homestead/.vagrant/machines/homestead-7/virtualbox/private_key`
    * **MySQL Hostname**: `127.0.0.1`
    * **MySQL Server Port**: `3306`
    * **Username**: `homestead`
    * **Password**: `secret`

### Install the project

* Connect to your VM with `vagrant ssh`
* Go to the project folder and install its dependencies with composer

```
cd www/aperitips
composer install
```

* Create a new database from the VM and update the `parameters.yml` with the correct credentials
* Run the migrations `php bin/console doctrine:migrations:migrate`
* Load fixtures `php bin/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures/Auth/ --append`

### Building the frontend

* Install Yarn by following the instructions [here](https://yarnpkg.com/en/docs/install)
* Install `Grunt` globally `yarn global add grunt-cli`
* Run `yarn` to install all dependencies of the project
* Run `grunt compress` to build the assets

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

### Sass Install

Sass has a Ruby dependency but if you're using a Mac, congratulations, Ruby comes pre-installed.
If you're using something else you can check [sass install documentation](http://sass-lang.com/install).

Ruby uses Gems to manage its various packages of code like Sass. In your open terminal window type:

`gem install sass`


