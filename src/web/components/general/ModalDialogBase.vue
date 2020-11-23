<template>
  <div class="modal-dialog-smoke" :class="{open: isOpen}" @click="close()">
    <div class="modal-dialog" @click.stop>
      <div class="modal-dialog-closer">
        <button type="button" class="button-link" @click="close()">
          <fa :icon="icon.batsu"/>
        </button>
      </div>
      <slot/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "nuxt-property-decorator";
import {faTimes} from "@fortawesome/free-solid-svg-icons";

@Component
export default class ModalDialogBase extends Vue {
  @Prop({type: Boolean, default: false})
  isOpen!: boolean;

  close() {
    this.$emit('close');
  }

  get icon() {
    return {
      batsu: faTimes
    }
  }
}
</script>

<style lang="scss">
.open {
  transition: visibility 0ms 0ms, background-color 200ms !important;
  visibility: visible !important;
  background-color: rgba(0, 0, 0, 0.6) !important;

  .modal-dialog {
    transform: scale(1) !important;
    opacity: 1 !important;
  }
}

.modal-dialog-smoke {
  transition: background-color 200ms, visibility 0ms 200ms;
  visibility: hidden;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 3;
  background-color: rgba(0, 0, 0, 0);
}

.modal-dialog {
  max-width: 1200px;
  width: 100%;
  margin: 2em;
  filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.6));
  z-index: 4;
  padding: 1em;
  border-radius: 0.25em;

  transition: transform 200ms, opacity 200ms;
  transform: scale(0.8);
  opacity: 0;

  .modal-dialog-closer {
    width: 100%;
    text-align: right;
  }
}

.light {
  .modal-dialog {
    background-color: #ffffff;
  }
}
</style>