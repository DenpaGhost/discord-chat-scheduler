<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential} from "~/store";
import TokenUtility from "~/resources/utilities/TokenUtility";

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
      throw new Error('認可エラー')
    }

    const {data: token} = await this.storeToken(verifier, code);
    const expiresIn = TokenUtility.convertExpiresInDate(token.expires_in);

    localStorage.setItem('expires_in_time', expiresIn.getTime().toString());
    localStorage.setItem('refresh_token', token.refresh_token);

    credential.setAccessToken(token.access_token);
    credential.setRefreshToken(token.refresh_token);
    credential.setExpiresIn(expiresIn);

    await this.$router.replace('/servers');
  }

  storeToken(verifier: string, code: string) {
    return this.$axios.post(`${process.env.OAUTH_GRANT_URI}`, {
      grant_type: 'authorization_code',
      client_id: process.env.OAUTH_CLIENT_ID,
      code_verifier: verifier,
      code: code
    });
  }
}
</script>

<style scoped>

</style>