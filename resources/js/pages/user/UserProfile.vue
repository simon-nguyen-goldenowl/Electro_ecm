<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Product Update</h2>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="settings">
                                    <div class="alert alert-danger" v-if="errors !== null">
                                        <ul>
                                            <li v-for="(v, k) in errors" :key="k">
                                                {{ v.toString() }}
                                            </li>
                                        </ul>

                                    </div>
                                    <form class="form-horizontal" v-on:submit.prevent="updateUser(user.id)">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Code: </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" v-model="user.code" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Username: </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" v-model="user.username" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Full name: </label>
                                            <div class="col-sm-12">
                                                <input id="name" type="text" class="form-control" v-model="user.name"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Email: </label>
                                            <div class="col-sm-12">
                                                <input id="email" type="email" class="form-control" v-model="user.email"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Address: </label>
                                            <div class="col-sm-12">
                                                <input id="address" type="text" class="form-control" v-model="user.address"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Phone: </label>
                                            <div class="col-sm-12">
                                                <input id="phone" type="text" class="form-control" v-model="user.phone"/>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <router-link to="/" tag="button" class="btn btn-primary">
                                                    Back
                                                </router-link>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</template>

<script>
import axios from "axios";
import {UrlConstants} from "../../constants/UrlConstant";
export default {
    name: "UserProfile",
    data(){
        return{
            user: {},
            errors: null,
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
        updateUser(id){
            axios.patch(UrlConstants.user + '/' + id, this.user )
                .then(response => {
                    alert('Update Successfully');
                    this.$router.push('/')
                })
                .catch(error =>{
                    this.errors = error.response.data.errors;
                    this.showError(this.errors);
                })
        },
        showError(errors){
            Object.keys(errors).forEach(error=>{
                let text = document.querySelector('#'+error);
                text.style.cssText = 'border-color: red'
            })
        }
    }
}
</script>

<style scoped>

</style>
