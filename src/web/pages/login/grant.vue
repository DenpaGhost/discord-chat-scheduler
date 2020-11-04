<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import Axios from "axios";
import TokenUtility from "~/resources/utilities/TokenUtility";

@Component
export default class grant extends Vue {
  async mounted() {
    const state = localStorage.getItem('state');
    const verifier = localStorage.getItem('verifier');
    const code = this.$route.query.code;

    localStorage.removeItem('state');
    localStorage.removeItem('verifier');

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

    const {data: user} = await Axios.get(`http://localhost:8080/api/user/@me`, {
      headers: {
        Authorization: data.access_token
      }
    });

    console.log(user);
    console.log(TokenUtility.convertExpiresIn(data.expires_in));

    localStorage.setItem('expires_in', data.expires_in);
    localStorage.setItem('refresh_token', data.refresh_token);
  }
}
</script>

<style scoped>

</style>