<template>

</template>

<script lang="ts">
import {Component, Vue} from "nuxt-property-decorator";
import AuthAction from "~/resources/actions/AuthAction";
import Utility from "~/resources/utilities/Utility";

@Component
export default class auth extends Vue {
  async mounted() {
    const {state, verifier, challenge} = await AuthAction.makeCredentials();

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