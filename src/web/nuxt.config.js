require('dotenv').config();
const {NODE_ENV} = process.env;

export default {
    env: {
        NODE_ENV
    },
    buildModules: ['@nuxt/typescript-build', '@nuxtjs/dotenv'],
    css: [
        '@/assets/styles/main.scss'
    ],
    pageTransition: {
        name: 'yoyacord'
    },
    modules: [
        'nuxt-fontawesome',
        '@nuxtjs/axios'
    ],
    plugins: [
        '~/plugins/axios-accessor.ts'
    ],
    fontawesome: {
        component: 'fa'
    },
    axios: {},
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