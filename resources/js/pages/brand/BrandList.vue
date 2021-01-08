<template>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Brand List</h2>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <router-link to="/brands/create" tag="button" class="btn btn-success">
                                        Add New <i class="fas fa-plus fa-fw"></i>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="sort" v-on:click="getSort('name')">
                                        Name <i class="fas fa-sort"></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="brand of list_brands.data" :key="brand.id">
                                    <td>{{ brand.name }}</td>
                                    <td>
                                        <p class="click" v-on:click="showBrand(brand.id)"><b>Update</b></p> |
                                        <p class="click" v-on:click="deleteBrand(brand.id)"><b>Delete</b></p>
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
                                    <the-pagination v-bind:pagination="list_brands" v-on:click.native="getBrandList"></the-pagination>
                                </div>
                            </div>
                        </div>
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
import axios from 'axios'
import {DefaultConstants} from "../../constants/DefaultConstant";
import {UrlConstants} from '../../constants/UrlConstant';
import ThePagination from "../../components/ThePagination";
import {ResultConstants} from "../../constants/ResultConstant";
import router from "../../router";
export default {
    name: "BrandList",
    components: {
        ThePagination
    },
    data() {
        return {
            column: DefaultConstants.column, //default column = 'id'
            sort: DefaultConstants.sort, //default sort = 'asc'
            limit: DefaultConstants.limit, //default limit = 15
            list_brands: [],
            errors: []
        }
    },
    created() {
        this.getBrandList();
    },
    methods: {
        getUrl(){
            let url = UrlConstants.brand + '?column=' + this.column
                + '&sort=' + this.sort
                + '&limit=' + this.limit
            return url;
        },
        getBrandList() {
            let url = this.getUrl();
            axios.get(url + '&page=' + this.list_brands.current_page)
                .then(response => {
                    this.list_brands = response.data;
                })
                .catch(error => {
                    this.errors = error.response.data
                })
        },
        showBrand(id){
            axios.get(UrlConstants.brand + "/" + id)
                .then(response => {
                    if (response.data.id === undefined){
                        alert('error');
                        this.getBrandList();
                    } else {
                        router.push('/brands/'+id+'/update');
                    }
                })
        },
        deleteBrand(id){
          axios.delete(UrlConstants.brand+ '/'+id)
              .then(response => {
                    if(response.data === ResultConstants.success){
                        alert('Success');
                        this.getBrandList();
                    }
                    if (response.data === ResultConstants.failure){
                        alert('Error! Cannot delete this brand')
                        this.getBrandList();
                    }
              })
              .catch(error => {
                        this.errors = error.response.data
              })
        },
        getLimit(event){
            this.limit = event.target.value;
            this.list_brands.current_page = 1;
            this.getBrandList();
        },
        getSort(column){
            if (this.sort === 'asc') {
                this.sort = 'desc';
            } else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            this.column = column;
            this.getBrandList()
        }
    }
}
</script>

<style scoped>
.card{
    margin: 20px;
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
