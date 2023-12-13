import {reactive} from "vue";

export const theme = reactive({
    dark: false,
    setTheme(theme) {
        this.dark = theme === 'dark';
    },
    getTheme() {
        return this.dark
    }
});
