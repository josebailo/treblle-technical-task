import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true
    })
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
