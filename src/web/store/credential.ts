import {ActionTree, GetterTree} from 'vuex';
import {RootState} from '~/store';

export const state = () => ({});

export type CredentialState = ReturnType<typeof state>;

export const getters: GetterTree<CredentialState, RootState> = {};

export const actions: ActionTree<CredentialState, RootState> = {};