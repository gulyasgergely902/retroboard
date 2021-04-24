<template>
    <div id="app">
        <div id="app-wrapper" :class="(theme === 'darkMode') ? 'dark' : 'light'">
            <div id="nav">
                <p class="top-logo mx-3 my-3"><a class="top-logo-a" @click="goHome()"><img class="header-img" v-if="theme === 'darkMode'" src="./assets/web-logo-light.png"><img class="header-img"  v-else src="./assets/web-logo.png"></a></p>
                <button @click="toggleTheme"><span>Change theme</span></button>
            </div>
            <transition name="fade" mode="out-in">
                <router-view />
            </transition>
        <a class="nav-link bottom pill-bg" :class="(theme === 'darkMode') ? 'pill-dark' : 'pill-light'" href="https://github.com/gulyasgergely902/retroboard/issues">Report bugs on GitHub</a>
        </div>
    </div>
</template>

<script lang="ts">
    import axios from "axios"
    import {ProvideReactive, Component, Vue} from "vue-property-decorator"

    @Component
    export default class App extends Vue {
        theme = '';

        goHome() {
            this.$router.push({
                name: "Index"
            });
        }

        toggleTheme() {
            this.theme = this.theme == 'darkMode' ? 'lightMode' : 'darkMode';
            console.log("theme:" + this.theme);
        }
    }
</script>

<style src="./scss/style.scss" lang="scss" scoped></style>
