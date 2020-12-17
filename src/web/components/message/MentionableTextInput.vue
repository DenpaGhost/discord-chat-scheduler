<template>
  <div class="mti-container">
    <div class="mt-input" contenteditable="true">
      aaaaa
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
}
</script>

<style lang="scss">
.mti-container {
  padding: 0.25em;
}

.mt-input {
  min-height: 1em;
}

.light {
  .mti-container {
    border-radius: 0.25em;
    border: 2px solid #E3E5E9;
  }
}
</style>