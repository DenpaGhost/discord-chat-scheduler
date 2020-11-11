<template>
  <nuxt/>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential, guardApi} from "~/store";
import TokenUtility from "~/resources/utilities/TokenUtility";

@Component
export default class Authorized extends Vue {
  async mounted() {
    if (!credential.isLoggedIn) {
      const expiresInTime = localStorage.getItem('expires_in_time');
      const refreshToken = localStorage.getItem('refresh_token');

      if (expiresInTime == null || refreshToken == null) {
        await this.$router.replace('/login/auth');
        return;
      }

      credential.setRefreshToken(refreshToken);
      credential.setExpiresIn(TokenUtility.convertTimeToDate(parseInt(expiresInTime)));

      try {
        await credential.refresh(refreshToken);

        if (credential.refreshToken != null && credential.expiresIn != null) {
          localStorage.setItem('refresh_token', credential.refreshToken);
          localStorage.setItem('expires_in_time', credential.expiresIn.getTime().toString());
        }
      } catch (e) {
        await this.$router.replace('/login/auth');
      }
    }

    console.log(await guardApi.client.get('/user/@me'));
  }
}
</script>

<style scoped>

</style>