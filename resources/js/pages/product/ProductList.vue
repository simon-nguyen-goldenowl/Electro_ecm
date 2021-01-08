<template>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Product List</h2>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <router-link to="/products/create" tag="button" class="btn btn-success">
                                            Add New <i class="fas fa-plus fa-fw"></i>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <!--FILTER SECTION-->
                            <div class="card-header">
                                <div class="row">
                                    <h3 class="card-title"> Filter</h3>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" type="text" placeholder="Search" aria-label="Search" v-model="filter.name" v-on:keyup="getFilter">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control select2"  id="cate_id" name="category"  v-model="filter.cate_id" v-on:change="getFilter">
                                            <option value="" selected>All</option>
                                            <option v-for="cate in list_categories.data" :key="cate.id"
                                                    v-bind:value="cate.id"
                                            >{{ cate.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select class="form-control select2"  id="brand_id" name="brand" v-model="filter.brand"  v-on:change="getFilter()">
                                            <option value="" selected>All</option>
                                            <option v-for="brand in list_brands.data" :key="brand.id"
                                                    v-bind:value="brand.id"
                                            >{{ brand.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input class="form-control" type="text"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                               placeholder="Search" aria-label="Search"
                                               v-model="filter.amount" v-on:keyup="getFilter">
                                    </div>
                                    <div class="form-group">
                                        <label>Min Price:</label>
                                        <input class="form-control" type="text"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                               placeholder="Search" aria-label="Search"
                                               v-model="filter.min_price" v-on:keyup="getFilter">
                                    </div>
                                    <div class="form-group">
                                        <label>Max Price:</label>
                                        <input class="form-control" type="text"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                               placeholder="Search" aria-label="Search"
                                               v-model="filter.max_price" v-on:keyup="getFilter">
                                    </div>
                                </div>
                            </div>
                            <!--/.FILTER SECTION-->

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="sort" v-on:click="getSort('name')">
                                        Name <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('image')">
                                        Image <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('cate_id')">
                                        Category <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('brand_id')">
                                        Brand <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('price')">
                                        Price <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('amount')">
                                        Quantity <i class="fas fa-sort"></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product of list_products.data" :key="product.id">
                                    <td>{{product.name}}</td>
                                    <td>
                                        <img v-bind:src="'/assets/admin/dist/img/' + product.image" alt="product" width="150" height="150">
                                    </td>
                                    <td>{{product.category.name}}</td>
                                    <td>{{product.brand.name}}</td>
                                    <td>${{product.price}}</td>
                                    <td>{{product.amount}}</td>
                                    <td>
                                        <p class="click" v-on:click="showProduct(product.id)"><b>Update</b></p> |
                                        <p class="click" v-on:click="deleteProduct(product.id)"><b>Delete</b></p> |
                                        <p class="click" v-on:click="showReview(product.id)"><b>Review</b></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div>
                                            <strong> Per Page: </strong>
                                            <select v-on:change="getLimit($event)">
                                                <option value="10" selected>10</option>
                                                <option value="15">15</option>
                                                <option value="1">1</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <the-pagination v-bind:pagination="list_products" v-on:click.native="getProductList"></the-pagination>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
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
import router from "../../router";
import {UrlConstants} from "../../constants/UrlConstant";
import {ResultConstants} from "../../constants/ResultConstant";
import {DefaultConstants} from "../../constants/DefaultConstant";
import ThePagination from "../../components/ThePagination";

export default {
    name: "ProductList",
    components: {ThePagination},
    comments: {
      ThePagination
    },
    data() {
        return {
            column: DefaultConstants.column, //default column = 'id'
            sort: DefaultConstants.sort, //default sort = 'asc'
            limit: DefaultConstants.limit, //default limit = 15
            list_brands: [],
            list_categories: [],
            list_products: [],
            list_notifications: [],
            list_errors: [],
            filter: [],
        }
    },
    created() {
        this.getProductList();
        this.getBrandList();
        this.getCategoryList();
        this.filter.max_price = DefaultConstants.maxPrice;
        this.filter.min_price = DefaultConstants.minPrice;
    },
    methods: {
        getFilter(){
            if( this.filter.max_price === ''){
                this.filter.max_price = DefaultConstants.maxPrice;
            }
            if( this.filter.min_price === ''){
                this.filter.min_price = DefaultConstants.minPrice;
            }
            let url = this.getUrl();
            axios.get(url)
                .then(response=> {
                this.list_products = response.data;
                });
        },
        getUrl(){
            let url= UrlConstants.product + '?column=' + this.column
                                          + '&sort=' + this.sort
                                          + '&limit=' + this.limit
            Object.entries(this.filter).forEach(([key, value])=>{
                if(value !== ''){
                    url += '&' + key + '=' + value;
                }
            })
            return url;
        },
        getProductList() {
            let url = this.getUrl()
            axios.get(url +'&page=' + this.list_products.current_page)
                .then(response => {
                    this.list_products = response.data;
                })
                .catch(error => {
                    this.list_errors = error.response.data
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
        showProduct(id){
            axios.get(UrlConstants.product + "/" + id)
                .then(response => {
                    if (response.data.id === undefined){
                        alert('error');
                        this.getProductList();
                    } else {
                        router.push('/products/'+id+'/update');
                    }
                })
        },
        showReview(id){
            axios.get(UrlConstants.product + "/" + id)
                .then(response => {
                    if (response.data.id === undefined){
                        alert('error');
                        this.getProductList();
                    } else {
                        router.push('/products/'+id+'/reviews');
                    }
                })
        },
        deleteProduct(id){
            axios.delete(UrlConstants.product + '/' + id)
                .then(response => {
                    if(response.data === ResultConstants.success){
                        alert('success');
                        this.getProductList();
                    }
                    if (response.data === ResultConstants.failure){
                        alert('error')
                        this.getProductList();
                    }
                })
                .catch(error => {
                    this.errors = error.response.data
                })
        },
        getSort(column) {
            if (this.sort === 'asc') {
                this.sort = 'desc';
            } else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            this.column = column;
            this.getProductList();
        },
        getLimit(event) {
            this.limit = event.target.value;
            this.list_products.current_page = 1;
            this.getProductList();
        },


    }
}
</script>

<style scoped>
.card{
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 20px;

}
.sort{
    cursor: pointer;
}
.click {
    cursor: pointer;
    display: inline;
}
.click :hover {
    color: #D10024;
}

</style>
