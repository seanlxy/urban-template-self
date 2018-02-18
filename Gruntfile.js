module.exports = function(grunt){

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		concat:{
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
				separator: ';'
			},
			dist: {
				files: [{src:[
						'themes/global/assets/js/libs/unmin/jquery-2.2.2.js',
						'themes/global/assets/js/libs/unmin/slick.js',
						'themes/global/assets/js/libs/unmin/photoswipe.js',
						'themes/global/assets/js/libs/unmin/photoswipe-ui-default.js',
						'themes/global/assets/js/libs/unmin/shuffle.js',
						'themes/global/assets/js/libs/unmin/moment.js',
						'themes/global/assets/js/libs/unmin/pikaday.js',
						'themes/global/assets/js/libs/unmin/steps.js',
						'themes/global/assets/js/libs/unmin/bootstrap.js'
					],
						dest: 'themes/global/assets/js/libs/min/vendor.js'
					},
						{src:[
	                           
	                    'themes/global/assets/js/unmin/script.js'
	                    ],                
	                   	dest: 'themes/global/assets/js/unmin/main.js'	                
	                }]
			}
		},
		uglify:{
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				files: [{
		            src: 'themes/global/assets/js/libs/min/vendor.js',
		            dest: 'themes/global/assets/js/libs/min/vendor.js'
		        }, {
		            src: 'themes/global/assets/js/unmin/main.js',
		            dest: 'themes/global/assets/js/min/main.js'
		        }]
			}
		},
		sass_import: {
		    options: {
		    	banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd HH:MM:ss o") %> */\n'
		    },
		    dist: {
		    	files: [{
			      'themes/palette1/assets/sass/main.scss': [{
			      		path: 'themes/global/assets/sass/main.scss', 
			      		first: 'themes/palette1/assets/sass/_variables.scss'
			      	}]
			    }, {
			      'themes/palette2/assets/sass/main.scss': [{
			      		path: 'themes/global/assets/sass/main.scss', 
			      		first: 'themes/palette2/assets/sass/_variables.scss'
			      	}]
			    }, {
			      'themes/palette3/assets/sass/main.scss': [{
			      		path: 'themes/global/assets/sass/main.scss', 
			      		first: 'themes/palette3/assets/sass/_variables.scss'
			      	}]
			    }],
			}
		},
		sass: {
			options: {
		    	banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd HH:MM:ss o") %> */\n'
		    },
			dist: {
				files: [
					{'themes/palette1/assets/css/_main_xl.css' : 'themes/palette1/assets/sass/main.scss'},
					{'themes/palette2/assets/css/_main_xl.css' : 'themes/palette2/assets/sass/main.scss'},
					{'themes/palette3/assets/css/_main_xl.css' : 'themes/palette3/assets/sass/main.scss'},

				]
			}
		},
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: [
					{'themes/palette1/assets/css/main.css': 'themes/palette1/assets/css/_main_xl.css'},
					{'themes/palette2/assets/css/main.css': 'themes/palette2/assets/css/_main_xl.css'},
					{'themes/palette3/assets/css/main.css': 'themes/palette3/assets/css/_main_xl.css'},
				]
			}
		},
		watch: {
			scripts:{
				files: ['themes/global/assets/js/libs/unmin/*.js', 
					'themes/global/assets/js/unmin/script.js', 
					'Gruntfile.js'],
				tasks: ['concat', 'uglify'],
	      	}, 
	      	css: {
			    files: ['themes/global/assets/sass/main.scss',
			    	'themes/palette1/assets/sass/_variables.scss',
			    	'themes/palette2/assets/sass/_variables.scss',
			    	'themes/palette3/assets/sass/_variables.scss'
			      	],
			    tasks: ['sass_import', 'sass', 'cssmin']
		    }
	    }

	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass-import');
	grunt.registerTask('default', ['watch']);

};