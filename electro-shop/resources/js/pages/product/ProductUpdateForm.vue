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
                                    <form class="form-horizontal" v-on:submit.prevent="updateProduct(product.id)">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Code: </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" v-model="product.code" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name: </label>
                                            <div class="col-sm-12">
                                                <input id="name" type="text" class="form-control" v-model="product.name"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Image:</label>
                                            <div class="col-sm-12">
                                                <img v-bind:src="'/assets/admin/dist/img/'+ this.image" alt="test" height="200">
                                                <input type="file" v-on:change="uploadImage">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Brand: </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="brand"  v-model="product.brand_id">
                                                    <option selected v-bind:value="product.brand.id">{{product.brand.name}}</option>
                                                    <option v-for="brand in list_brands.data" :key="brand.id"
                                                            v-bind:value="brand.id"
                                                            v-if="brand.id !== product.brand.id">{{ brand.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Category: </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="category"  v-model="product.cate_id">
                                                    <option selected v-bind:value="product.category.id">{{product.category.name}}</option>
                                                    <option v-for="cate in list_categories.data" :key="cate.id"
                                                            v-bind:value="cate.id"
                                                            v-if="cate.id !== product.category.id">{{ cate.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Price: </label>
                                            <div class="col-sm-12">
                                                <input id="price" type="text" class="form-control" v-model="product.price"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Amount:</label>
                                            <div class="col-sm-12">
                                                <input id="amount" type="text" class="form-control" v-model="product.amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <router-link to="/products" tag="button" class="btn btn-primary">
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
    name: "ProductUpdateForm",
    data() {
        return {
            product: {},
            list_brands: [],
            list_categories: [],
            errors: null,
            image: '',
        }

    },
    created() {
      this.getProduct();
      this.getBrandList();
      this.getCategoryList();
    },
    methods: {
        getProduct(){
            axios.get(UrlConstants.product + '/' + this.$route.params.id)
            .then(response => {
                this.product = response.data;
                this.image = this.product.image
            })
        },
        getBrandList(){
          axios.get(UrlConstants.brand)
          .then(response => {
              this.list_brands = response.data;
          })
        },
        getCategoryList(){
            axios.get(UrlConstants.category)
                .then(response => {
                    this.list_categories = response.data;
                })
        },
        uploadImage(event){
           this.product.image= event.target.files[0]['name'];
            this.image = this.product.image
        },
        updateProduct(id){
            axios.patch(UrlConstants.product + '/' + id, this.product )
            .then(response => {
                alert('success')
                this.$router.push('/products')
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
.card{
    margin:20px;
}
</style>
