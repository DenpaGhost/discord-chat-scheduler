<template>
  <div class="task-card-container">
    <div class="task-card-control-container">
      <div class="task-card-control-channel">
        <b>
          <fa :icon="icon.hashtag"/>
          テキストチャンネル
        </b>
      </div>
      <div class="task-card-control-context">
        <div class="button-tooltip-container">
          <tooltip-button>
            <template v-slot:label>
              <button type="button"
                      class="button-link">
                <fa :icon="icon.pen"/>
              </button>
            </template>
            <template v-slot:tooltip>
              編集
            </template>
          </tooltip-button>
        </div>

        <div class="button-tooltip-container">
          <tooltip-button>
            <template v-slot:label>
              <button type="button"
                      class="button-link">
                <fa :icon="icon.trash"/>
              </button>
            </template>
            <template v-slot:tooltip>
              削除
            </template>
          </tooltip-button>
        </div>
      </div>
    </div>
    <p class="text-high task-card-message">
      メッセージ本文
    </p>
    <b>
      繰り返し間隔
    </b>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {faHashtag, faPen, faTrashAlt} from "@fortawesome/free-solid-svg-icons";
import TooltipButton from "~/components/general/TooltipButton.vue";

@Component({
  components: {TooltipButton}
})
export default class TaskCard extends Vue {
  get icon() {
    return {
      hashtag: faHashtag,
      pen: faPen,
      trash: faTrashAlt
    }
  }
}
</script>

<style lang="scss">
.task-card-container {
  padding: 1em;
  border-radius: 0.5em;

  h3 {
    margin: 0;
  }

  .task-card-message {
    font-size: 1.25rem;
  }

  .task-card-control-container {
    display: flex;
    flex-direction: row;
    align-items: center;

    .task-card-control-channel {
      flex-grow: 1;
    }

    .task-card-control-context {
      flex-grow: 0;
      font-size: 1em;

      display: flex;
      align-items: center;
      flex-direction: row;

      opacity: 0;
      transition: opacity 200ms ease-in-out;
    }
  }

  &:hover {
    .task-card-control-context {
      opacity: 1;
    }
  }
}

.light {
  .task-card-container {
    background-color: #ffffff;
    border: 2px solid #E3E5E9;
  }
}

.dark {
  .task-card-container {

  }
}
</style>