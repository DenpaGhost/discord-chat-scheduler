<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import AuthCode from "../../resources/auth/AuthCode";
import Utility from "~/resources/utilities/Utility";

@Component
export default class auth extends Vue {
  async mounted() {
    const state = AuthCode.makeState();
    const verifier = AuthCode.makeCodeVerifier();
    const challenge = await AuthCode.makeCodeChallenge();

    sessionStorage.setItem('state', state);
    sessionStorage.setItem('verifier', verifier);

    location.replace(`${process.env.OAUTH_SERVER_URI}?${Utility.transformQueryString({
      client_id: `${process.env.OAUTH_CLIENT_ID}`,
      redirect_uri: `${process.env.OAUTH_CALLBACK_URI}`,
      state: state,
      code_challenge: challenge,
      code_challenge_method: 'S256'
    })}`);
  }
}
</script>

<style scoped>

</style>