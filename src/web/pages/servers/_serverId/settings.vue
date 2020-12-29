<template>
  <div class="role-setting-container role-settings">
    <div class="role-setting-closer">
      <nuxt-link class="role-setting-closer-container"
                 replace
                 :to="`/servers/${serverId}`">
        <div class="role-setting-closer-icon">
          <fa :icon="icon.batsu"/>
        </div>
      </nuxt-link>
    </div>

    <div class="role-setting-header">
      <h4>サーバー名</h4>
      <h3 class="text-high">
        管理ロール設定
      </h3>
    </div>

    <dropdown-list/>

    <switch-control v-model="roleSettings.value" class="mb-3">
      スイッチコントロール
    </switch-control>

    <!--    <mentionable-text-input/>-->

    <mentionable-text-input_v2/>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import SwitchControl from "~/components/general/SwitchControl.vue";
import {faTimes} from "@fortawesome/free-solid-svg-icons";
import DropdownList from "~/components/general/DropdownList.vue";
import MentionableTextInput from "~/components/message/MentionableTextInput.vue";
import MentionableTextInput_v2 from "~/components/message/MentionableTextInput_v2.vue";

@Component({
  components: {MentionableTextInput_v2, MentionableTextInput, DropdownList, SwitchControl}
})
export default class Settings extends Vue {
  roleSettings = {
    value: true
  }

  get serverId() {
    return this.$route.params['serverId'];
  }

  get icon() {
    return {
      batsu: faTimes
    }
  }
}
</script>

<style lang="scss">
.role-setting-container {
  margin-right: 5em;
}

.role-setting-header {
  h4 {
    margin-bottom: 0;
  }

  h3 {
    margin-top: 0;
  }
}

.role-setting-closer {
  position: fixed;
  top: 2em;
  right: 2em;
  z-index: 2;
  text-align: center;
  color: #E3E5E9;

  animation: closer-show 200ms 200ms backwards;

  .role-setting-closer-container {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 1.25rem;

    display: flex;
    align-items: center;
    justify-content: center;
  }
}

@keyframes closer-show {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

.light {
  .role-setting-closer-container {
    border: 2px solid #dcddde;
  }

  .role-setting-closer-container:link, .role-setting-closer-container:visited {
    color: #4F5760;
    transition: background-color 200ms, transform 100ms ease-in-out;
  }

  .role-setting-closer-container:hover {
    background-color: rgba(#E3E5E9, 0.6);
  }

  .role-setting-closer-container:active {
    transform: translateY(2px);
  }
}
</style>