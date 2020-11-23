<template>
  <label class="switch-control-label">
    <span class="switch-control-flex">
      <span class="switch-control-label-text">
        <slot/>
      </span>
      <span class="switch-control">
        <input type="checkbox" class="switch-control-checkbox">
        <span class="switch-control-container">
          <span class="switch-control-handle-container">
            <span class="switch-control-handle"></span>
          </span>
        </span>
      </span>
    </span>
  </label>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";

@Component
export default class SwitchControl extends Vue {

}
</script>

<style lang="scss">
.switch-control-checkbox {
  display: none;
}

.switch-control-checkbox + .switch-control-container {
  background-color: #E3E5E9;

  .switch-control-handle {
    transform: translateX(-1rem);
  }
}

.switch-control-checkbox:checked + .switch-control-container {
  background-color: #4CAF50;

  .switch-control-handle {
    transform: translateX(1rem);
  }
}

.switch-control-label {
  display: block;

  span {
    display: block;
  }
}

.switch-control-container {
  width: 4rem;
  height: 2rem;
  border-radius: 1rem;
  position: relative;
  overflow: hidden;

  transition: background-color 200ms;

  .switch-control-handle-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .switch-control-handle {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 0.75rem;
    background-color: #ffffff;
    transition: transform 200ms ease-in-out;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}

.switch-control-flex {
  display: flex !important;
  align-items: center;
  flex-direction: row;

  .switch-control-label-text {
    flex-grow: 1;
  }

  .switch-control {
    flex-grow: 0;
  }
}
</style>