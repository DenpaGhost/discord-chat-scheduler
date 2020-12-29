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
export default class MentionableTextInput extends Vue {
  @Prop({type: String, default: ''})
  placeholder!: string;

  initial: string = '';
  input: string = '';
  lastRange?: Range

  kapsel_nodeId: number = 1;

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
    // editable content divに入力された内容を変数へバインド
    if (e && e.target instanceof Element) {
      this.input = e.target.innerHTML;
    }

    this.lastRange = document.getSelection()?.getRangeAt(0);

    console.log(this.lastRange?.startContainer.parentNode);
    console.log(this.textarea().childNodes);

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
    if (!this.lastRange?.startContainer || !this.lastRange?.startContainer.nodeValue)
      return;

    let currentNodeNum: number = 0;
    const childNodes = this.childNodes();

    console.log(childNodes);

    // キャレットの当たっていたノードを特定
    for (let i = 0; i < childNodes.length; i++) {
      const childNode = childNodes[i] as Node;
      const selectionNode = this.lastRange.startContainer.parentNode as Node;

      if (childNode == selectionNode) {
        currentNodeNum = i;
        break;
      }
    }

    // 要素の挿入
    const before = this.lastRange.startContainer.nodeValue.substr(
        0,
        this.lastRange.startOffset - 1
    );
    const beforeHTML = before.length > 0 ? `<span>${before}</span>` : '';

    const after = this.lastRange.startContainer.nodeValue.substr(
        this.lastRange.startOffset,
        this.lastRange.startContainer.nodeValue.length
    );

    this.textarea().removeChild(childNodes[currentNodeNum]);
    if (currentNodeNum != 0) {
      console.log('先頭じゃない');
      let beforeNode = childNodes[currentNodeNum - 1];

      if (!(beforeNode instanceof Element)) {
        const div = document.createElement('div') as HTMLDivElement;
        const span = document.createElement('span') as HTMLSpanElement;
        span.innerText = beforeNode.nodeValue ?? '';
        div.appendChild(span);
        beforeNode.replaceWith(div);
        beforeNode = div;
      }

      (beforeNode as Element).insertAdjacentHTML(
          'afterend',
          `${beforeHTML}${valueHTML}<span>&nbsp;${after}</span>`
      );
    } else {
      console.log('先頭');
      this.textarea().insertAdjacentHTML(
          'afterbegin',
          `${beforeHTML}${valueHTML}<span>&nbsp;${after}</span>`
      );
    }

    // キャレットの復元
    const appendedNodeNum = before.length > 0 ? 2 : 1;
    const selectingNode = this.textarea().childNodes[currentNodeNum + appendedNodeNum].firstChild;
    if (selectingNode == null) return;

    this.textarea().focus();
    const range = document.createRange();
    range.setStart(
        selectingNode,
        1);
    range.collapse(true);
    window.getSelection()?.removeAllRanges();
    window.getSelection()?.addRange(range);
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