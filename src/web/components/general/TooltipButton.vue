<template>
  <div class="tooltip-button-container">
    <div class="tooltip-button"
         @mouseenter="onHover()"
         :ref="`${unique}button`">
      <slot name="label"/>
    </div>
    <div class="button-tooltip-hider"
         :class="this.tooltipDirectionClass">
      <div class="button-tooltip-container"
           :style="tooltipStyle"
           :ref="`${unique}tooltip`">
        <div class="button-tooltip">
          <slot name="tooltip"/>
        </div>
        <div class="button-tooltip-arrow"/>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";

@Component
export default class TooltipButton extends Vue {
  @Prop({type: Boolean, default: true})
  top!: boolean;

  @Prop({type: Boolean, default: false})
  right!: boolean;

  unique!: string;
  tooltipStyle = {top: '0', left: '0'}

  created() {
    this.unique = this.getUniqueStr();
  }

  onHover() {
    if (this.right) {
      this.setTooltipRight();
    } else if (this.top) {
      this.setTooltipTop();
    }
  }

  setTooltipTop() {
    const buttonRect = this.button.getBoundingClientRect();
    const tooltipRect = this.tooltip.getBoundingClientRect();
    this.tooltipStyle.top = `${-1 * tooltipRect.height}px`;
    this.tooltipStyle.left = `${(buttonRect.width - tooltipRect.width) / 2}px`;
  }

  setTooltipRight() {
    const buttonRect = this.button.getBoundingClientRect();
    const tooltipRect = this.tooltip.getBoundingClientRect();
    this.tooltipStyle.top = `${(buttonRect.height - tooltipRect.height) / 2}px`;
    this.tooltipStyle.left = `${buttonRect.width}px`;
  }

  onClick() {
    this.$emit('click');
  }

  get button() {
    return this.$refs[`${this.unique}button`] as Element;
  }

  get tooltip() {
    return this.$refs[`${this.unique}tooltip`] as Element;
  }

  getUniqueStr(): string {
    let strong = 100000;
    return (
        new Date().getTime().toString(16) +
        Math.floor(strong * Math.random()).toString(16)
    );
  }

  get tooltipDirectionClass() {
    return {
      'top': !this.right ? this.top : false,
      'right': this.right
    }
  }
}
</script>

<style lang="scss">
.tooltip-button-container {
  position: relative;

  .top {
    .button-tooltip-container {
      flex-direction: column;
    }

    .button-tooltip-arrow {
      width: 0;
      height: 0;
      border-top: solid 0.5em #060606;
      border-right: solid 0.5em transparent;
      border-bottom: solid 0.5em transparent;
      border-left: solid 0.5em transparent;
    }
  }

  .right {
    .button-tooltip-container {
      flex-direction: row-reverse;
    }

    .button-tooltip-arrow {
      width: 0;
      height: 0;
      border-top: solid 0.5em transparent;
      border-right: solid 0.5em #060606;
      border-bottom: solid 0.5em transparent;
      border-left: solid 0.5em transparent;
    }
  }

  .button-tooltip-container {
    position: absolute;
    color: #ffffff;
    display: flex;
    align-items: center;

    filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.6));

    .button-tooltip {
      padding: 0.5em;
      background-color: #060606;
      border-radius: 0.25em;
      word-break: keep-all;
    }
  }
}

.button-tooltip-hider {
  transition: opacity 200ms linear, visibility 0ms 200ms !important;
  visibility: hidden;
  opacity: 0;
}

.tooltip-button:hover + .button-tooltip-hider {
  transition: display 0ms, opacity 200ms linear !important;
  visibility: visible;
  opacity: 1;
}
</style>