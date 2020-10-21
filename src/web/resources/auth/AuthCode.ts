const createRandomString
    = (num: number) => [...Array(num)].map(() => Math.random().toString(36)[2]).join('');

const hash = (message: string) => {
    const encoder = new TextEncoder();
    const data = encoder.encode(message);
    return crypto.subtle.digest('SHA-256', data);
}

export default {
    makeState: (): string => createRandomString(40),
    makeCodeVerifier: (): string => createRandomString(128),
    makeCodeChallenge: async (verifier: string): Promise<string> => {
        const encoded = btoa(String.fromCharCode(...new Uint8Array(await hash(verifier))));
        return encoded
            .replace(/\+/g, '-')
            .replace(/\//g, '_')
            .replace(/=/g, '')
    }
}