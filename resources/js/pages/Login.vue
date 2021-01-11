<template>
    <div class="login" >
        <div class="login-box">
            <h2>
                <strong>Electro Shop - Admin</strong>
            </h2>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <form class="login" v-on:submit.prevent="login">
                        <span style="color:red;" v-if="error !== null">{{error}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-model="username" placeholder="UserName">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" v-model="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {ResultConstants} from "../constants/ResultConstant";

export default {
    name: "login",
    data() {
        return {
            user: [],
            username: "",
            password: "",
            error: '',
        };
    },
    created() {
        axios.get('/sanctum/csrf-cookie').then(response => {});
    },
    methods: {
        login() {
            axios.post('/api/admin/login', {
                username: this.username,
                password: this.password
            }).then(response => {
                if (response.data === ResultConstants.failure) {
                    this.error = 'Wrong email or password'
                } else {
                    let cookie= this.$cookies.set('token', response.data.token, '120min');
                    this.$cookies.set('id', response.data.id, '120min')
                    this.$emit("user-login", cookie);
                    this.$router.push('/');
                }
            })
        }
    },
}
</script>

<style scoped>
.card {
    margin-top: 20px;
}
.login-box{
    margin-left: 35%;
    padding-top:40px;
}
</style>
