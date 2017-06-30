import VueRouter from 'vue-router';

// Import Vuex Store so we have access to our global state
import store from './../store/index.js';

const routes = [
    {
        path: '/',
        name: 'home',
        component: require('./../views/Home.vue'),
        meta: {
            breadcrumb: 'Home Page',
            requiresUnlock: true
        }
    },
    {
        path: '/journals/:journalId',
        name: 'journals.show',
        component: require('../views/Journal.vue'),
        meta: {
            requiresUnlock: true,
            breadcrumb: 'Journal Details'
        }
    },
    {
        path: '/entries/:entryId',
        name: 'entries.preview',
        component : require('./../views/Entry.vue'),
        meta: {
            requiresUnlock: true,
            breadcrumb: 'Entry Details'
        }
    },
    {
        path: '/unlock',
        component: require('./../views/Unlock.vue'),
        meta: {
            requiresUnlock: false,
            breadcrumb: 'Unlock'
        },
        beforeEnter: (to, from, next) => {
            if (store.getters.isUnlocked) {
                next('/');
            }

            next();
        }
    }
]


const router =  new VueRouter({ routes });


router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.requiresUnlock)) {

        if (! store.getters.isUnlocked) {
            next({
                path: '/unlock',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router;