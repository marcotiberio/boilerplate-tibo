import { defineConfig, loadEnv } from 'vite'
import { dest, entries, host, watchFiles } from './build-config.js'
import flynt from './vite-plugin-flynt'
import globImporter from 'node-sass-glob-importer'
import FullReload from 'vite-plugin-full-reload'
import fs from 'fs'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  const isSecure = host.indexOf('https://') === 0 && (env.VITE_DEV_SERVER_KEY || env.VITE_DEV_SERVER_CERT)

  return {
    base: './',
    css: {
      devSourcemap: true,
      preprocessorOptions: {
        scss: {
          importer: globImporter()
        }
      }
    },
    resolve: {
      alias: {
        '@': __dirname
      }
    },
    plugins: [flynt({ dest, host }), FullReload(watchFiles)],
    server: {
      https: isSecure
        ? {
            key: fs.readFileSync(env.VITE_DEV_SERVER_KEY),
            cert: fs.readFileSync(env.VITE_DEV_SERVER_CERT)
          }
        : false,
      host: 'localhost', // preserve conflicts with IpV6
      // Allow the DDEV site to load assets from the Vite dev server cross-origin.
      // Vite 4.5.14+ locks CORS down by default, blocking the theme's https origin.
      cors: {
        origin: [host, /https?:\/\/([a-z0-9-]+\.)*ddev\.site(:\d+)?$/]
      }
    },
    build: {
      // generate manifest.json in outDir
      manifest: true,
      outDir: dest,
      rollupOptions: {
        // overwrite default .html entry
        input: entries
      }
    }
  }
})
