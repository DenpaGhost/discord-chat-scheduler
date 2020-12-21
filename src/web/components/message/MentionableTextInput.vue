<template>
  <div class="mti-container">
    <div class="mt-input"
         contenteditable="true"
         ref="input"
         v-html="initial"
         @input="onUpdate"/>
    <div v-if="showPlaceholder" class="mti-placeholder">{{ placeholder }}</div>

    <div class="mti-mention-completer">
      <div v-for="it of mentionableMembers"
           class="mti-mention-completer-item">
        @ {{ it.name }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class MentionableTextInput extends Vue {
  @Prop({type: String, default: ''})
  placeholder!: string;

  initial: string = '';
  input: string = 'aaaa<span contenteditable="false" data-tag="aaaa">aaaa</span>';
  lastCursorPosition: number = 0;

  mentionableMembers: Array<{ name: string; }> = [
    {name: 'Denpa_Ghost'},
    {name: 'mi2_ku39'},
    {name: 'rni2_moka'}
  ];

  mentionableRoles: Array<{ name: string; }> = [
    {name: 'VALORANT Player'},
    {name: 'Genshin Player'},
    {name: 'Apex Legends Player'}
  ];

  linkableChannel: Array<{ name: string; }> = [
    {name: 'テキストチャンネル'},
    {name: 'information'}
  ];

  mounted() {
    this.initialize();
  }

  onUpdate(e: InputEvent) {
    // editable content divに入力された内容を変数へバインド
    if (e && e.target instanceof Element) {
      this.input = e.target.innerHTML;
    }

    console.log(this.textarea().childNodes);
    console.log(window.getSelection()?.getRangeAt(0));
  }

  initialize() {
    // 初期値をセット
    this.initial = this.input;
  }

  textarea() {
    return this.$refs['input'] as Element;
  }

  get showPlaceholder() {
    return this.input.length <= 0;
  }

  hasFocus() {
    return document.activeElement == this.textarea();
  }
}
</script>

<style lang="scss">
.mti-container {
  position: relative;

}

.mt-input {
  min-height: 1em;
  outline: none;
  pointer-events: auto;
  padding: 0.5em;

  &:focus {
    border: none;
  }

  z-index: 2;
}

.mti-placeholder {
  pointer-events: none;
  padding: 0.5em;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  min-height: 1em;
  z-index: 1;

  border: 2px rgba(0, 0, 0, 0) solid;
}

.mti-mention-completer {
  position: absolute;
  margin-top: 0.25em;
  left: 0;
  right: 0;

  .mti-mention-completer-item {
    padding: 0.5em;
  }
}

.light {
  .mt-input {
    border-radius: 0.5em;
    border: 2px solid #E3E5E9;
    background-color: #ffffff;
  }

  .mt-input:focus {
    border-color: blue;
  }

  .mti-placeholder {
    color: #eee;
  }

  .mti-mention-completer {
    border-radius: 0.5em;
    border: 2px solid #E3E5E9;
    background-color: #ffffff;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
  }
}
</style>