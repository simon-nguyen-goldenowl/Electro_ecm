<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Brand Create</h2>
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
                                    <form class="form-horizontal" v-on:submit.prevent="createBrand">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Brand Name: </label>
                                            <div class="col-sm-12">
                                                <input id="name" type="text" class="form-control" v-model="brand.name"/>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <router-link to="/brands" tag="button" class="btn btn-primary">
                                                    Back
                                                </router-link>
                                                <button type="submit" class="btn btn-success">Create</button>
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
    name: "BrandCreateForm",
    data() {
        return {
            errors: null,
            brand: {}
        }
    },
    methods: {
        createBrand(){
            axios.post(UrlConstants.brand, this.brand)
                .then(response => {
                    alert('success')
                    this.$router.push('/brands')
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
