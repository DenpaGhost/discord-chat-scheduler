export default {
    transformQueryString: (obj: any): string => {
        let str = '';
        for (const it in obj) {
            str += `${encodeURIComponent(it)}=${encodeURIComponent(obj[it])}&`;
        }
        return str.slice(0, -1);
    },
    validateClientSide: () => {
        if (!process.browser) {
            throw new Error('サーバーサイドでの実行です');
        }
    }
}