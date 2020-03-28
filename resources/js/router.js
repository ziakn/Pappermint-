import Vue from 'vue'
import Router from 'vue-router'
import dashboard from './components/dashboard/Home.vue'
import login from './components/dashboard/user/login.vue'
import userlist from './components/dashboard/user/userlist.vue'
import staffregister from './components/staff/user/register.vue'
import stafflogin from './components/staff/user/login.vue'
// import company from './components/dashboard/user/company.vue'


let onlyAdmin = ['Admin']
let onlyGuest = ['Guest']

Vue.use(Router)
export default new Router({
    mode: 'history',
    routes:
    [

        {
            path: '/dashboard',
            name: 'dashboard',
            component: dashboard,
            meta: 
            {
            title: 'Dashboard',
            type: onlyAdmin,
            }

        },
        {
            path: '/dashboard/login',
            name: 'login',
            component: login,
            meta: 
            {
            title: 'Login',
            type: onlyGuest,
            }

        },
        {
            path: '/dashboard/userlist',
            name: 'userlist',
            component: userlist,
            meta: { title: 'User List',
            type: onlyAdmin, }

        },

        
        {
            path: '/staff/register',
            name: 'staffregister',
            component: staffregister,
            meta: { title: 'Register Staff',
            type: onlyAdmin, }

        },
        {
            path: '/staff/login',
            name: 'stafflogin',
            component: stafflogin,
            meta: { title: 'Login Staff',
            type: onlyAdmin, }

        },
        

    ]
})