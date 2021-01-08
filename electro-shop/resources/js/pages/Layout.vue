<template>
    <div>
        <!-- Navbar -->
        <the-navbar></the-navbar>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <the-sidebar v-on:user-logout="LogoutUser"></the-sidebar>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <router-view></router-view>
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
        <the-footer></the-footer>
        <!-- /.Main Footer -->
    </div>
</template>

<script>
import TheSidebar from "../components/TheSidebar";
import TheNavbar from "../components/TheNavbar";
import TheFooter from "../components/TheFooter";
export default {
    name: "Layout",
    components: {
        TheSidebar,
        TheNavbar,
        TheFooter,
    },
    methods: {
        LogoutUser(e){
            this.$emit('user-logout', e);
        }
    }
}
</script>

<style scoped>

</style>
