import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true
    }),
    vue()
  ],
  // Configuration needed to work on WSL2
  server: {
    hmr: {
      host: 'localhost'
    },
    watch: {
      usePolling: true
    }
  }
})
