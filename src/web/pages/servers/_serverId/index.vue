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

    <div class="task-add">
      <div>
        <h3>
          予約中のメッセージ
        </h3>
      </div>
      <div>
        <tooltip-button right>
          <template v-slot:label>
            <button type="button" class="button-link">
              <fa :icon="icon.plus"/>
            </button>
          </template>
          <template v-slot:tooltip>
            メッセージの予約を追加
          </template>
        </tooltip-button>
      </div>
    </div>

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
import {faCog, faPlus} from "@fortawesome/free-solid-svg-icons";
import TooltipButton from "~/components/general/TooltipButton.vue";

@Component({
  components: {TooltipButton, TaskCard}
})
export default class Index extends Vue {
  @Prop({type: String, default: 'サーバー名'})
  serverName!: string;

  get icon() {
    return {
      cog: faCog,
      plus: faPlus
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

.task-add {
  display: flex;
  align-items: center;

  & > div:nth-child(2) {
    margin-left: 0.5em;
  }
}
</style>