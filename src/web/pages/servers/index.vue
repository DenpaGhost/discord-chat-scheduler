!
<template>
  <div>
    <h1>サーバー一覧</h1>
    <p>
      <button type="button" @click="logout">
        ログアウト
      </button>
    </p>
    <form @submit.prevent="getApi">
      <label for="path">path</label>
      <input id="path" type="text" v-model="path"/>
      <button type="submit">APIをたたく</button>
    </form>
    <ul>
      <li v-for="server in servers">
        {{ server.name }}: {{ server.id }}
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
  path: string = '';

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

    // console.log((await guardApi.client.get(`/servers/${servers[0].id}`)).data);
  }

  async getApi() {
    if (this.path.length <= 0) return;

    const {data} = await guardApi.client.get(this.path);
    console.log(data);
  }
}
</script>

<style scoped>

</style>