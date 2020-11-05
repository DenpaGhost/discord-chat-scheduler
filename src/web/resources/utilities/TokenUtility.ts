export default {
    convertExpiresInDate(second: number) {
        const now = new Date();
        return new Date(now.getTime() + second * 1000);
    },
    convertTimeToDate(time: number) {
        return new Date(time);
    },
    isExpire(expiresIn: Date): boolean {
        const now = new Date();
        return now.getTime() > expiresIn.getTime();
    }
}