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
              ' * BrantElectric v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
              ' * Copyright 2014-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
              ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
              ' */\n',

        cssmin: {
          add_banner: {
            options: {
              banner: '/* My minified css file */'
            },
            combine: {
              files: {
                'css/main.min.css': ['css/main.css']
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
                sourceMapURL: 'main.css.map',
                sourceMapFilename: 'css/main.css.map'
              },
              files: {
                'css/main.css': 'less/main.less'
              }
            },
            compileTheme: {
              options: {
                strictMath: true,
                sourceMap: true,
                outputSourceFiles: true,
                sourceMapURL: 'main-theme.css.map',
                sourceMapFilename: 'css/main-theme.css.map'
              },
              files: {
                'css/main-theme.css': 'less/theme.less'
              }
            },
            minify: {
              options: {
                cleancss: true,
                report: 'min'
              },
              files: {
                'css/main.min.css': 'css/main.css',
                'css/main-theme.min.css': 'css/main-theme.css'
              }
            }
        },
    });
     // the default task (running "grunt" in console) is "watch"
     grunt.registerTask('default', ['watch']);

     grunt.registerTask('deploy', ['less','cssmin']);
};