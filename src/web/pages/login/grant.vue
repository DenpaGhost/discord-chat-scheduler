<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential} from "~/utils/store-accessor";
import AuthAction from "~/resources/actions/AuthAction";

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

    const token = await AuthAction.grantToken(verifier, code);

    localStorage.setItem('expires_in_time', token.expiresIn.getTime().toString());
    localStorage.setItem('refresh_token', token.refreshToken);
    credential.setToken(token);

    await this.$router.replace('/dashboard');
  }
}
</script>

<style scoped>

</style>