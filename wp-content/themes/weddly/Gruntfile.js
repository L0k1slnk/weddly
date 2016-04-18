module.exports = function (grunt) {
    grunt.initConfig({
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'Dist/styles/style.css': 'Dev/styles/style.scss'
                }
            }
        },
        postcss: {
            options: {
                map: true,
                processors: [
                    require('autoprefixer')({
                        browsers: ['> 1%']
                    }),
                    require('cssnano')(),
                    require('cssnext')
                ]
            },
            dist: {
                src: 'Dist/styles/*.css'
            }
        },
        concat: {
            scripts: {
                files: {
                    'Dist/scripts/fouc.js': ['Dev/scripts/vendor/modernizr.js', 'Dev/scripts/vendor/detectizr.js', 'Dev/scripts/foucInit.js'],
                    'Dist/scripts/main.js': ['Dev/scripts/vendor/jquery-1.12.2.min.js', 'Dev/scripts/vendor/slideout.js', 'Dev/scripts/vendor/photoswipe.min.js', 'Dev/scripts/vendor/photoswipe-ui-default.min.js', 'Dev/scripts/menu.js', 'Dev/scripts/gallery.js']
                }
            }
        },
        uglify: {
            options: {
                compress: {
                    drop_console: true
                }
            },
            dist: {
                files: {
                    'Dist/scripts/main.min.js': ['Dist/scripts/main.js']
                }
            }
        },
        watch: {
            styles: {
                files: ['Dev/styles/**/*.scss'],
                tasks: ['sass', 'postcss'],
                options: {
                    spawn: false
                }
            },
            scripts: {
                files: ['Dev/scripts/**/*.js'],
                tasks: ['concat']
            }
        },

    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks("grunt-contrib-concat");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks('grunt-newer');

    grunt.registerTask("default", ["newer:sass", "newer:concat", "newer:postcss", "watch"]);
    grunt.registerTask("all", ["sass", "concat", "postcss"]);
    grunt.registerTask("dist", ["uglify"]);

};