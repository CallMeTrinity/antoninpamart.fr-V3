/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            fontFamily: {
                title: ['Anton', 'sans-serif'],
                display: ['Roboto Slab', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', 'Helvetica', 'Arial', 'sans-serif'],
                body: ['Open Sans', 'sans-serif'],
            },
        },
    },
    plugins: [],
}


