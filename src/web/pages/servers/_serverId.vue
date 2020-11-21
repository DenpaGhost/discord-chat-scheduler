<template>
  <div>
    <h3 class="text-high">{{ serverName }}</h3>

    <h3>
      Tasks
    </h3>

    <div class="task-table-container">
      <table class="task-table">
        <thead>
        <tr>
          <th class="task-table-channel">
            チャンネル
          </th>
          <th class="task-table-message">
            メッセージ
          </th>
          <th class="task-table-executes-in">
            初回投稿日時
          </th>
          <th class="task-table-repeat">
            繰り返し
          </th>
          <th class="task-table-button">

          </th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>
            チャンネル名
          </td>
          <td class="task-table-message">
            メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文メッセージ本文
          </td>
          <td>
            yyyy/mm/dd
          </td>
          <td>
            repeat
          </td>
          <td>
            ボタン
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class Index extends Vue {
  @Prop({type: String, default: 'サーバー名'})
  serverName!: string;
}
</script>

<style lang="scss">
.task-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  white-space: nowrap;

  thead {
    text-align: left;

    .task-table-channel {
      width: 30%;
    }

    .task-table-message {
      width: 30%;
    }

    .task-table-executes-in {
      width: 20%
    }

    .task-table-repeat {
      width: 10%
    }

    .task-table-button {
      width: 10%;
    }
  }

  tbody tr {
    height: 4em;

    .task-table-message {
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
    }
  }
}

.light {
  .task-table {
    thead th {
      border-bottom: 3px #E3E5E9;
    }

    tbody {
      border-top: 1px solid #E3E5E9;
      border-bottom: 1px solid #E3E5E9;
    }
  }
}
</style>