import {Store} from 'vuex'
import Credential from "~/store/credential";
import {getModule} from "vuex-module-decorators";
import GuardApi from "~/store/guardApi";

let credential: Credential
let guardApi: GuardApi

function initialiseStores(store: Store<any>): void {
    credential = getModule(Credential, store);
    guardApi = getModule(GuardApi, store);
}

export {initialiseStores, credential, guardApi};
