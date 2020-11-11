import {Module, VuexModule} from "vuex-module-decorators";
import {$axios} from "~/utils/axios";
import {credential} from "~/store";

export interface iGuardApi {

}

@Module({
    stateFactory: true,
    namespaced: true,
    name: 'guardApi'
})
export default class GuardApi extends VuexModule implements iGuardApi {
    public get client() {
        return $axios.create({
            baseURL: process.env.API_ENDPOINT as string,
            headers: {Authorization: credential.accessToken}
        })
    }
}