<template>
    <div id="app">
        <div id="nav">
            <p class="top-logo mx-3 my-3"><a class="top-logo-a" @click="goHome()"><img class="header-img" src="./assets/web-logo.png"></a></p>
        </div>
        <transition name="fade" mode="out-in">
            <router-view />
        </transition>
        <a class="nav-link bottom pill-bg" href="https://github.com/gulyasgergely902/retroboard/issues">Report bugs on GitHub</a>
    </div>
</template>

<script lang="ts">
    import axios from "axios"
    import {ProvideReactive, Component, Vue} from "vue-property-decorator"

    @Component
    export default class App extends Vue {
        goHome() {
            this.$router.push({
                name: "Index"
            });
        }
    }
</script>

<style src="./scss/style.scss" lang="scss" scoped></style>
