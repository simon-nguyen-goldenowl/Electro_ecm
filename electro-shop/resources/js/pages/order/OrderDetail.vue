<template>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Order Detail</h2>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="sort" v-on:click="getSort('name')">
                                        Product <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('product_id')">
                                        Product Name <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('price')">
                                        Price <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('amount')">
                                        Amount <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('total')">
                                        Total <i class="fas fa-sort"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item of list_items" :key="item.id">
                                    <td>
                                        <img v-bind:src="'/assets/admin/dist/img/' + item['product'].image" alt="product" width="150" height="150">
                                    </td>
                                    <td>{{item['product'].name}}</td>
                                    <td>{{item['price']}}</td>
                                    <td>{{item['amount']}}</td>
                                    <td>${{item['total']}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="form-group text-center">
                                <div class="col-sm-offset-2 col-sm-12">
                                    <router-link to="/orders" tag="button" class="btn btn-primary">
                                        Back
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
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
            list_items: [],
            list_errors: [],
            filter: [],
        }
    },
    created() {
        this.getDetailList();
    },
    methods: {
        getFilter(){
            let url = this.getUrl();
            axios.get(url)
                .then(response=> {
                    this.list_items = response.data;
                });
        },
        getUrl(){
            let url= UrlConstants.order + '/' + this.$route.params.id
                + '?column=' + this.column
                + '&sort=' + this.sort
            Object.entries(this.filter).forEach(([key, value])=>{
                if(value !== ''){
                    url += '&' + key + '=' + value;
                }
            })
            return url;
        },
        getDetailList() {
            let url = this.getUrl()

            axios.get(url)
                .then(response => {
                    this.list_items = response.data;
                })
                .catch(error => {
                    this.list_errors = error.response.data
                })
        },
        getSort(column) {
            if (this.sort === 'asc') {
                this.sort = 'desc';
            } else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            this.column = column;
            this.getDetailList();
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
