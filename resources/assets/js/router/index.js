import VueRouter from 'vue-router';


const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

const User = {
    props: ['id'],
    template: '<div>User {{ id }}</div>'
}


const routes = [
    {
        path: '/foo',
        component: Foo
    },
    {
        path: '/bar',
        component: Bar
    },
    {
        path: '/user/:id',
        component: User,
        props: true
    },
    {
        path: '/create-master-password',
        name: 'auth.create-master-password',
        component: {
            'template': '<div>CREATE MASTERPASSWORD</div>'
        }
    },
    {
        path: '/unlock',
        name: 'auth.unlock',
        component: {
            'template': '<div>Just enter Masterpassword to unlock</div>'
        }
    },
    {
        path: '/journals',
        name: 'journals.index',
        component: {
            'template': '<div>Single Journal</div>'
        },
        children: [
            {
                path: ':id',
                name: 'journals.show',
                component: {
                    'template': '<div> Single JOURNAL </div>'
                }
            }
        ]
    },
    {
        path: '/user/settings',
        name: 'user.settings',
        component: {
            'template': '<div>Settings</div>'
        }
    }
]




export default new VueRouter({
  routes // short for routes: routes
});