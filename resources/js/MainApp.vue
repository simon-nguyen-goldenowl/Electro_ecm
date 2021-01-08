<template>
    <div>
        <!-- Navbar -->
        <the-navbar v-if="token !== null"></the-navbar>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <the-sidebar v-if="token !== null" v-on:user-logout="userLogout"></the-sidebar>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <router-view v-on:user-login="userLogin"></router-view>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <the-footer v-if="token !== null"></the-footer>
        <!-- /.Main Footer -->
    </div>
</template>

<script>
import TheSidebar from "./components/TheSidebar";
import TheNavbar from "./components/TheNavbar";
import TheFooter from "./components/TheFooter";
export default {
    name: "Layout",
    components: {
        TheSidebar,
        TheNavbar,
        TheFooter,
    },
    data(){
        return{
            token: null
        }
    },
    created() {
        this.token = this.$cookies.get('token');
    },
    methods: {
        userLogin(e){
            this.token = this.$cookies.get('token');
            console.log(this.token);
            console.log(this.$cookies.get('token'));
        },
        userLogout(e){
            this.token = e;
        }
    }
}
</script>

<style scoped>
</style>
