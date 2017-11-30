module.exports = function (grunt) {
    grunt.initConfig({
        clean: {
            build: {
                src: ['css/styles.min.css', 'js/app.min.js']
            }
        },
        cssmin: {
            combine: {
                dest: 'css/styles.min.css',
                src: [
                    'node_modules/font-awesome/css/font-awesome.min.css',
                    'node_modules/metisMenu/dist/metisMenu.min.css',
                    'css/styles.css',// My Styles
                ]
            }
        },
        requirejs: {
            compile: {
                options: {
                    almond: true,
                    baseUrl: ".",
                    out: 'js/app.min.js',
                    name: 'main',
                    mainConfigFile: 'main.js',// My Scripts
                    include: ['node_modules/requirejs/require'],
                    preserveLicenseComments: false
                }
            }
        },
        jshint: {
            all: ['Gruntfile.js', 'js/**/*.js', 'main.js']
        }
    });

    // Cargamos las tareas Grunt
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-requirejs');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Registramos las tareas Grunt
    grunt.registerTask('doclean', ['clean']);
    grunt.registerTask('jscheck', ['jshint']);
    grunt.registerTask('jso', ['requirejs']);

    // tarea que crea el archivo de estilo minificado en "CSS".
    grunt.registerTask('minify', ['cssmin']);

    // tarea que crea el archivo de javascript minificado en "JS".
    grunt.registerTask('jsapp', ['jshint', 'requirejs']);

    // tarea que realiza todos los archivos minificados para el ambiente de "PRODUCCION".
    grunt.registerTask('runapp', ['jscheck', 'doclean', 'minify', 'requirejs']);

    // tarea que realiza todos los archivos minificados para el ambiente de "post PRODUCCION".
    grunt.registerTask('run', ['doclean', 'minify', 'requirejs']);

};