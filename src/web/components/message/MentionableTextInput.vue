<template>
  <div class="mti-container">
    <div class="mt-input" contenteditable="true" ref="input">
      aaaa<span contenteditable="false" data-tag="aaaa">aaaa</span>
    </div>
    <div class="mti-placeholder">
      {{ placeholder }}
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class MentionableTextInput extends Vue {
  @Prop({type: String, default: 'hello world!'})
  placeholder!: string;

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
    console.log(this.innerText);
  }

  get innerText() {
    return (this.$refs['input'] as Element).innerHTML;
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
}
</style>