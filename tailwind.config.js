const defaultTheme = require('tailwindcss/defaultTheme');

let colors = {
    primary: 'var(--primary)',
    'primary-50': 'var(--primary-50)',
    info: 'var(--info)',
    danger: 'var(--danger)',
    warning: 'var(--warning)',
    success: 'var(--success)',
}

module.exports = {
    mode: 'jit',
    purge: [
        './node_modules/@protonemedia/inertiajs-tables-laravel-query-builder/**/*.{js,vue}',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },

            colors: colors,

            textColors: colors,

            backgroundColors: colors,

            borderColors: colors,
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
