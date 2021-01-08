import Vue from 'vue';
import Router from 'vue-router';
import ProductList from "./pages/product/ProductList";
import UserList from "./pages/user/UserList";
import ProductUpdateForm from "./pages/product/ProductUpdateForm";
import ProductCreateForm from "./pages/product/ProductCreateForm";
import ProductReviewList from "./pages/product/ProductReviewList";
import BrandList from "./pages/brand/BrandList";
import BrandCreateForm from "./pages/brand/BrandCreateForm";
import BrandUpdateForm from "./pages/brand/BrandUpdateForm";
import CategoryList from "./pages/category/CategoryList";
import CategoryCreateForm from "./pages/category/CategoryCreateForm";
import CategoryUpdateForm from "./pages/category/CategoryUpdateForm";
import OrderList from "./pages/order/OrderList";
import OrderDetail from "./pages/order/OrderDetail";
import Login from "./pages/Login";
import axios from "axios";
import PageNotFound from "./pages/PageNotFound";
import UserProfile from "./pages/user/UserProfile";
import UserCreateForm from "./pages/user/UserCreateForm";
Vue.use(Router);
const ifAuthenticated = (to, from, next) => {
    axios.get('/api/checkAuthenticated').then(() => {
        next()
    }).catch(() => {
        return next('/login')
    })
}
const ifLogged = (to, from, next) => {
    axios.get('/api/checkAuthenticated').then(() => {
        next('/')
    }).catch(() => {
        return next()
    })
}
const router = new Router({
    base: 'admin',
    mode: 'history',
    routes: [
       {
            name:'Login',
            path: '/login',
            component: Login,
            beforeEnter: ifLogged,
    },{
        name:'Index',
        path: '/',
        component: ProductList,
        beforeEnter: ifAuthenticated,
    },{
        name:'Product',
        path: '/products',
        component: ProductList,
        beforeEnter: ifAuthenticated,
    },{
        name:'ProductUpdate',
        path: '/products/:id/update',
        component: ProductUpdateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'ProductReview',
        path: '/products/:id/reviews',
        component: ProductReviewList,
        beforeEnter: ifAuthenticated,
    },{
        name:'ProductCreate',
        path: '/products/create',
        component: ProductCreateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'Users',
        path: '/users',
        component: UserList,
        beforeEnter: ifAuthenticated,
    },{
        name:'UserProfile',
        path: '/profile',
        component: UserProfile,
        beforeEnter: ifAuthenticated,
    },{
        name:'UserCreate',
        path: '/users/create',
        component: UserCreateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'Brands',
        path: '/brands',
        component: BrandList,
        beforeEnter: ifAuthenticated,
    },{
        name:'BrandCreate',
        path: '/brands/create',
        component: BrandCreateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'BrandUpdate',
        path: '/brands/:id/update',
        component: BrandUpdateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'Categories',
        path: '/categories',
        component: CategoryList,
        beforeEnter: ifAuthenticated,
    },{
        name:'CategoryCreate',
        path: '/categories/create',
        component: CategoryCreateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'CategoryUpdate',
        path: '/categories/:id/update',
        component: CategoryUpdateForm,
        beforeEnter: ifAuthenticated,
    },{
        name:'Orders',
        path: '/orders',
        component: OrderList,
        beforeEnter: ifAuthenticated,
    },{
        name:'OrderDetail',
        path: '/orders/:id/detail',
        component: OrderDetail,
        beforeEnter: ifAuthenticated,
    },{
        path: '*',
        component: PageNotFound,
    }]
})
export default router
