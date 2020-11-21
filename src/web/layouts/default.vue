<template>
  <div class="view-container">
    <div class="sidenavi-container">
      <guild-list/>
    </div>
    <div class="mainarea-container">
        <nuxt/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import GuildList from "~/components/guilds/GuildList.vue";

@Component({
  components: {GuildList}
})
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

<style lang="scss">

</style>