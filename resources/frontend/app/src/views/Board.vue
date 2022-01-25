<template>
    <div>
        <b-modal id="addStickyModal" title="Create new Sticky" ok-title="Create" @ok="handleAddOk">
            <form ref="form" @submit.stop.prevent="handleAddSubmit">
                <b-form-group
                label="Sticky content"
                label-for="sticky-content-input"
                >
                    <b-form-textarea
                        id="sticky-content-input"
                        v-model="sticky_content"
                        required
                    ></b-form-textarea>
                </b-form-group>
                <hr>
                <b-form-group
                label="Sticky group"
                label-for="sticky-group-input"
                >
                    <b-form-select
                        id="sticky-group-input"
                        v-model="sticky_group"
                        :options="groups"
                        value-field="group_id"
                        text-field="group_name"
                    >
                        <option value=-1>Ungrouped</option>
                    </b-form-select>
                </b-form-group>
            </form>
        </b-modal>
        <b-modal id="addLinkedActionItemModal" title="Create linked action item" ok-title="Create" @ok="handleLinkOk">
            <form ref="form" @submit.stop.prevent="handleLinkActionItemSubmit">
                <b-form-group
                label="Sticky content"
                label-for="action-item-content-input"
                >
                <b-form-input
                    id="action-item-content-input"
                    v-model="linked_action_item_content"
                    required
                ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>
        <b-modal id="moveStickyModal" title="Move sticky to .." ok-title="Move" @ok="handleMoveOk">
            <form ref="form" @submit.stop.prevent="handleMoveSubmit">
                <b-form-group
                label="Where to move"
                label-for="sticky-target-input"
                >
                <b-form-select
                    id="sticky-target-input"
                    v-model="sticky_target"
                    :options="sticky_types"
                    required
                ></b-form-select>
                </b-form-group>
            </form>
        </b-modal>
        <b-modal id="groupStickyModal" title="Groups" ok-title="Add" @ok="handleGroupOk">
            <form ref="form" @submit.stop.prevent="handleGroupSubmit">
                <b-form-group
                label="Assign a group.."
                label-for="sticky-group-input"
                >
                <b-form-select
                    id="sticky-group-input"
                    v-model="sticky_group_target"
                    :options="groups"
                    value-field="group_id"
                    text-field="group_name"
                    required
                ></b-form-select>
                </b-form-group>
            </form>
            <button v-on:click.stop v-b-modal.addGroupModal class="btn btn-primary btn-sm btn-circle">Create new group</button>
        </b-modal>
        <b-modal id="addGroupModal" title="Create new Group" ok-title="Create" @ok="handleCreateGroupOk">
            <form ref="form" @submit.stop.prevent="handleAddSubmit">
                <b-form-group
                label="Group name"
                label-for="group-name-input"
                >
                <b-form-input
                    id="group-name-input"
                    v-model="group_name"
                    required
                ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>
        <div class="header-buttons mx-3 mt-5 clearfix">
            <a @click="fetchStickyData(0)" class="rounded-button" :class="current_sticky_type == 0 ? 'note0 rounded-button-selected' : '' " title="Went Well"><font-awesome-icon icon="thumbs-up"/></a>
            <a @click="fetchStickyData(2)" class="rounded-button" :class="current_sticky_type == 2 ? 'note2 rounded-button-selected' : '' " title="Needs Improvement"><font-awesome-icon icon="thumbs-down"/></a>
            <a @click="fetchStickyData(1)" class="rounded-button" :class="current_sticky_type == 1 ? 'note1 rounded-button-selected' : '' " title="Action Item"><font-awesome-icon icon="exclamation"/></a>
            <p class="header-spacer">|</p>
            <a @click="toggleVisibility()" class="rounded-button" :class="visibility == 1 ? 'note0 rounded-button-selected' : '' " title="Show / Hide stickies"><font-awesome-icon v-if="visibility == 0" icon="eye-slash"/><font-awesome-icon v-if="visibility == 1" icon="eye"/></a>
            <transition name="fade" mode="out-in">
                <b-spinner small v-if="loading" label="Spinning"></b-spinner>
                <font-awesome-icon v-else icon="check-circle"/>
            </transition>
            <a @click="confirmClearBoard()" class="rounded-button danger-button float-right" title="Delete All"><font-awesome-icon icon="trash-alt"/></a>
        </div>
        <a @click="toggleMobileMenu()" class="rounded-button mobile-menu-toggle mx-3 mt-1" title="Show menu"><font-awesome-icon icon="bars"/></a>
        <transition name="fade">
            <div v-if="mobile_menu_visibility" class="mobile-menu" id="mobile-menu">
                <a @click="fetchStickyData(0)" class="rounded-button mobile-menu-button" :class="current_sticky_type == 0 ? 'note0 rounded-button-selected' : '' " title="Went Well"><font-awesome-icon icon="thumbs-up"/></a>
                <a @click="fetchStickyData(2)" class="rounded-button mobile-menu-button" :class="current_sticky_type == 2 ? 'note2 rounded-button-selected' : '' " title="Needs Improvement"><font-awesome-icon icon="thumbs-down"/></a>
                <a @click="fetchStickyData(1)" class="rounded-button mobile-menu-button" :class="current_sticky_type == 1 ? 'note1 rounded-button-selected' : '' " title="Action Item"><font-awesome-icon icon="exclamation"/></a>
                <hr>
                <a @click="toggleVisibility()" class="rounded-button mobile-menu-button" :class="visibility == 1 ? 'note0 rounded-button-selected' : '' " title="Show / Hide stickies"><font-awesome-icon v-if="visibility == 0" icon="eye-slash"/><font-awesome-icon v-if="visibility == 1" icon="eye"/></a>
                <a @click="confirmClearBoard()" class="rounded-button mobile-menu-button danger-button" title="Delete All"><font-awesome-icon icon="trash-alt"/></a>
            </div>
        </transition>
        <div class="tagline mx-3">
            <span class="tag" @click="fetchStickyData(current_sticky_type)">
                #All
            </span>
            <span class="tag" @click="fetchGroupStickies(current_sticky_type, -1)">
                #Ungrouped
            </span>
            <span class="tag" @click="fetchGroupStickies(current_sticky_type, groupItem.group_id)" v-for="(groupItem, index) in groups" :key="index">
                #{{groupItem.group_name}}
            </span>
            <span class="tag" v-b-modal.addGroupModal><font-awesome-icon icon="plus"/></span>
        </div>
        <transition name="fade" mode="out-in">
            <div v-if="visibility" class="py-3 px-5 mt-2 mb-5">
                <masonry
                    :cols="{default: 6, 1200: 5, 992: 4, 768: 3, 576: 2, 450: 1}"
                    :gutter="15">
                    <div @click="editSticky()" v-for="(sticky, index) in stickies" :key="index" :class="'note' + sticky.sticky_type" class="note-base mr-3 my-3">
                        <div class="upper-shadow hover-display"></div>
                        <div class="sticky-menu hover-display">
                            <button v-on:click.stop v-b-modal.addLinkedActionItemModal @click="setCurrentStickyID(sticky.sticky_id);setCurrentStickyContent(sticky.sticky_content)" v-if="sticky.sticky_type == 0 || sticky.sticky_type == 2" title="Create linked action item" class="btn btn-light btn-sm btn-circle" :class="'btn-color-' + sticky.sticky_type"><font-awesome-icon icon="link"/></button>
                            <button v-on:click.stop v-b-modal.moveStickyModal @click="setCurrentStickyID(sticky.sticky_id)" title="Move to other type" class="btn btn-light btn-sm btn-circle" :class="'btn-color-' + sticky.sticky_type"><font-awesome-icon icon="dolly"/></button>
                            <button v-on:click.stop v-b-modal.groupStickyModal @click="setCurrentStickyID(sticky.sticky_id)" title="Add to group" class="btn btn-light btn-sm btn-circle" :class="'btn-color-' + sticky.sticky_type"><font-awesome-icon icon="layer-group"/></button>
                            <button v-on:click.stop @click="confirmDeleteSticky(sticky.sticky_id)" title="Delete" class="btn btn-light btn-sm delete-sticky-button btn-circle" :class="'btn-color-' + sticky.sticky_type"><font-awesome-icon icon="trash-alt"/></button>
                        </div>
                        <div v-if="sticky.linked_sticky != 0 && sticky.sticky_type == 1" class="linked-sticky-reference">
                            {{sticky.linked_content}}
                        </div>
                        <div class="note-base-content">
                            {{sticky.sticky_content}}
                        </div>
                        <div v-if="sticky.group_id > 0" class="group-tag-container">
                            <span class="group-tag">#{{ getGroupNameForId(sticky.group_id) }}</span>
                            <font-awesome-icon icon="trash-alt" class="button-icon ml-2" @click="removeStickyFromGroup(sticky.sticky_id, sticky.group_id)"/>
                        </div>
                    </div>
                </masonry>
            </div>
            <font-awesome-icon class="nothing-visible-icon" v-else icon="eye-slash"/>
        </transition>
        <vue-fab
            :bg-color="fab_color"
            :z-index="50"
            :main-tooltip="'Add new sticky'"
            v-b-modal.addStickyModal
        ></vue-fab>
    </div>
</template>

<script lang="ts">
import axios from "axios"
import { Component, Inject, InjectReactive, Vue } from "vue-property-decorator"

@Component({})
export default class Board extends Vue {
    stickies: Array<any> = [];
    filtered_stickies: Array<any> = [];
    groups: Array<any> = [];
    current_sticky_type = 0;
    current_sticky_id = 0;
    visibility = 0;
    mobile_menu_visibility = 0;
    loading = 0;
    fab_color="#14a22c";
    sticky_content = '';
    sticky_group = -1;
    sticky_types = [{text: 'Went well', value: 0}, {text: 'Needs improvement', value: 2}, {text: 'Action item', value: 1}];
    sticky_target = '';
    sticky_group_target = 0;
    linked_action_item_content = '';
    current_sticky_content = '';
    group_name = '';

    async created() {
        document.title = "Board | RetroBoard";
        await this.fetchGroupData();
        await this.fetchStickyData(0);
    }

    async fetchStickyData(sticky_type: number) {
        try {
            this.loading = 1;
            const {data} = await axios.get(`/api/stickies/${this.$route.params.id}/${sticky_type}`);
            this.loading = 0;
            this.stickies = data;
            this.setFabColor(sticky_type);
            this.current_sticky_type = sticky_type;
        } catch(error) {
            console.log(error);
        }
    }

    async fetchGroupStickies(sticky_type: number, group: number) {
        try {
            this.loading = 1;
            const {data} = await axios.get(`/api/stickies/${this.$route.params.id}/${sticky_type}/${group}`);
            this.loading = 0;
            this.stickies = data;
            this.setFabColor(sticky_type);
            this.current_sticky_type = sticky_type;
        } catch(error) {
            console.log(error);
        }
    }

    async fetchGroupData() {
        try {
            const {data} = await axios.get(`/api/groups/${this.$route.params.id}`);
            this.groups = data;
        } catch(error) {
            console.log(error);
        }
    }

    setCurrentStickyID(id: number) {
        this.current_sticky_id = id;
    }

    setCurrentStickyContent(content: string) {
        this.current_sticky_content = "\"" + content.substring(0, 60) + "...\"";
    }

    setFabColor(sticky_type: number){
        if(sticky_type == 0) {
            this.fab_color = "#14a22c";
        } else if(sticky_type == 1) {
            this.fab_color = "#ffc600";
        } else if(sticky_type == 2) {
            this.fab_color = "#ff4800";
        } else {
            this.fab_color = "#055bb0";
        }
    }

    toggleVisibility() {
        if(this.visibility) {
            this.visibility = 0;
        } else {
            this.visibility = 1;
        }
    }

    async deleteSticky(sticky_id: number) {
        try {
            await axios.delete(`/api/stickies/${sticky_id}`);
            this.fetchStickyData(this.current_sticky_type);
        } catch (error) {
            console.log(error);
        }
    }

    confirmClearBoard(sticky_id: number) {
        this.$bvModal.msgBoxConfirm('This will delete all sticky on this board forever! Are you sure?', {
            title: "Clear board",
            okVariant: 'danger',
            okTitle: 'Clear'
        })
        .then(value => {
            if(value) {
                this.clearBoard();
            }
        })
        .catch(error => {
            console.log(error);
        })
    }

    async clearBoard() {
        try {
            await axios.delete(`/api/groups/board/${this.$route.params.id}`);
            await axios.delete(`/api/stickies/board/${this.$route.params.id}`);
            this.fetchStickyData(this.current_sticky_type);
            this.fetchGroupData();
        } catch (error) {
            console.log(error);
        }
    }

    toggleMobileMenu() {
        if(this.mobile_menu_visibility) {
            this.mobile_menu_visibility = 0;
        } else {
            this.mobile_menu_visibility = 1;
        }
    }

    confirmDeleteSticky(sticky_id: number) {
        this.$bvModal.msgBoxConfirm('This will delete this sticky forever! Are you sure?', {
            title: "Delete sticky",
            okVariant: 'danger',
            okTitle: 'Delete'
        })
        .then(value => {
            if(value) {
                this.deleteSticky(sticky_id);
            }
        })
        .catch(error => {
            console.log(error);
        })
    }

    handleAddOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleAddSubmit();
    }

    async handleAddSubmit() {
        try{
            await axios.post(`/api/stickies`, {
                sticky_content: this.sticky_content,
                bid: this.$route.params.id,
                sticky_type: this.current_sticky_type,
                sticky_group: this.sticky_group
            });
            this.sticky_content = "";
            this.sticky_group = -1;
        } catch (error) {
            console.log(error);
        }
        this.fetchStickyData(this.current_sticky_type);
        this.$nextTick(() => {
            this.$bvModal.hide('addStickyModal')
        });
    }

    handleMoveOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleMoveSubmit();
    }

    async handleMoveSubmit() {
        try {
            await axios.post(`/api/stickies/move`, {
                to: this.sticky_target,
                which: this.current_sticky_id
            });
            this.fetchStickyData(this.current_sticky_type);
        } catch (error) {
            console.log(error);
        }
        this.$nextTick(() => {
            this.$bvModal.hide('moveStickyModal')
        });
    }

    editSticky() {
        console.log("Would you like an edit feature to be implemented? Report it on github!");
    }

    handleLinkOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleLinkActionItemSubmit();
    }

    async handleLinkActionItemSubmit() {
        try{
            await axios.post(`/api/stickies/link`, {
                sticky_content: this.linked_action_item_content,
                bid: this.$route.params.id,
                sticky_type: 1,
                linked_sticky: this.current_sticky_id,
                linked_content: this.current_sticky_content
            });
        } catch (error) {
            console.log(error);
        }
        this.fetchStickyData(this.current_sticky_type);
        this.$nextTick(() => {
            this.$bvModal.hide('addLinkedActionItemModal')
        });
    }

    handleGroupOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleGroupSubmit();
    }

    async handleGroupSubmit(func: any = 0) {
        try {
            await axios.post(`/api/stickies/assignToGroup`, {
                to: this.sticky_group_target,
                which: this.current_sticky_id
            });
            this.fetchStickyData(this.current_sticky_type);
        } catch (error) {
            console.log(error);
        }
        if(func == 0) {
            this.$nextTick(() => {
                this.$bvModal.hide('groupStickyModal')
            });
        }
        
    }

    handleCreateGroupOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleCreateGroupSubmit();
    }

    async handleCreateGroupSubmit() {
        try{
            await axios.post(`/api/groups`, {
                group_name: this.group_name,
                bid: this.$route.params.id,
                sticky_type: this.current_sticky_type
            });
            this.group_name = "";
        } catch (error) {
            console.log(error);
        }
        this.fetchGroupData();
        this.$nextTick(() => {
            this.$bvModal.hide('addGroupModal')
        });
    }

    getGroupNameForId(id: number): string {
        let gn = "";
        Array.from(this.groups).forEach(groupItem => {
            if(groupItem.group_id == id) {
                gn = groupItem.group_name;
            }
        })

        return gn;
    }

    removeStickyFromGroup(sticky_id: number) {
        this.sticky_group_target = -1;
        this.current_sticky_id = sticky_id;
        this.handleGroupSubmit(1);
    }
}
</script>

<style src="../scss/style.scss" lang="scss" scoped>
