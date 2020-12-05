<template>
  <div class="dropdown-container">
    <div class="dropdown-selecting-container"
         @click="onClickDropdownList">
      <div class="dropdown-selecting">
        ドロップダウンリスト
      </div>

      <div class="dropdown-chevron-down">
        <fa :icon="icon.down"/>
      </div>
    </div>

    <div class="dropdown-items-container"
         :class="{'visible': menuVisible}">
      <div class="dropdown-item" @click="onClickListItem">
        ドロップダウンリスト
      </div>
      <div class="dropdown-item" @click="onClickListItem">
        テスト
      </div>
      <div class="dropdown-item" @click="onClickListItem">
        テスト
      </div>
      <div class="dropdown-item" @click="onClickListItem">
        テスト
      </div>
    </div>

    <div class="dropdown-closer"
         :class="{'visible': menuVisible}"
         @click="onClickCloser">

    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {faChevronDown} from "@fortawesome/free-solid-svg-icons";

@Component
export default class DropdownList extends Vue {

  menuVisible: boolean = false;

  onClickDropdownList() {
    this.menuVisible = true;
  }

  onClickCloser() {
    this.menuVisible = false;
  }

  onClickListItem() {
    this.menuVisible = false;
  }

  get icon() {
    return {
      down: faChevronDown
    }
  }
}
</script>

<style lang="scss">
.dropdown-container {
  margin: 0.5em 0;
  position: relative;

  .dropdown-selecting-container {
    border-radius: 0.5em;
    padding: 0.5em;
    display: flex;

    .dropdown-selecting {
      flex-grow: 1;
    }

    .dropdown-chevron-down {
      flex-grow: 0;
      padding: 0 0.5em;
    }
  }
}

.dropdown-items-container {
  border-radius: 0.5em;
  position: absolute;
  z-index: 2;
  top: 0;
  left: 0;
  right: 0;
  max-height: 50vh;
  overflow-y: auto;

  visibility: hidden;

  &.visible {
    visibility: visible !important;
  }

  .dropdown-item {
    padding: 0.5em;
  }
}

.dropdown-closer {
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  visibility: hidden;

  &.visible {
    visibility: visible !important;
  }
}

.light {
  .dropdown-selecting-container, .dropdown-items-container {
    border: 2px solid #E3E5E9;
    background-color: #ffffff;
  }

  .dropdown-selecting-container, .dropdown-item {
    transition: background-color 200ms;

    &:hover {
      background-color: rgba(#E3E5E9, 0.6);
    }

    &:active {
      background-color: rgba(#E3E5E9, 1);
    }
  }
}
</style>