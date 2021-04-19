var origen = "D:/www/corbac/beetrack/beetrack/plugin/**/*(*.php|*.html)",
    destino = "D:/www/corbac/wordpress/wp-content/plugins/beetrack/";


const { series, src, dest } = require('gulp'), del = require("del");;

function limpiar() {
    return del(destino, {
        force: true,
    });
}

function mover() {
    return src([origen])
        .pipe(dest(destino));
}

// exports.default = mover;

exports.mover = mover;
exports.default = series(limpiar, mover);



// function clean(cb) {
//     // // body omitted
//     // cb();
//     return del(destino, {
//         force: true,
//     });
// }

// function css(cb) {
//     // body omitted
//     cb();
// }

// function javascript(cb) {
//     // body omitted
//     cb();
// }

// exports.build = series(clean, parallel(css, javascript));