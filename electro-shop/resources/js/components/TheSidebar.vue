<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- brand Logo -->
        <router-link to="/" class="brand-link">
            <img src="/assets/admin/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Admin</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/assets/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <router-link to="/profile" class="d-block">{{user.username}}</router-link>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/products" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Product List
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/brands" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                               Brand List
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/categories" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Category List
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/users" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                User List
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/orders" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Order List
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" v-on:click.prevent="logOut">
                            <i class="nav-icon fas fa-power-off"></i>
                            <p>
                                LOG OUT
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
import axios from 'axios';
import {UrlConstants} from "../constants/UrlConstant";

export default {
    name: "TheSidebar",
    data() {
        return {
            user: {}
        }
    },
    created() {
        this.getCurrentUser();
    },
    methods: {
        getCurrentUser(){
            axios.get(UrlConstants.user + '/' + this.$cookies.get('id'))
            .then(res =>{
                this.user = res.data
            })
        },
        logOut(){
            let result = confirm('do you want to log out?')
            if(result){
                axios.delete('/api/logout').then(r => {
                    this.$cookies.remove('token');
                    this.$emit('user-logout', null);
                    this.$router.push('/login');
                })
            }
        }
    }
}
</script>

<style scoped>
a.router-link-exact-active{
    background-color: green;
}

</style>
