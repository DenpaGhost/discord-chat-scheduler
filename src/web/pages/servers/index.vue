<template>
  <div>
    <h1>サーバー一覧</h1>
    <p>
      <button type="button" @click="logout">
        ログアウト
      </button>
    </p>
    <ul>
      <li v-for="server in servers">
        {{ server.name }}
      </li>
    </ul>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential, guardApi} from "~/store";

@Component({
  layout: 'authorized'
})
export default class Index extends Vue {
  servers: Array<any> = [];

  async mounted() {
    await this.fetchServers();
  }

  async logout() {
    await credential.logout();

    localStorage.removeItem('refresh_token');
    localStorage.removeItem('expires_in_time');
  }

  async fetchServers() {
    const {data: servers} = await guardApi.client.get('/servers');
    this.servers = servers;

    console.log((await guardApi.client.get(`/servers/${servers[0].id}`)).data);
  }
}
</script>

<style scoped>

</style>