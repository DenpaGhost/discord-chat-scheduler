<template>
  <modal-dialog-base :is-open="isOpen" @close="close">
    <div>
      <div class="task-edit-modal-header">
        <h3 class="text-high">
          メッセージの予約を追加
        </h3>
        <h4>
          サーバー名
        </h4>
      </div>
      <div>
        <div>
          <label>
            <b>メッセージチャンネル</b>

            <select>
              <option value="0">
                <fa :icon="icon.hashtag"/>
                チャンネル名 カテゴリ
              </option>
            </select>
          </label>
        </div>

        <div>
          <label>
            メッセージ本文
            <textarea>

          </textarea>
          </label>
        </div>

        <div>
          <label>
            日時
          </label>
        </div>

        <div>
          <label>
            繰り返し

            <select>
              <option value="0">
                <fa :icon="icon.hashtag"/>
                チャンネル名 カテゴリ
              </option>
            </select>
          </label>
        </div>

      </div>
    </div>
  </modal-dialog-base>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";
import ModalDialogBase from "~/components/general/ModalDialogBase.vue";
import {faHashtag} from "@fortawesome/free-solid-svg-icons";

@Component({
  components: {ModalDialogBase}
})
export default class TaskEditModalDialog extends Vue {
  @Prop({type: Boolean, default: false})
  isOpen!: boolean;

  close() {
    this.$emit('close');
  }

  get icon() {
    return {
      hashtag: faHashtag
    }
  }
}
</script>

<style lang="scss">
.task-edit-modal-header {
  text-align: center;
  margin-bottom: 1em;

  h3, h4 {
    margin: 0;
  }
}
</style>