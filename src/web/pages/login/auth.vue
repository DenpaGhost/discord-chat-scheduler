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
    const challenge = await AuthCode.makeCodeChallenge(verifier);

    localStorage.setItem('state', state);
    localStorage.setItem('verifier', verifier);

    location.replace(`${process.env.OAUTH_SERVER_URI}?${Utility.transformQueryString({
      client_id: `${process.env.OAUTH_CLIENT_ID}`,
      state: state,
      code_challenge: challenge
    })}`);
  }
}
</script>

<style scoped>

</style>