<template>
    <div>
        <b-modal id="addBoardModal" title="Create new Board" ok-title="Create" @ok="handleOk">
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                label="Board name"
                label-for="board-name-input"
                >
                <b-form-input
                    id="board-name-input"
                    v-model="board_name"
                    required
                ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>
        <b-skeleton-wrapper :loading="loading">
            <template #loading>
                <masonry
                    :cols="{default: 4, 1400: 3, 1100: 2, 768: 1}"
                    :gutter="10">
                    <div class="col mb-4" v-for="n in 6" :key="n">
                        <b-skeleton width="330px" height="200px" class="load-skeleton mb-4"></b-skeleton>
                    </div>
                </masonry>
            </template>
            <masonry
                :cols="{default: 4, 1400: 3, 1100: 2, 768: 1}"
                :gutter="10">
                <div class="col mb-4" v-for="(board, index) in boards" :key="index">
                    <div class="rb-card" @click="openBoard(board.board_id)">
                        <div class="rb-card-body">
                            <h5 class="card-title">{{board.board_name}}</h5>
                            <button v-on:click.stop @click="confirmDeleteBoard(board.board_id)" type="button" class="btn btn-light btn-rounded delete-form-button" title="Delete board"><font-awesome-icon icon="trash-alt"/></button>
                        </div>
                        <div class="circle"></div>
                    </div>
                </div>
            </masonry>
        </b-skeleton-wrapper>
        
        <vue-fab
            :bg-color="'#077dc7'"
            :z-index="50"
            :main-tooltip="'Add new sticky'"
            v-b-modal.addBoardModal
        ></vue-fab>
    </div>
</template>

<script lang="ts">
import axios from "axios"
import { Component, Inject, ProvideReactive, Vue } from "vue-property-decorator";

@Component({})
export default class Home extends Vue {
    boards: Array<any> = [];
    loading = 0;
    board_name = '';

    async created() {
        document.title = "Home | RetroBoard";
        await this.fetchBoardsData();
    }

    async fetchBoardsData() {
        try {
            this.loading = 1;
            const {data} = await axios.get("/api/boards");
            this.loading = 0;
            this.boards = data;
        } catch(error) {
            console.log(error);
        }
    }

    openBoard(id: string) {
        this.$router.push({
            name: "Board",
            params: {
                id: id
            },
        });
    }

    async createBoard(board_name: string) {
        try{
            await axios.post(`/api/boards`, {
                board_name: board_name
            });
        } catch (error) {
            console.log(error);
        }
        this.fetchBoardsData();
    }

    confirmDeleteBoard(board_id: number) {
        this.$bvModal.msgBoxConfirm('This will delete this board forever! Are you sure?', {
            title: "Delete board",
            okVariant: 'danger',
            okTitle: 'Delete'
        })
        .then(value => {
            if(value) {
                this.deleteBoard(board_id);
            }
        })
        .catch(error => {
            console.log(error);
        })
        
    }

    async deleteBoard(board_id: number) {
        try {
            await axios.delete(`/api/groups/board/${board_id}`);
            await axios.delete(`/api/boards/${board_id}`);
            this.fetchBoardsData();
        } catch (error) {
            console.log(error);
        }
    }

    handleOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleSubmit();
    }

    handleSubmit() {
        this.createBoard(this.board_name);
        this.$nextTick(() => {
            this.$bvModal.hide('addBoardModal')
        });
    }
}
</script>

<style src="../scss/style.scss" lang="scss" scoped></style>
