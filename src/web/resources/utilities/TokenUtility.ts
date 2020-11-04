export default {
    convertExpiresIn(second: number) {
        return new Date((new Date()).getTime() + second * 1000);
    }
}