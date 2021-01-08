<template>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Review List</h2>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="sort" v-on:click="getSort('customer_id')">
                                        UserName <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('content')">
                                        Content <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('created_at')">
                                        Created_date <i class="fas fa-sort"></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="review of list_reviews.data" :key="review.id">
                                    <td>{{review.customer.username}}</td>
                                    <td>{{review.content}}</td>
                                    <td>{{review.created_at}}</td>
                                    <td>
                                        <p class="click" v-on:click="deleteReview(review.id)"><b>Delete</b></p>
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
                                    <the-pagination v-bind:pagination="list_reviews" v-on:click.native="getReviewList"></the-pagination>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                    <div class="form-group text-center">
                        <div class="col-sm-offset-2 col-sm-12">
                            <router-link to="/products" tag="button" class="btn btn-primary">
                                Back
                            </router-link>
                        </div>
                    </div>
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
import {DefaultConstants} from "../../constants/DefaultConstant";
import ThePagination from "../../components/ThePagination";
import {ResultConstants} from "../../constants/ResultConstant";
export default {
    name: "ProductReviewList",
    components: {
        ThePagination
    },
    data(){
        return {
            column: DefaultConstants.column, //default column = 'id'
            sort: DefaultConstants.sort, //default sort = 'asc'
            limit: DefaultConstants.limit, //default limit = 15
            list_reviews: []
        }
    },
    created() {
        this.getReviewList()
    },
    methods:{
        getUrl(){
            let url= UrlConstants.review +'?product_id=' + this.$route.params.id+'&column=' + this.column
                + '&sort=' + this.sort
                + '&limit=' + this.limit
            return url
        },
        getReviewList(){
            let url = this.getUrl()
            console.log(url)
            axios.get(url + '&page=' + this.list_reviews.current_page)
            .then(response =>{
                this.list_reviews = response.data;
            })
        },
        deleteReview(id){
            axios.delete(UrlConstants.review + '/' + id)
                .then(response => {
                    if(response.data === ResultConstants.success){
                        alert('success');
                        this.getReviewList();
                    }
                    if (response.data === ResultConstants.failure){
                        alert('error')
                        this.getReviewList();
                    }
                })
                .catch(error => {
                    this.errors = error.response.data
                })
        },
        getSort(column){
            if (this.sort === 'asc') {
                this.sort = 'desc';
            } else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            this.column = column;
            this.getReviewList();
        },
        getLimit(event){
            this.limit = event.target.value;
            this.list_reviews.current_page = 1;
            this.getReviewList();
        }
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
