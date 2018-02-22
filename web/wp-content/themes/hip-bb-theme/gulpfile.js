var gulp = require('gulp'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify'),
	cleancss = require('gulp-clean-css'),
	util = require('gulp-util'),
	concat = require('gulp-concat'),
	log = util.log;


gulp.task('sass', function() {
	log( 'Generate CSS files ' + ( new Date()).toString() );
	gulp.src( 'assets/styles/*.scss' )
		.pipe( sass() )
		.pipe( cleancss() )
		.pipe( gulp.dest( 'dist/css' ) );
} );

gulp.task('js', function() {
	log( 'Uglify JS files ' + ( new Date()).toString() );
	gulp.src( 'assets/scripts/*.js' )
		.pipe( uglify() )
		.pipe( concat( 'parent.js' ) )
		.pipe( gulp.dest( 'dist/js' ) );
} );

gulp.task('watch', function() {
	gulp.watch( 'assets/styles/**/*.scss', ['sass'] );
	gulp.watch( 'assets/scripts/*.js', ['js'] );
});
	
