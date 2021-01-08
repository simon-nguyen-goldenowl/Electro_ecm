<template>
    <div class="NotFound">
        <v-container>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card height="400" color="transparent" flat>
                        <div class="display-3 mt-5"> 404| <b>PAGE NOT FOUND.</b></div>
                        <div class="grey--text lighten-5">
                            The page you are trying to get to never existed in this reality,
                            or has migrated to a parallel universe.
                        </div>
                        <div class="paragraph-text mt-2">
                            <br />
                            <br />Try going back to <router-link to="/">home page</router-link> and repeating your action. Or,
                            contact IT helpdesk for support.
                        </div>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
export default {
    name: "PageNotFound"
}
</script>

<style scoped>

</style>
