import AuthCode from "~/resources/auth/AuthCode";
import Token from "~/resources/Models/Token";
import TokenRepository from "~/resources/Repositories/auth/TokenRepository";

const validateClientSide = () => {
    if (!process.browser) {
        throw new Error('サーバーサイドでの実行です');
    }
}

export default {
    async makeCredentials() {
        validateClientSide();

        const state = AuthCode.makeState();
        const verifier = AuthCode.makeCodeVerifier();
        const challenge = await AuthCode.makeCodeChallenge(verifier);

        return {
            state,
            verifier,
            challenge
        }
    },
    grantToken(verifier: string, code: string): Promise<Token> {
        return TokenRepository.storeToken(verifier, code);
    },
    isPossibleRefreshingToken(expiresInTime: string | null, refreshToken: string | null) {
        return !TokenRepository.isTokenExpire(expiresInTime) && refreshToken != null;
    },
    refreshToken(refreshToken: string): Promise<Token> {
        return TokenRepository.refreshToken(refreshToken);
    }
}