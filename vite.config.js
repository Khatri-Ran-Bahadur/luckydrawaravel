import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss({
            darkMode: false,
        }),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/front.css",
                "resources/css/admin.css",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
