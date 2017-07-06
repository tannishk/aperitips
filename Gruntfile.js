module.exports = function (grunt) {
    'use strict';

    const today = function () {
        const time = new Date().toLocaleTimeString().replace(/:/g, '-');
        const day = new Date().toLocaleDateString();

        return day + '_' + time;
    };

    // Do grunt-related things in here
    grunt.initConfig({

        // Paths (use with <%= path %> for example)
        dest: 'web/assets/',
        src: 'web/sources/',
        $s: 'styles',
        $j: 'js',
        $i: 'images',
        config: 'grunt_config',
        log: 'web/sources/logs',
        jsName: 'main',
        date: today(),

        // Store the project settings from the package.json file into the pkg property
        pkg: grunt.file.readJSON('package.json'),

        // Sasslint task options
        sasslint: {
            options: {
                configFile: '<%= config %>/.sass-lint.yml',
                formatter: 'json',
                outputFile: '<%= log %>/sass_report.json'
            },
            target: {
                expand: true,
                cwd: '<%= src %>/<%= $s %>',
                src: ['*.sass']
            }
        },

        // Sass task options
        sass: {
            dist: {
                options: {
                    sourcemap: 'none'
                },
                files: [{
                    expand: true,
                    cwd: '<%= src %>/<%= $s %>',
                    src: ['*.sass'],
                    dest: '<%= dest %>/<%= $s %>',
                    ext: '.css'
                }]
            }
        },

        // Csscomb task options
        csscomb: {
            options: {
                config: '<%= config %>/.csscomb.json'
            },
            dist: {
                expand: true,
                cwd: '<%= dest %>/<%= $s %>',
                src: ['*.css'],
                dest: '<%= dest %>/<%= $s %>',
                ext: '.css'
            }
        },


        // Autoprefixer task options
        autoprefixer: {
            options: {
                browsers: ['> 1%', 'last 2 versions', 'ie >= 10']
            },
            dist: {
                expand: true,
                cwd: '<%= dest %>/<%= $s %>',
                dest: '<%= dest %>/<%= $s %>',
                src: ['*.css']
            }
        },

        // Cssmin task options
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            target: {
                files: [{
                    expand: true,
                    cwd: '<%= dest %>/<%= $s %>',
                    src: ['*.css'],
                    dest: '<%= dest %>/<%= $s %>',
                    ext: '.css'
                }]
            }
        },

        // Imagesmin task options
        imagemin: {
            dynamic: {
                options: {
                    optimizationLevel: 3,
                    progressive: false
                },
                files: [{
                    expand: true,
                    cwd: '<%= src %>/<%= $i %>',
                    src: ['**/*.{png,jpg,gif,svg,ico}'],
                    dest: '<%= dest %>/<%= $i %>'
                }]
            }
        },

        // Jshint task options
        jshint: {
            options: {
                reporter: '<%= config %>/reporter.js',
                jshintrc: '<%= config %>/.jshintrc'
            },
            target: ['Gruntfile.js', '<%= src %>/<%= $j %>/**/*.js', '<%= config %>/reporter.js']
        },

        // Concat task options
        concat: {
            dist: {
                src: ['<%= src %>/<%= $j %>/**/*.js'],
                dest: '<%= dest %>/<%= $j %>/<%= jsName %>.js'
            }
        },

        // Uglify task options
        uglify: {
            options: {
                mangle: {
                    reserved: ['jQuery']
                }
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= dest %>/<%= $j %>',
                    src: '**/*.js',
                    dest: '<%= dest %>/<%= $j %>'
                }]
            }
        },

        // BrowserSync task options
        browserSync: {
            dev: {
                bsFiles: {
                    src : [
                        '<%= dest %>/<%= $s %>/**/*.css',
                        '<%= src %>/<%= $i %>/**/*.{png,jpg,gif,svg,ico}',
                        '<%= dest %>/<%= $j %>/**/*.js',
                        'app/**/*.twig'
                    ]
                },
                options: {
                    proxy: 'aperitips.dev/app_dev.php',
                    watchTask: true
                }
            }
        },

        // Watch task options
        watch: {
            configFiles: {
                files: 'Gruntfile.js',
                options: {
                    reload: true

                }
            },
            // Watch sass changes
            sass: {
                files: ['<%= src %>/<%= $s %>/**/*.sass'],
                tasks: ['sass', 'csscomb', 'autoprefixer']
            },
            // Watch imagemin changes
            images: {
                files: '<%= src %>/<%= $i %>/**/*.{png,jpg,gif,svg}',
                tasks: 'newer:imagemin',
                options: {
                    event: ['added', 'changed', 'deleted']
                }
            },
            // Watch jshint changes
            jshint: {
                files: '<%= src %>/<%= $j %>/**/*.js',
                tasks: 'newer:concat',
                options: {
                    event: ['added', 'changed', 'deleted']
                }
            }
        }

    });

    // Load packages
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-newer');

    grunt.loadNpmTasks('grunt-sass-lint');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-csscomb');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.loadNpmTasks('grunt-contrib-imagemin');

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');


    // developpement task
    grunt.registerTask('check', ['sasslint', 'jshint']);
    grunt.registerTask('compile', ['sasslint', 'sass', 'csscomb', 'autoprefixer']);
    grunt.registerTask('default', ['sass', 'csscomb', 'autoprefixer', 'imagemin', 'concat', 'browserSync', 'watch']);
    grunt.registerTask('dev', ['sass', 'csscomb', 'autoprefixer', 'imagemin', 'concat']);
    grunt.registerTask('compress', ['sass', 'csscomb', 'autoprefixer', 'cssmin', 'imagemin', 'concat', 'uglify']);
};
