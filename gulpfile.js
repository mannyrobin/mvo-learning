var gulp = require('gulp'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify-es').default,
	cleancss = require('gulp-clean-css'),
	sourcemaps = require('gulp-sourcemaps'),
	babel = require('gulp-babel'),
	childtheme = 'web/wp-content/themes/hip-med-child/';

gulp.task('sass', function(){
	return gulp.src( childtheme+'assets/styles/*.scss' )
		.pipe(sourcemaps.init())
		.pipe( sass() )
		.pipe( cleancss() )
		.pipe(sourcemaps.write(''))
		.pipe( gulp.dest( childtheme+'dist/css'));
});

gulp.task('js', function() {
	return gulp.src(childtheme+ 'assets/scripts/*.js' )
		.pipe(sourcemaps.init())
		.pipe(babel({
			presets: ['@babel/env']
		}))
		.pipe( uglify())
		.pipe(sourcemaps.write(''))
		.pipe( gulp.dest( childtheme+'dist/js'));
} );
gulp.task('watch', function() {
	gulp.watch( childtheme+'assets/styles/**/*.scss',  gulp.series('sass'));
	gulp.watch( childtheme+'assets/scripts/*.js', gulp.series('js'));
});
