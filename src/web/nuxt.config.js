require('dotenv').config();
const {NODE_ENV} = process.env;

export default {
    env: {
        NODE_ENV
    },
    buildModules: ['@nuxt/typescript-build', '@nuxtjs/dotenv'],

    modules: [
        'nuxt-fontawesome'
    ],
    fontawesome: {
        imports: [
            {
                set: '@fortawesome/free-solid-svg-icons',
                icons: ['fas']
            }
        ]
    },
    watchers: {
        webpack: {
            poll: true
        }
    },
    head: {
        meta: [
            {
                name: 'viewport',
                content: 'width=device-width, initial-scale=1, shrink-to-fit=no'
            }
        ]
    }
}