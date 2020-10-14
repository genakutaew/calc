import VueRouter from 'vue-router'
// Pages
import NotFound from './components/NotFound'
import Forbidden from './components/Forbidden'
import Home from './components/Home'
import Login from './components/Login'
import Profile from './components/Profile'
import Users from './components/Users'
import Bookmarks from './components/Bookmarks'
import Calc from './components/Calc'
import Create from './components/Create'
import Edit from './components/Edit'

import Test from './components/Test'
// Routes
const routes = [{
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
    },
    {
        path: '/test',
        component: Test,
    },
    {
        path: '/403',
        component: Forbidden,
        meta: {
            auth: true
        }
    },
    {
        path: '/404',
        component: NotFound
    },
    {
        path: '*',
        redirect: '/404'
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            //auth: false,
        },
    },
    // {
    //     path: '/register',
    //     name: 'register',
    //     component: Register,
    //     meta: {
    //         auth: false
    //     }
    // },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: {
            auth: true
        }
    },
    {
        path: '/create',
        name: 'create',
        component: Create,
        meta: {
            auth: {
                roles: '1'
            }
        }
    },
    {
        path: '/edit/:calcId',
        name: 'edit',
        component: Edit,
        meta: {
            auth: {
                roles: '1'
            }
        }
    },
    {
        path: '/bookmarks',
        name: 'bookmarks',
        component: Bookmarks,
        meta: {
            auth: true
        }
    },
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta: {
            auth: {
                roles: '1'
            }
        }
    },
    {
        path: '/calc/:calcId',
        name: 'calc',
        component: Calc,
        meta: {
            auth: true
        }
    }

]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})

export default router
