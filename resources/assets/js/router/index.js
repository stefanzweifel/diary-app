import VueRouter from 'vue-router';

// Import Vuex Store so we have access to our global state
import store from './../store/index.js';

const routes = [
    {
        path: '/',
        redirect: { name: 'journals.index'}
    },
    {
        path: '/j',
        name: 'journals.index',
        component: (resolve) => {
            require(['./views/HomeView.vue'], resolve)
        },
        meta: {
            requiresUnlock: true,
            breadcrumb: 'Journals'
        },
        children: [
            {
                path: ':journalId',
                name: 'journals.show',
                component: (resolve) => {
                    require(['./views/JournalView.vue'], resolve)
                },
                props: true,
                meta: {
                    requiresUnlock: true,
                    breadcrumb: 'Journal Details'
                },
                children: [
                    {
                        path: '/j/:journalId/e/:entryId',
                        name: 'entries.show',
                        component: (resolve) => {
                            require(['./views/EntryView.vue'], resolve)
                        },
                        props: true,
                        meta: {
                            requiresUnlock: true,
                            breadcrumb: 'Entry Details'
                        }
                    }
                ]
            }
        ]
    },
    {
        path: '/unlock',
        component: (resolve) => {
            require(['./views/UnlockView.vue'], resolve)
        },
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