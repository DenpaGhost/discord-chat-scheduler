import {Module, Mutation, VuexModule} from "vuex-module-decorators";
import Token from "~/resources/Models/Token";

export interface iCredential {
    token?: Token
}

@Module({
    stateFactory: true,
    namespaced: true,
    name: 'credential'
})
export default class Credential extends VuexModule implements iCredential {
    token?: Token

    @Mutation
    setToken(token: Token) {
        this.token = token;
    }

    get isLoggedIn(): boolean {
        return this.token != undefined;
    }
}