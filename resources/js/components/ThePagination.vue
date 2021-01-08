<template>
    <nav aria-label="Page navigation example" class="float-right">
        <ul class="pagination pg-blue">
            <li class="page-item">
                <a href="#" class="page-link" tabindex="-1"
                   v-on:click.prevent="changePage(1)" v-if="pagination.last_page > 5">
                    <span aria-hidden="true"><<</span>
                </a>
            </li>
            <li class="page-item" v-if="pagination.current_page > 1">
                <a href="#" class="page-link" tabindex="-1"
                   v-on:click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true"><</span>
                </a>
            </li>
            <li class="page-item" v-for="page in pagesNumber"
                :class="{'active': page == pagination.current_page}">
                <a href="#" class="page-link" v-on:click.prevent="changePage(page)">{{page}}</a>
            </li>
            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a href="#" class="page-link" v-on:click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">></span>
                </a>
            </li>
            <li class="page-item">
                <a href="#" class="page-link" tabindex="-1"
                   v-on:click.prevent="changePage(pagination.last_page)" v-if="pagination.last_page > 3">
                    <span aria-hidden="true">>></span>
                </a>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    props: {
        pagination: {}
    },
    computed: {
        pagesNumber() {
            var from;
            var pageArray = [];
            if (this.pagination.last_page < 5){
                for (from = 1; from <= this.pagination.last_page; from++){
                    pageArray.push(from);
                }
            }
            else if (this.pagination.current_page <= 3) {
                for (from = 1; from <= 5; from++) {
                    pageArray.push(from);
                }
            }
            else if (this.pagination.current_page >= this.pagination.last_page - 2) {
                for (from =this.pagination.last_page - 4 ; from <= this.pagination.last_page; from++) {
                    pageArray.push(from);
                }
            }
            else
            {
                for (from =this.pagination.current_page - 2 ; from <= this.pagination.current_page + 2; from++) {
                    pageArray.push(from);
                }
            }
            return pageArray;
        }
    },
    methods: {
        changePage(page){
            this.pagination.current_page = page;
        },
    }
}
</script>
