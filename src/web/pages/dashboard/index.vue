<template>
  <div>
    <h1>ダッシュボード</h1>
    <p>
      <button type="button" @click="logout">
        ログアウト
      </button>
    </p>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential} from "~/store";

@Component({
  layout: 'authorized'
})
export default class Index extends Vue {
  async logout() {
    await credential.logout();

    localStorage.removeItem('refresh_token');
    localStorage.removeItem('expires_in_time');
  }
}
</script>

<style scoped>

</style>