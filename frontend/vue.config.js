const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  css: {
    loaderOptions: {
      scss: {
        additionalData: 
          `@import "@/assets/scss/_variables.scss"; 
          @import "@/assets/scss/_padroes.scss";
          @import "@/assets/scss/_base-button.scss";
          @import "@/assets/scss/_base-chip-checkbox.scss";`,
          
      },
    },
  },
})
