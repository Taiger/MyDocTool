'use strict';
 
module.exports = function (grunt) {
    // load all grunt tasks
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    
    grunt.initConfig({
      // Metadata.
      pkg: grunt.file.readJSON('package.json'),
      banner: '/*!\n' +
              ' * Style Guide v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
              ' * Copyright 2014-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
              ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
              ' */\n',

        cssmin: {
          add_banner: {
            options: {
              banner: '/* Minified css file */'
            },
            combine: {
              files: {
                'dist/css/main.min.css': ['dist/css/main.css']
              }
            },
          },
        },
        watch: {
                less: {
            // if any .less file changes in directory "less/" run the "less"-task.
                  files: 'less/*.less',
                  tasks: 'less'
                }
        },
        // "less"-task configuration
        less: {
            compileCore: {
              options: {
                strictMath: true,
                sourceMap: true,
                outputSourceFiles: true,
                sourceMapURL: 'style.css.map',
                sourceMapFilename: 'dist/css/style.css.map'
              },
              files: {
                'dist/css/style.css': 'less/style.less'
              }
            },
            minify: {
              options: {
                cleancss: true,
                report: 'min'
              },
              files: {
                'dist/css/style.min.css': 'dist/css/style.css'
              }
            }
        },
    });
     // the default task (running "grunt" in console) is "less"
     grunt.registerTask('default', ['less']);
     grunt.registerTask('run', ['watch']);
     grunt.registerTask('deploy', ['less','cssmin']);
};