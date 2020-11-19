<template>
  <a class="guild-list-item" href="#" :class="{'opening': isOpening}">
    <img src="/samples/images/icon.jpg" alt="サーバーアイコン" class="guild-icon"/>
  </a>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class GuildListItem extends Vue {
  @Prop({type: Boolean, required: true, default: false})
  isOpening!: boolean;
}
</script>

<style lang="scss">
$icon-height: 3.5em;
$icon-width: 3.5em;

.guild-list-item {
  display: block;
  width: 100%;
  height: $icon-height;
  padding: 0.25em 0;
  text-align: center;
  position: relative;

  &:link > .guild-icon {
    transition: border-radius 200ms ease-in-out;
    border-radius: 2em;
  }

  &:after {
    position: absolute;
    display: block;
    content: '';
    left: 0;
    top: $icon-height/2 + 0.25em;
    bottom: $icon-height/2 + 0.25em;
    width: 5px;
    border-radius: 0 2.5px 2.5px 0;
    background-color: #060606;

    transition: top 200ms ease-in-out, bottom 200ms ease-in-out;
  }

  &:hover:after {
    top: 1em;
    bottom: 1em;
  }

  &:hover > .guild-icon {
    border-radius: 1em;
  }
}

.opening {
  &:after {
    top: 0.25em !important;
    bottom: 0.25em !important;
  }

  & > .guild-icon {
    border-radius: 1em !important;
  }
}

.guild-icon {
  width: $icon-width;
  height: $icon-height;
}

</style>