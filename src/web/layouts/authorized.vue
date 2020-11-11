<template>
  <nuxt/>
</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import {credential} from "~/utils/store-accessor";
import AuthAction from "~/resources/actions/AuthAction";

@Component
export default class Authorized extends Vue {
  async mounted() {
    if (!credential.isLoggedIn) {
      const expiresInTime = localStorage.getItem('expires_in_time');
      const refreshToken = localStorage.getItem('refresh_token');

      if (!AuthAction.isPossibleRefreshingToken(expiresInTime, refreshToken)) {
        await this.$router.replace('/');
        return;
      }

      const token = await AuthAction.refreshToken(refreshToken);

      localStorage.setItem('expires_in_time', token.expiresIn.getTime().toString());
      localStorage.setItem('refresh_token', token.refreshToken);
    }
  }
}
</script>

<style scoped>

</style>