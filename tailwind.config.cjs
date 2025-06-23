module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#1E3A8A',
                    light: '#5671E1',
                    dark: '#12246C',
                }
            }
        },
    },
    plugins: [],
};
