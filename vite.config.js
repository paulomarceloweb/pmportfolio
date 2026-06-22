import { defineConfig } from "vite";
import { resolve } from "path";
import { readdirSync } from "fs";

/**
 * PMPortfolio — Vite Config
 *
 * Processa APENAS CSS — minificação e hash para cache busting.
 * JS continua sendo carregado diretamente pelo WordPress
 * para preservar o escopo global das funções compartilhadas.
 */

export default defineConfig({
  build: {
    outDir: resolve(__dirname, "assets/dist"),
    emptyOutDir: true,
    manifest: true,

    rollupOptions: {
      input: (() => {
        const entries = {};
        const cssDir = resolve(__dirname, "assets/css");

        readdirSync(cssDir)
          .filter((f) => f.endsWith(".css"))
          .forEach((f) => {
            entries[`css/${f.replace(".css", "")}`] = resolve(cssDir, f);
          });

        return entries;
      })(),

      output: {
        assetFileNames: "[name].[hash][extname]",
      },
    },

    minify: process.env.NODE_ENV === "production" ? "esbuild" : false,
  },
});
