var gulp = require('gulp'),
    bower = require('gulp-bower'),
    jshint = require('gulp-jshint'),
    qunit = require('gulp-qunit');

gulp.task('lint', function () {
    return gulp.src(['./mention/plugin.js', './tests/test_mention.js'])
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(jshint.reporter('fail'));
});

gulp.task('bower', function () {
    return bower();
});

gulp.task('test', ['bower'], function () {
    return gulp.src('./tests/test_runner.html')
        .pipe(qunit({ timeout: 10 }));
});

gulp.task('default', ['lint']);