<template>
  <div class="guild-list-container">
    <guild-list-item v-for="it in [...Array(20)].map((v, i)=> i)" :is-opening="false"/>
  </div>
</template>

<script>
import GuildListItem from "@/components/guilds/GuildListItem";

export default {
  name: "GuildList",
  components: {GuildListItem}
}
</script>

<style lang="scss">
.guild-list-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>