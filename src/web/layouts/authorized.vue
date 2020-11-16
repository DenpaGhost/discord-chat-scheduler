<template>
  <div v-if="!isRefreshing">
    <nuxt/>
  </div>
  <div v-else>
    トークン更新中...
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential} from "~/store";
import TokenUtility from "~/resources/utilities/TokenUtility";

@Component
export default class Authorized extends Vue {
  isRefreshing: boolean = true;

  async mounted() {
    if (!credential.isLoggedIn) {
      this.isRefreshing = true;
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

    this.isRefreshing = false;
  }
}
</script>

<style scoped>

</style>