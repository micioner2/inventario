const mix = require('laravel-mix');



// scripts(['resources/js/sweetalert2.all.js'], 'public/assets/js/plantilla.js')

mix.js('resources/js/sweetalert2.all.js', 'public/assets/js/app.js');
mix.js('resources/js/app.js', 'public/assets/js/app.js');
// .sass('resources/sass/app.scss','public/assets/css/sass.css');
