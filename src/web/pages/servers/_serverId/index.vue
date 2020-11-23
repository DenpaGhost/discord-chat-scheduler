<template>
  <div>
    <div class="server-name-container">
      <div>
        <h3 class="text-high">{{ serverName }}</h3>
      </div>
      <div class="server-control-container">
        <tooltip-button :right="true">
          <template v-slot:label>
            <nuxt-link :to="`/servers/${serverId}/settings`"
                       class="button-link">
              <fa :icon="icon.cog"/>
            </nuxt-link>
          </template>
          <template v-slot:tooltip>
            管理ロール設定
          </template>
        </tooltip-button>
      </div>
    </div>

    <h3>
      予約中のメッセージ
    </h3>

    <div class="task-list-container">
      <task-card/>
      <task-card/>
      <task-card/>
      <task-card/>
      <task-card/>
      <task-card/>
      <task-card/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";
import TaskCard from "~/components/guild-detail/TaskCard.vue";
import {faCog} from "@fortawesome/free-solid-svg-icons";
import TooltipButton from "~/components/general/TooltipButton.vue";

@Component({
  components: {TooltipButton, TaskCard}
})
export default class Index extends Vue {
  @Prop({type: String, default: 'サーバー名'})
  serverName!: string;

  get icon() {
    return {
      cog: faCog
    }
  }

  get serverId() {
    return this.$route.params['serverId'];
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

.task-list-container {
  & > div {
    margin-bottom: 1em;
  }
}
</style>