import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './resources/views/mails/**/*.blade.php',
    ],
    theme: {
        screens: {
            'xxs': '375px',
            'xs': '475px',
            ...defaultTheme.screens,
        },
        fontFamily: {
            'sans': ['"DM Sans"', 'system-ui'],
            'filament': ['DM Sans', ...defaultTheme.fontFamily.sans],
            'serif': ['Georgia', 'ui-serif'],
            'display': ['"PP Eiko"', 'system-ui'],
            'mono': ["JetBrains Mono", 'monospace']
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
