<template>
    <div class="panel panel-default">
        <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
            <span>
                Permissions
            </span>
            <a class="action-link" @click="createPermission()">
                Create New Permission
            </a>
        </div>

        <div class="panel-body">
            <table class="table table-borderless m-b-none">
                <thead>
                    <tr>
                        <th>Permission Name</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="permission in permissions">
                        <td style="vertical-align: middle;" v-text="permission.attributes.name"></td>
                        <td style="vertical-align: middle;"><code v-text="permission.attributes.slug"></code></td>
                        <td style="vertical-align: middle; text-align: right">
                            <button class="btn btn-success m-r-10" @click="editPermission(permission)">Edit</button>
                            <button class="btn btn-danger" @click="deletePermission(permission)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Edit Permission Modal -->
        <div class="modal fade" id="modal-edit-permission" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="activePermission">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Permission
                        </h4>
                    </div>

                    <!-- Edit User Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="savePermission">

                        <div class="modal-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="activePermission.attributes.name">
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Slug</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="activePermission.attributes.slug">
                                </div>
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary" >
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <!-- Create Permission Modal -->
        <div class="modal fade" id="modal-create-permission" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="activePermission">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Create Permission
                        </h4>
                    </div>

                    <!-- Edit User Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="storePermission">

                        <div class="modal-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="activePermission.attributes.name">
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Slug</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="activePermission.attributes.slug">
                                </div>
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary" >
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CinnamonRole from './CinnamonRole';
    export default {
        data: ()=>({
            permissions: [],
            activePermission: null
        }),
        methods: {
            editPermission(permission){
                this.activePermission = permission;
                $("#modal-edit-permission").modal('show');
            },
            createPermission(){
                this.activePermission = {
                    attributes: {
                        name: null,
                        slug: null
                    }
                };

                $("#modal-create-permission").modal('show');
            },
            savePermission(){
                CinnamonRole.updatePermission(this.activePermission.id, this.activePermission.attributes);
                $("#modal-edit-permission").modal('hide');
            },
            storePermission(){
                CinnamonRole.storePermission(this.activePermission.attributes);
                $("#modal-create-permission").modal('hide');
            },
            deletePermission(permission){
                CinnamonRole.deletePermission(permission.id);
            },
        },
        mounted() {
            CinnamonRole.getPermissions()
                .then(r => this.permissions = r)
                .catch(err => console.error(err));

            CinnamonRole.eventBus.$on('updated-permissions', p => this.permissions = p);
        }
    }
</script>

<style scoped>
    .m-b-none{
        margin-bottom: 0;
    }
    .m-r-10{
        margin-right: 10px;
    }
    .action-link{ cursor: pointer; }
</style>
