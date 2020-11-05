<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import Axios from "axios";
import Token from "~/resources/Models/Token";

@Component
export default class grant extends Vue {
  async mounted() {
    const state = localStorage.getItem('state');
    const verifier = localStorage.getItem('verifier');
    const code = this.$route.query.code as string;

    localStorage.removeItem('state');
    localStorage.removeItem('verifier');

    if (state == null
        || verifier == null
        || state != this.$route.query.state) {
      console.error('認可エラー');
      return;
    }

    const token = await Token.store(verifier, code);

    console.log(token);

    const {data: user} = await Axios.get(`http://localhost:8080/api/user/@me`, {
      headers: {
        Authorization: token.accessToken
      }
    });

    console.log(user);
    console.log(token.expiresIn);

    localStorage.setItem('expires_in_time', token.expiresIn.getTime().toString());
    localStorage.setItem('refresh_token', token.refreshToken);

    await this.$router.replace('/dashboard');
  }
}
</script>

<style scoped>

</style>