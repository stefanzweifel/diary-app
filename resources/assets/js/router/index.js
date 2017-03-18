import VueRouter from 'vue-router';

// Import Vuex Store so we have access to our global state
import store from './../store/index.js';

const routes = [
    {
        path: '/',
        name: 'home',
        component: require('./../views/Home.vue'),
        meta: {
            requiresUnlock: true
        }
    },
    {
        path: '/journals/:journalId',
        name: 'journals.show',
        component: require('../views/Journal.vue'),
        meta: {
            requiresUnlock: true
        }
    },
    {
        path: '/entries/:entryId',
        name: 'entries.preview',
        component : require('./../views/Entry.vue'),
        meta: {
            requiresUnlock: true
        }
    },
    {
        path: '/entries/:entryId/edit',
        name: 'entries.edit',
        component : require('./../views/Editor.vue'),
        meta: {
            requiresUnlock: true
        }
    },
    {
        path: '/unlock',
        component: require('./../views/Unlock.vue'),
        meta: {
            requiresUnlock: false
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
        next() // make sure to always call next()!
    }
})

export default router;