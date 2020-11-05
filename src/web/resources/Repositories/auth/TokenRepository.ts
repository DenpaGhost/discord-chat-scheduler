import TokenUtility from "~/resources/utilities/TokenUtility";
import Token from "~/resources/Models/Token";

export default {
    isTokenExpire(expiresInTime: string | null): boolean {
        if (expiresInTime == null) {
            return true;
        }
        return TokenUtility.isExpire(TokenUtility.convertTimeToDate(Number.parseInt(expiresInTime)));
    },
    async refreshToken(refreshToken: string): Promise<Token> {
        return Token.refresh(refreshToken);
    },
    async logout(accessToken: string): Promise<void> {

    }
}