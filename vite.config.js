import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  base: './',
  build: {
    outDir: 'public',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'resources/scripts/main.js'),
        editor: path.resolve(__dirname, 'resources/scripts/editor.js'),
      },
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@use "sass:math";`,
      },
    },
  },
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    origin: 'http://localhost:5173',
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources'),
      '@styles': path.resolve(__dirname, 'resources/styles'),
      '@scripts': path.resolve(__dirname, 'resources/scripts'),
    },
  },
});
