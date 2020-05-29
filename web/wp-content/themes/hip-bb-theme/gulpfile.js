var gulp = require('gulp'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify-es').default,
	cleancss = require('gulp-clean-css'),
	concat = require('gulp-concat'),
	sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', function() {
	gulp.src( 'assets/styles/*.scss' )
		.pipe(sourcemaps.init())
		.pipe( sass() )
		.pipe( cleancss() )
		.pipe(sourcemaps.write(''))
		.pipe( gulp.dest( 'dist/css' ) );
} );

gulp.task('frontend-js', function() {
	gulp.src( 'assets/scripts/frontend/*.js' )
		.pipe(sourcemaps.init())
		.pipe( uglify() )
		.pipe( concat( 'parent.js' ))
		.pipe(sourcemaps.write(''))
		.pipe( gulp.dest( 'dist/js' ) );
} );
gulp.task('admin-js', function() {
	gulp.src( 'assets/scripts/admin/*.js' )
		.pipe(sourcemaps.init())
		.pipe( uglify() )
		.pipe(concat( 'parent-admin.js' ))
		.pipe(sourcemaps.write(''))
		.pipe( gulp.dest( 'dist/js' ) );
} );

gulp.task('watch', function() {
	gulp.watch( 'assets/styles/**/*.scss', ['sass'] );
	gulp.watch( 'assets/scripts/frontend/*.js', ['frontend-js'] );
	gulp.watch( 'assets/scripts/admin/*.js', ['admin-js'] );
});
	
