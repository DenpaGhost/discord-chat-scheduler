<template>
  <div>
    <div class="server-name-container">
      <div>
        <h3 class="text-high">{{ serverName }}</h3>
      </div>
      <div class="server-control-container">
        <button class="button-link">
          <fa :icon="icon.cog"/>
        </button>
      </div>
    </div>

    <h3>
      Tasks
    </h3>

    <div>
      <task-card/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";
import TaskCard from "~/components/guild-detail/TaskCard.vue";
import {faCog} from "@fortawesome/free-solid-svg-icons";

@Component({
  components: {TaskCard}
})
export default class Index extends Vue {
  @Prop({type: String, default: 'サーバー名'})
  serverName!: string;

  get icon() {
    return {
      cog: faCog
    }
  }
}
</script>

<style lang="scss">
.server-name-container {
  display: flex;
  align-items: center;

  .server-control-container {
    margin-left: 0.25em;
  }
}
</style>