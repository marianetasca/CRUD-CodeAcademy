import { defineConfig } from 'vite';

export default defineConfig({
  server: {
    port: 8080,        // mesma porta liberada no CORS da API
    strictPort: true,  // falha se 8080 estiver ocupada, em vez de trocar sozinho
  },
});