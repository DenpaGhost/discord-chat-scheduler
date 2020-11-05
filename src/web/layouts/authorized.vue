<template>
  <nuxt/>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import TokenRepository from "~/resources/Repositories/auth/TokenRepository";

@Component
export default class Authorized extends Vue {
  async mounted() {
    const expiresInTime = localStorage.getItem('expires_in_time');
    if (TokenRepository.isTokenExpire(expiresInTime)) {
      await this.$router.replace('/');
      return;
    }

    const refreshToken = localStorage.getItem('refresh_token') as string;
    const token = await TokenRepository.refreshToken(refreshToken);

    localStorage.setItem('expires_in_time', token.expiresIn.getTime().toString());
    localStorage.setItem('refresh_token', token.refreshToken);

    console.log(token);
  }
}
</script>

<style scoped>

</style>