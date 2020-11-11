import {Action, Module, Mutation, VuexModule} from "vuex-module-decorators";
import {$axios} from "~/utils/axios";
import TokenUtility from "~/resources/utilities/TokenUtility";
import Utility from "~/resources/utilities/Utility";

export interface iCredential {
    accessToken: string | null;
    refreshToken: string | null;
    expiresIn: Date | null;
}

@Module({
    stateFactory: true,
    namespaced: true,
    name: 'credential'
})
export default class Credential extends VuexModule implements iCredential {
    accessToken: string | null = null;
    refreshToken: string | null = null;
    expiresIn: Date | null = null;

    public get isLoggedIn() {
        return this.accessToken != null;
    }

    public get isExpire() {
        return TokenUtility.isExpire(this.expiresIn);
    }

    @Mutation
    setAccessToken(accessToken: string) {
        this.accessToken = accessToken;
    }

    @Mutation
    setRefreshToken(refreshToken: string) {
        this.refreshToken = refreshToken;
    }

    @Mutation
    setExpiresIn(expiresIn: Date) {
        this.expiresIn = expiresIn;
    }

    @Mutation
    clear() {
        this.accessToken = null;
        this.refreshToken = null;
        this.expiresIn = null;
    }

    @Action({rawError: true})
    async refresh(refreshToken: string) {
        Utility.validateClientSide();

        if (this.isExpire) {
            this.clear();
            throw new Error('トークンが無効です');
        }

        const token = await $axios.$post(`${process.env.OAUTH_GRANT_URI}`, {
            grant_type: 'refresh_token',
            client_id: process.env.OAUTH_CLIENT_ID,
            refresh_token: refreshToken
        });

        this.setAccessToken(token.access_token)
        this.setRefreshToken(token.refresh_token);
        this.setExpiresIn(TokenUtility.convertExpiresInDate(token.expires_in));
    }

    @Action({rawError: true})
    async logout() {
        await $axios.$delete(`${process.env.OAUTH_GRANT_URI}/${this.accessToken}`);
        this.clear();
    }
}