import {Store} from 'vuex'
import Credential from "~/store/credential";
import {getModule} from "vuex-module-decorators";

let credential: Credential

function initialiseStores(store: Store<any>): void {
    credential = getModule(Credential, store)
}

export {initialiseStores, credential};
