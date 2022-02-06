<template>
    <div class="main" id="app">
        <div class="rb-container">
            <div class="rb-sidebar">

            </div>
            <div class="rb-content">
                <transition name="fade" mode="out-in">
                    <router-view />
                </transition>
            </div>
        </div>

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
