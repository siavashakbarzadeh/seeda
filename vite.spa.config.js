import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

// This config is for building the React SPA for Cloudflare Pages
// Usage: npx vite build --config vite.spa.config.js
export default defineConfig({
    plugins: [
        react(),
        tailwindcss(),
    ],
    root: '.',
    build: {
        outDir: 'dist',
        emptyOutDir: true,
    },
});
