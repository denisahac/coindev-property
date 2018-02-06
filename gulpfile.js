// load gulp plugins.
var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var jshint = require('gulp-jshint');

/**
 * Task for converting SCSS to CSS.
 */
gulp.task('sass', function() {
	return gulp.src('assets/scss/**/*.scss')
		.pipe(sass())
		.pipe(postcss([autoprefixer()]))
		.pipe(gulp.dest('assets/css'));
});

/**
 * Another SCSS to CSS task, this time, for admin/ folder.
 */
gulp.task('sass-admin', function() {
	return gulp.src('admin/scss/**/*.scss')
		.pipe(sass())
		.pipe(postcss([autoprefixer()]))
		.pipe(gulp.dest('admin/css'));
});

/**
 * Javascript linter task.
 */
gulp.task('lint', function() {
	return gulp.src('assets/js/**/*.js')
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});

/**
 * Watches file changes, then, execute the corresponding task.
 */
gulp.task('watch', function() {
	gulp.watch('assets/scss/**/*.scss', ['sass']); // watch changes for SCSS files.
	gulp.watch('admin/scss/**/*.scss', ['sass-admin']); // watch changes for SCSS files in admin/ folder.
	gulp.watch('assets/js/**/*.js', ['lint']); // watch changs for javascript files.
})

/**
 * The default task that gulp runs, combines: sass, lint, and watch.
 */
gulp.task('default', ['sass', 'sass-admin', 'lint', 'watch']);