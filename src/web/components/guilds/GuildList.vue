<template>
  <div class="guild-list-container">
    <div class="guild-list-tooltip"
         :class="{'visible': tooltip.visibility}"
         :style="tooltip.style"
         ref="guild-list-tooltip">
      <div>
        {{ tooltip.content }}
      </div>
      <div class="guild-list-tooltip-arrow-container font-weight-bold">
        <div class="guild-list-tooltip-arrow"></div>
      </div>
    </div>

    <div class="guild-list-scroller">
      <guild-list-item v-for="it in array"
                       :key="it"
                       :is-opening="opening === `test${it}`"
                       :ref="`test${it}`"
                       :server-id="`test${it}`"
                       @mouseenter.native="showTooltip(`test${it}`)"
                       @mouseleave.native="hideTooltip"/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import GuildListItem from "~/components/guilds/GuildListItem.vue";

@Component({
  components: {GuildListItem}
})
export default class GuildList extends Vue {
  array: number[] = [...Array(20)].map((v, i) => i);

  tooltip = {
    visibility: false,
    content: 'ゲーミングおかもと',
    style: {
      top: '0',
      left: '5.25em'
    }
  }

  showTooltip(element: string) {
    this.tooltip.visibility = true;
    const tooltip = (this.$refs['guild-list-tooltip'] as Element)
    const component = (this.$refs[element] as Vue[])[0];
    const rect = component.$el.getBoundingClientRect();
    const top = rect.y + rect.height / 2 - tooltip.getBoundingClientRect().height / 2;
    this.tooltip.style.top = `${top}px`;
  }

  hideTooltip() {
    this.tooltip.visibility = false;
  }

  get opening() {
    return this.$route.params?.serverId ?? null
  }
}
</script>

<style lang="scss">
.guild-list-container {
  height: 100%;
  width: 5em;
  position: relative;

  .guild-list-scroller {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 5em;
    overflow-y: scroll;

    &::-webkit-scrollbar {
      display: none;
    }
  }

  .guild-list-tooltip {
    position: absolute;
    opacity: 0;
    display: block;
    visibility: hidden;
    color: #ffffff;
    background-color: #060606;
    padding: 0.5em 1em;
    z-index: 2;
    max-width: 200px;
    word-break: keep-all;
    border-radius: 0.25em;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.6));
    transition: opacity 200ms ease-in-out, visibility 0ms 200ms;

    .guild-list-tooltip-arrow-container {
      position: absolute;
      top: 0;
      bottom: 0;
      left: -1em;
      content: '';
      width: 1em;
      display: flex;
      align-items: center;

      .guild-list-tooltip-arrow {
        width: 0;
        height: 0;
        border-top: solid 0.5em transparent;
        border-right: solid 0.5em #060606;
        border-bottom: solid 0.5em transparent;
        border-left: solid 0.5em transparent;
      }
    }
  }

  .visible {
    transition: opacity 200ms ease-in-out !important;
    visibility: visible !important;
    opacity: 1 !important;
  }
}
</style>