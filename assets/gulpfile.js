var 
    gulp = require('gulp'),
	imagemin = require('gulp-imagemin');

gulp.task('img', function() {
    gulp.src(['./img_full/*.png', './img_full/*.jpg', './img_full/*.gif', './img_full/*.svg'])
    .on('error', console.log) 
    .pipe(imagemin())
    .pipe(gulp.dest('./img/'));
});
	
gulp.task('default', ['img']);