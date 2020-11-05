import TokenUtility from "~/resources/utilities/TokenUtility";
import Axios from "axios";

export default class Token {
    accessToken: string
    refreshToken: string
    expiresIn: Date

    constructor(accessToken: string, refreshToken: string, expiresIn: Date) {
        this.accessToken = accessToken;
        this.refreshToken = refreshToken;
        this.expiresIn = expiresIn;
    }

    /**
     * コードとトークンの交換
     * @param codeVerifier
     * @param code
     */
    static async store(codeVerifier: string, code: string): Promise<Token> {
        const {data} = await Axios.post(`${process.env.OAUTH_GRANT_URI}`, {
            grant_type: 'authorization_code',
            client_id: process.env.OAUTH_CLIENT_ID,
            code_verifier: codeVerifier,
            code: code
        });
        return new Token(data.access_token, data.refresh_token, TokenUtility.convertExpiresInDate(data.expires_in));
    }

    static async refresh(refreshToken: string): Promise<Token> {
        const {data} = await Axios.post(`${process.env.OAUTH_GRANT_URI}`, {
            grant_type: 'refresh_token',
            client_id: process.env.OAUTH_CLIENT_ID,
            refresh_token: refreshToken
        });
        return new Token(data.access_token, data.refresh_token, TokenUtility.convertExpiresInDate(data.expires_in));
    }

    async delete(): Promise<void> {
        await Axios.delete(`${process.env.OAUTH_GRANT_URI}/${this.accessToken}`);
    }
}