<template>
    <div class="main">
        <div class="fab_wrapper">
            <button class="fab_btn" id="addboard" title="Add new sticky" data-toggle="modal" data-target="#addBoardModal"><i class="fas fa-plus"></i></button>
        </div>

        <!-- Board grid -->
        <h1 class="mx-3 my-3">Active boards</h1>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 mx-3 my-3">
            <div class="col mb-4" v-for="board in boards">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ board.board_name }}</h5>
                        <form class="board-form" :action="'display/'+board.board_id+'/0'" method="GET">
                            <button class="btn btn-success btn-sm" type="submit" title="Open board">Open</button>
                        </form>
                        <form class="board-form">
                            <button class="btn btn-outline-secondary btn-sm" type="submit" title="Export the contents of this board to .csv">Export</button>
                        </form>
                        <form class="board-form">
                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" :data-boardname="board.board_name" :data-bid="board.board_id" title="Delete board">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            boards: []
        }
    },

    mounted() {
        this.loadBoards();
    },

    methods: {
        loadBoards: function() {
            axios.get('/api/boards')
            .then((response) => {
                this.boards = response.data;
            })
            .catch(function(error){
                console.log(error);
            });
        }
    }
}
</script>