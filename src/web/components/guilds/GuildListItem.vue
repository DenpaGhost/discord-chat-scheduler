<template>
  <nuxt-link class="guild-list-item"
             :class="{'opening': isOpening}"
             :to="`/servers/${serverId}`">
    <div class="guild-icon">
      <img v-if="icon" :src="icon" alt="サーバーアイコン" class="guild-icon-img"/>
      <div v-else>
        <span>
          ゲーミングおかもと
        </span>
      </div>
    </div>
  </nuxt-link>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class GuildListItem extends Vue {
  @Prop({type: Boolean, required: true, default: false})
  isOpening!: boolean;

  @Prop({type: String, required: true})
  serverId!: string;

  @Prop({type: String})
  icon!: string;
}
</script>

<style lang="scss">
$icon-height: 3.5em;
$icon-width: 3.5em;

.guild-list-item {
  display: flex;
  width: 100%;
  height: $icon-height;
  margin: 0.25em 0;
  align-items: center;
  justify-content: center;
  text-decoration: none;

  position: relative;

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
  overflow: hidden;

  & > div {
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;
    word-break: keep-all;
    white-space: nowrap;
  }
}

.guild-icon-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.light {
  .guild-icon {
    background-color: #ffffff;
  }

  .guild-list-item {
    &:link, &:visited {
      .guild-icon {
        transition: border-radius 200ms ease-in-out, color 200ms, background-color 200ms;
        color: #4F5760;
        border-radius: 2em;
      }
    }

    &:hover {
      .guild-icon {
        background-color: #7289DA;
        color: #ffffff;
        border-radius: 1em;
      }
    }
  }
}

</style>