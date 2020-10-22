export default {
    transformQueryString: (obj: any): string => {
        let str = '';
        for (const it in obj) {
            str += `${encodeURIComponent(it)}=${encodeURIComponent(obj[it])}&`;
        }
        return str.slice(0, -1);
    }
}