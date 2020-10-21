<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import Axios from "axios";

@Component
export default class grant extends Vue {
  async mounted() {
    const state = sessionStorage.getItem('state');
    const verifier = sessionStorage.getItem('verifier');
    const code = this.$route.query.code;

    sessionStorage.removeItem('state');
    sessionStorage.removeItem('verifier');

    if (state != this.$route.query.state) {
      console.error('認可エラー');
      return;
    }

    const {data} = await Axios.post(`${process.env.OAUTH_GRANT_URI}`, {
      grant_type: 'authorization_code',
      client_id: process.env.OAUTH_CLIENT_ID,
      code_verifier: verifier,
      code: code
    });

    console.log(data);

    // localStorage.setItem('expires_in', data.expires_in);
    // localStorage.setItem('refresh_token', data.refresh_token);
  }
}
</script>

<style scoped>

</style>