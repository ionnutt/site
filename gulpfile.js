/*
  This is an EXAMPLE gulpfile.js
  You'll want to change it to match your project.
  Find plugins at https://npmjs.org/browse/keyword/gulpplugin
*/
var gulp = require('gulp');
var uglify = require('gulp-uglify');

gulp.task('scripts', function() {
  // Minify and copy all JavaScript (except vendor scripts)
  gulp.src(['./js/**/*.js', '!./js/vendor/**'])
    .pipe(uglify())
    .pipe(gulp.dest('build/js'));

  // Copy vendor files
  gulp.src('./js/vendor/**')
    .pipe(gulp.dest('build/js/vendor'));
});

// Copy all static assets
gulp.task('copy', function() {
  gulp.src('./img/**')
    .pipe(gulp.dest('build/img'));

  gulp.src('./css/**')
    .pipe(gulp.dest('build/css'));

  gulp.src('./*.html')
    .pipe(gulp.dest('build'));
});

// The default task (called when you run `gulp`)
gulp.task('default', function() {
  gulp.run('scripts', 'copy');

  // Watch files and run tasks if they change
  gulp.watch('./js/**', function(event) {
    gulp.run('scripts');
  });

  gulp.watch([
    './img/**',
    './css/**',
    './*.html'
  ], function(event) {
    gulp.run('copy');
  });
});