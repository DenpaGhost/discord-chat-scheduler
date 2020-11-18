<template>
  <div class="view-container">
    <div class="sidenavi-container">

    </div>
    <div class="mainarea-container">
      <nuxt/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";

@Component
export default class Default extends Vue {
  head() {
    return {
      bodyAttrs: {
        class: 'light'
      }
    }
  }
}
</script>

<style scoped>

</style>