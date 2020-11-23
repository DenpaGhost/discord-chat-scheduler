<template>
  <div>
    <div class="role-setting-header">
      <h4>サーバー名</h4>
      <h3 class="text-high">
        管理ロール設定
      </h3>
    </div>

    <switch-control>
      スイッチコントロール
    </switch-control>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import SwitchControl from "~/components/general/SwitchControl.vue";

@Component({
  components: {SwitchControl}
})
export default class Settings extends Vue {

}
</script>

<style lang="scss">
.role-setting-header {
  h4 {
    margin-bottom: 0;
  }

  h3 {
    margin-top: 0;
  }
}
</style>