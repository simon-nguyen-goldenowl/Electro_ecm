<template>
    <div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">User List</h2>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <router-link to="/users/create" tag="button" class="btn btn-success">
                                            Create New Admin Account <i class="fas fa-plus fa-fw"></i>
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
                                            Full name <i class="fas fa-sort"></i>
                                        </th>
                                        <th class="sort" v-on:click="getSort('username')">
                                            Username <i class="fas fa-sort"></i>
                                        </th>
                                        <th class="sort" v-on:click="getSort('email')">
                                            Email <i class="fas fa-sort"></i>
                                        </th>
                                        <th class="sort" v-on:click="getSort('phone')">
                                            Phone <i class="fas fa-sort"></i>
                                        </th>
                                        <th class="sort" v-on:click="getSort('address')">
                                            Address <i class="fas fa-sort"></i>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user of list_users.data" :key="user.id">
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.username }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.phone }}</td>
                                        <td>{{ user.address }}</td>
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
                                        <the-pagination v-bind:pagination="list_users" v-on:click.native="getUserList"></the-pagination>
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
    </div>
</template>

<script>
import axios from 'axios'
import {DefaultConstants} from "../../constants/DefaultConstant";
import {UrlConstants} from '../../constants/UrlConstant';
import ThePagination from "../../components/ThePagination";
export default {
    name: "UserList",
    components: {
        ThePagination
    },
    data() {
        return {
            column: DefaultConstants.column, //default column = 'id'
            sort: DefaultConstants.sort, //default sort = 'asc'
            limit: DefaultConstants.limit, //default limit = 15
            list_users: [],
            errors: []
        }
    },
    created() {
      this.getUserList();
    },
    methods: {
        getUrl(){
            let url = UrlConstants.user + '?column=' + this.column
                                        + '&sort=' + this.sort
                                        + '&limit=' + this.limit
            return url;
        },
        getUserList() {
            let url = this.getUrl();
            axios.get(url + '&page=' + this.list_users.current_page)
            .then(response => {
                this.list_users = response.data;
            })
            .catch(error => {
                this.errors = error.response.data
            })
        },
        getLimit(event){
            this.limit = event.target.value;
            this.list_users.current_page = 1;
            this.getUserList();
        },
        getSort(column){
            if (this.sort === 'asc') {
                this.sort = 'desc';
            } else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            this.column = column;
            this.getUserList();
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
</style>
