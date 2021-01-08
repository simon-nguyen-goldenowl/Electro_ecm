<template>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Order List</h2>
                        </div>
                        <!--FILTER SECTION-->
                        <div class="card-header">
                            <div class="row">
                                <h3 class="card-title"> Filter</h3>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label>User Type</label>
                                    <select class="form-control select2"  id="member_id" name="category"  v-model="filter.type" v-on:change="getFilter">
                                        <option value="" selected>All</option>
                                        <option value="member">Member</option>
                                        <option value="guest" selected>Guest</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Customer Name: </label>
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" v-model="filter.customer_name" v-on:keyup="getFilter">
                                </div>
                                <div class="form-group">
                                    <label>Email: </label>
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" v-model="filter.email" v-on:keyup="getFilter">
                                </div>
                                <div class="form-group">
                                    <label>Address </label>
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" v-model="filter.address" v-on:keyup="getFilter">
                                </div>
                                <div class="form-group">
                                    <label>Order Status</label>
                                    <select class="form-control select2"  id="order_id" name="category"  v-model="filter.order_status" v-on:change="getFilter">
                                        <option value="" selected>All</option>
                                        <option v-for="o_status in list_order_statuses.data" :key="o_status.id"
                                                v-bind:value="o_status.id"
                                        >{{ o_status.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Shipping Status</label>
                                    <select class="form-control select2"  id="ship_id" name="category"  v-model="filter.shipping_status" v-on:change="getFilter">
                                        <option value="" selected>All</option>
                                        <option v-for="s_status in list_shipping_statuses.data" :key="s_status.id"
                                                v-bind:value="s_status.id"
                                        >{{ s_status.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select class="form-control select2"  id="pay_id" name="category"  v-model="filter.payment_status" v-on:change="getFilter">
                                        <option value="" selected>All</option>
                                        <option v-for="p_status in list_payment_statuses.data" :key="p_status.id"
                                                v-bind:value="p_status.id"
                                        >{{ p_status.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/.FILTER SECTION-->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="sort" v-on:click="getSort('customer_id')">
                                        User Type
                                    </th>
                                    <th class="sort" v-on:click="getSort('name')">
                                        User Name <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('email')">
                                        Email <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('address')">
                                        Address <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('phone')">
                                        Phone <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('order_status')">
                                        Order Status <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('shipping_status')">
                                        Shipping Status <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="sort" v-on:click="getSort('payment_status')">
                                        Payment Status <i class="fas fa-sort"></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="order of list_orders.data" :key="order.id">
                                    <td v-if="order.customer_id !== null">
                                        Member
                                    </td>
                                    <td v-else>
                                        Guest
                                    </td>
                                    <td>{{order.name}}</td>
                                    <td>{{order.email}}</td>
                                    <td>{{order.address}}</td>
                                    <td>{{order.phone}}</td>
                                    <td>{{order.order_status.name}}</td>
                                    <td v-if="order.shipping_status !== null">
                                        {{order.shipping_status.name}}
                                    </td>
                                    <td v-else>
                                        NaN
                                    </td>
                                    <td v-if="order.shipping_status !== null">
                                        {{order.payment_status.name}}
                                    </td>
                                    <td v-else>
                                        NaN
                                    </td>
                                    <td>
                                        <p class="click" v-on:click="showOrder(order.id)"><b>Detail</b></p>
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
                                    <the-pagination v-bind:pagination="list_orders" v-on:click.native="getOrderList"></the-pagination>
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
    name: "OrderList",
    components: {ThePagination},
    comments: {
        ThePagination
    },
    data() {
        return {
            column: DefaultConstants.column, //default column = 'id'
            sort: DefaultConstants.sort, //default sort = 'asc'
            limit: DefaultConstants.limit, //default limit = 15
            list_orders: [],
            list_order_statuses: [],
            list_shipping_statuses: [],
            list_payment_statuses: [],
            filter: [],
        }
    },
    created() {
        this.getOrderList();
        this.getOrderStatusList();
        this.getPaymentStatusList();
        this.getShippingStatusList();
    },
    methods: {
        getFilter(){
            let url = this.getUrl();
            axios.get(url)
                .then(response=> {
                    this.list_orders = response.data;
                });
        },
        getUrl(){
            let url= UrlConstants.order + '?column=' + this.column
                + '&sort=' + this.sort
                + '&limit=' + this.limit
            Object.entries(this.filter).forEach(([key, value])=>{
                if(value !== ''){
                    url += '&' + key + '=' + value;
                }
            })
            return url;
        },
        getOrderStatusList() {
            axios.get(UrlConstants.status + '?order_status')
                .then(response => {
                    this.list_order_statuses = response.data;
                })
        },
        getShippingStatusList() {
            axios.get(UrlConstants.status + '?shipping_status')
                .then(response => {
                    this.list_shipping_statuses = response.data;
                })
        },
        getPaymentStatusList() {
            axios.get(UrlConstants.status + '?payment_status')
                .then(response => {
                    this.list_payment_statuses = response.data;
                })
        },
        getOrderList() {
            let url = this.getUrl()
            axios.get(url +'&page=' + this.list_orders.current_page)
                .then(response => {
                    this.list_orders = response.data;
                })
                .catch(error => {
                    this.list_errors = error.response.data
                })
        },
        showOrder(id){
            router.push('/orders/'+id+'/detail');
        },
        getSort(column) {
            if (this.sort === 'asc') {
                this.sort = 'desc';
            } else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            this.column = column;
            this.getOrderList();
        },
        getLimit(event) {
            this.limit = event.target.value;
            this.list_orders.current_page = 1;
            this.getOrderList();
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
