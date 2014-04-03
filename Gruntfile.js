module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		cssmin: {
			minify: {
				expand: true,
				cwd: 'assets/css/',
				src: ['*.css', '!*.min.css'],
				dest: 'assets/css/',
				ext: '.min.css'
			}
		},
		uglify: {
			files: {
				src: 'assets/js/admin.js',
				dest: 'assets/js/',
				expand: true,
				flatten: true,
				ext: '.min.js'
			}
		},
		po2mo: {
			files: {
				src: 'langs/*.po',
				expand: true,
			},
		},
		watch: {
			js:  {
				files: 'assets/js/admin.js',
				tasks: [ 'uglify' ]
			},
			cssmin: {
				files: 'assets/css/admin.css',
				tasks: ['cssmin']
			},
			po2mo: {
				files: 'languages/*.po',
				tasks: ['po2mo']
			}
		},
		makepot: {
			target: {
				options: {
					domainPath: '/langs',
					potFilename: 'wp-editor-widget.pot',
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = 'https://github.com/feedmeastraycat/wp-editor-widget/issues\n';
						pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;';
						pot.headers['last-translator'] = 'David Mårtensson <david@oddalice.se>\n';
						pot.headers['language-team'] = 'David Mårtensson <david@oddalice.se>\n';
						pot.headers['x-poedit-basepath'] = '.\n';
						pot.headers['x-poedit-language'] = 'English\n';
						pot.headers['x-poedit-country'] = 'UNITED STATES\n';
						pot.headers['x-poedit-sourcecharset'] = 'utf-8\n';
						pot.headers['x-poedit-keywordslist'] = '__;_e;__ngettext:1,2;_n:1,2;__ngettext_noop:1,2;_n_noop:1,2;_c,_nc:4c,1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;\n';
						pot.headers['x-poedit-bookmarks'] = '\n';
						pot.headers['x-poedit-searchpath-0'] = '.\n';
						pot.headers['x-textdomain-support'] = 'yes\n';
						return pot;
					},
					type: 'wp-plugin'
				}
			}
		}
	});

	// Load plugins
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-wp-i18n');
	grunt.loadNpmTasks('grunt-po2mo');

	// Register tasks
	grunt.registerTask('default', [ 'watch' ]);

};