/** @type {import('postcss-load-config').Config} */
const config = {
    plugins: [
        require('tailwindcss'),
        require('autoprefixer')
    ]
}

module.exports = config
