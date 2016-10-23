'use strict';

module.exports = function (grunt) {
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-concat-css');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat_css: {
            options: {},
            web_css: {
                files: {
                    "./web/css/hotel.css": [
                        './src/HotelBundle/Resources/public/css/*.css',
                        './node_modules/bootstrap/dist/css/bootstrap.css',
                        './node_modules/bootstrap/dist/css/bootstrap-theme.css'
                    ]
                }
            }
        },
        concat: {
            options: {},

            web_js: {
                dest: "./web/js/hotel.js",
                src: [
                    './src/HotelBundle/Resources/public/js/lib/jquery-1.11.2.min.js',
                    './node_modules/bootstrap/dist/js/bootstrap.js',
                    './src/HotelBundle/Resources/public/js/lib/moment.min.js',
                    './src/HotelBundle/Resources/public/js/lib/pikaday.jquery.js',
                    './src/HotelBundle/Resources/public/js/lib/pikaday.js',
                    './src/HotelBundle/Resources/public/js/custom/*.js',
                    './src/HotelBundle/Resources/public/js/custom.js'
                ]
            }

        },
        uglify: {
            options: {},
            js: {
                files: {

                    "./web/js/hotel.js": "./web/js/hotel.js"


                }
            }
        }
    });

    grunt.registerTask('dev', ['concat_css', 'concat']);
    grunt.registerTask('init', ['concat_css', 'concat', 'uglify']);
};
