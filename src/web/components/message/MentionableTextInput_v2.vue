<template>
  <div class="mti-container">
    <div class="mt-input"
         contenteditable="true"
         ref="input"
         v-html="initial"
         @input="onUpdate"
         @keydown.meta.90.prevent
         @keydown.ctrl.90.prevent
         @keydown.meta.shift.90.prevent
         @keydown.ctrl.shift.90.prevent
         @keydown.ctrl.89.prevent
         @keydown.meta.89.prevent/>
    <div v-if="showPlaceholder" class="mti-placeholder">{{ placeholder }}</div>

    <div class="mti-mention-completer">
      <div v-for="it of mentionableMembers"
           @click="onMentionerClick(it.html)"
           class="mti-mention-completer-item">
        @ {{ it.name }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class MentionableTextInput_v2 extends Vue {
  @Prop({type: String, default: ''})
  placeholder!: string;

  initial: string = '';
  input: string = '';
  lastRange?: Range

  isInserting: boolean = false;

  mentionableMembers: Array<{ name: string; html: string; }> = [
    {
      name: 'Denpa_Ghost',
      html: "<span contenteditable=\"false\" style=\"color: blue\">@Denpa_Ghost</span>"
    },
    {
      name: 'mi2_ku39',
      html: "<span contenteditable=\"false\">@Denpa_Ghost</span>"
    },
    {
      name: 'rni2_moka',
      html: "<span contenteditable=\"false\">@Denpa_Ghost</span>"
    }
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
    // メンションタグ挿入中ならば処理を行わない
    if (this.isInserting) return;

    // editable content divに入力された内容を変数へバインド
    if (e && e.target instanceof Element) {
      this.input = e.target.innerHTML;
    }

    this.lastRange = document.getSelection()?.getRangeAt(0);

    if (!(this.lastRange?.startContainer &&
        this.lastRange?.startOffset &&
        this.lastRange.startContainer.nodeValue))
      return;

    const beforeAt = this.lastRange.startContainer.nodeValue.substr(
        this.lastRange.startOffset - 2, 1);

    if (e.data == '@' && (beforeAt == ' ' || this.lastRange.startOffset == 1)) {
      console.log('ヒントを表示');
    }
  }

  onMentionerClick(valueHTML: string) {
    // キャレットが当たっていたかバリデーション
    if (!this.lastRange?.startContainer || !this.lastRange.startContainer.nodeValue)
      return;

    this.isInserting = true;

    // 挿入するオブジェクトの生成
    const before =
        this.lastRange.startContainer.nodeValue.substr(
            0,
            this.lastRange.startOffset - 1);

    const beforeDOM = ((): HTMLSpanElement | undefined => {
      if (before.length > 0) {
        const elem = document.createElement('span') as HTMLSpanElement;
        elem.innerText = before;
        return elem;
      } else {
        return undefined;
      }
    })();

    const afterDOM = document.createElement('span') as HTMLSpanElement;
    afterDOM.innerHTML = '&nbsp;' + this.lastRange.startContainer.nodeValue.substr(
        this.lastRange.startOffset,
        this.lastRange.startContainer.nodeValue.length
    );

    // 置き換え基準のオブジェクト化
    const currentNode: Node = this.lastRange.startContainer;
    const currentElement = ((): Element => {
      if (currentNode instanceof Element) {
        return currentNode;
      } else if (this.lastRange != undefined) {
        //DOMでnodeを囲う
        const elem = document.createElement('span') as HTMLSpanElement;
        this.lastRange.setStart(this.lastRange.startContainer, 0);
        this.lastRange.setEnd(this.lastRange.startContainer, this.lastRange.startContainer.nodeValue.length);
        this.lastRange.surroundContents(elem);
        return elem;
      } else {
        throw new Error('キャレット関係エラー');
      }
    })();

    // タグ挿入
    if (beforeDOM != undefined) {
      currentElement.insertAdjacentElement('beforebegin', beforeDOM);
    }

    currentElement.insertAdjacentHTML(
        'beforebegin',
        `${valueHTML}`);

    currentElement.insertAdjacentElement('beforebegin', afterDOM);

    console.log(`${beforeDOM?.outerHTML} ${valueHTML} ${afterDOM.outerHTML}`);

    // 置き換え対象の削除
    currentElement.remove();

    // キャレットの復元
    this.textarea().focus();
    const range = document.createRange();
    if (afterDOM.firstChild) {
      range.setStart(
          afterDOM.firstChild,
          1);
    } else {
      range.setStart(afterDOM, 0);
    }
    range.collapse(true);
    window.getSelection()?.removeAllRanges();
    window.getSelection()?.addRange(range);

    this.isInserting = false;
  }

  initialize() {
    // 初期値をセット
    this.initial = this.input;
  }

  textarea() {
    return this.$refs['input'] as HTMLElement;
  }

  childNodes() {
    return this.textarea().childNodes;
  }

  get showPlaceholder() {
    return this.input.length <= 0;
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