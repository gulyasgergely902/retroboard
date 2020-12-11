<template>
<div class="main">

        <!-- Stickies list -->
            <div class="card-columns">
                <div class="note-base mr-3 my-3" id="note-base" v-for="sticky in stickies">
                    <div :class="'note-base-actions note'+sticky.sticky_type+'-actions'" id="note-base-header">
                        <div class="btn-group" role="group" aria-label="Sticky actions">
                            <button type="button" id="new-group" class="btn btn-outline-light btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <div :class="'note-base-content note'+sticky.sticky_type+'-content'">
                        {{ sticky.sticky_content }}
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data: function() {
        return {
            groups: [],
            stickies: []
        }
    },

    mounted() {
        this.loadStickies();
        this.loadGroups();
    },

    methods: {
        loadStickies: function() {
            axios.get('/api/stickies')
            .then((response) => {
                this.stickies = response.data;
            })
            .catch(function(error){
                console.log(error);
            });
        },
        loadGroups: function() {
            axios.get('/api/groups')
            .then((response) => {
                this.groups = response.data;
            })
            .catch(function(error){
                console.log(error);
            });
        }
    }
}
</script>