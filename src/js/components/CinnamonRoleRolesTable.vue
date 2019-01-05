<template>
    <div class="card card-default">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>
                Roles
            </span>
            <a class="action-link" @click="makeRole">
                Create New Role
            </a>
        </div>

        <div class="card-block">
            <table class="table table-borderless table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="role in roles">
                        <td style="vertical-align: middle;" v-text="role.attributes.name"></td>
                        <td style="vertical-align: middle;"><code v-text="role.attributes.slug"></code></td>
                        <td style="vertical-align: middle; text-align: right">
                            <button class="btn btn-success m-r-10" @click="editRole(role)">Edit</button>
                            <button class="btn btn-danger" @click="deleteRole(role)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Edit Role Modal -->
        <div class="modal fade" id="modal-edit-role" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="activeRole">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit Role
                        </h4>

                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <!-- Edit User Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="saveRole">

                        <div class="modal-body">
                                <!-- Name -->
                                <div class="form-group row">
                                    <label class="col-md-3 text-right col-form-label">Name</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control" v-model="activeRole.attributes.name">
                                    </div>
                                </div>

                                <!-- Slug -->
                                <div class="form-group row">
                                    <label class="col-md-3 text-right col-form-label">Slug</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control" v-model="activeRole.attributes.slug">
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="form-group row">
                                    <label class="col-md-3 text-right col-form-label">Permissions</label>

                                    <div class="col-md-7">
                                        <div class="checkbox" v-for="permission in permissions">
                                            <label>
                                                <input type="checkbox" name="permissions[]" v-model="activePermissions" :value="permission.id"> {{ permission.attributes.name }}
                                            </label>
                                        </div>
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


        <!-- Create Role Modal -->
        <div class="modal fade" id="modal-create-role" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="activeRole">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create Role
                        </h4>

                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <!-- Edit User Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="createRole">

                        <div class="modal-body">
                                <!-- Name -->
                                <div class="form-group row">
                                    <label class="col-md-3 text-right col-form-label">Name</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control" v-model="activeRole.attributes.name">
                                    </div>
                                </div>

                                <!-- Slug -->
                                <div class="form-group row">
                                    <label class="col-md-3 text-right col-form-label">Slug</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control" v-model="activeRole.attributes.slug">
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="form-group row">
                                    <label class="col-md-3 text-right col-form-label">Permissions</label>

                                    <div class="col-md-7">
                                        <div class="checkbox" v-for="permission in permissions">
                                            <label>
                                                <input type="checkbox" name="permissions[]" v-model="activePermissions" :value="permission.id"> {{ permission.attributes.name }}
                                            </label>
                                        </div>
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
            roles: [],
            permissions: [],
            activeRole: null,
            activePermissions: []
        }),
        methods: {
            editRole(role){
                this.activeRole = role;
                this.activePermissions = role.relationships.permissions.data.map(p => p.id);
                $('#modal-edit-role').modal('show');
            },
            makeRole(){
                this.activeRole = {
                    attributes: {
                        name: null,
                        slug: null
                    }
                };
                this.activePermissions = [];
                $('#modal-create-role').modal('show');
            },
            hasPermission(role, permission){
                let permissions = role.relationships.permissions.data;
                return permissions.find(per => per.id == permission.id);
            },
            saveRole(){
                CinnamonRole.updateRolePermissions(this.activeRole.id, this.activePermissions, this.activeRole.attributes);
                $('#modal-edit-role').modal('hide');
            },
            createRole(){
                CinnamonRole.createRoleWithPermissions(this.activePermissions, this.activeRole.attributes);
                $('#modal-create-role').modal('hide');
            },
            deleteRole(role){
                CinnamonRole.deleteRole(role.id);
            }
        },
        mounted() {
            CinnamonRole.getRoles()
                .then(r => this.roles = r)
                .catch(err => console.error(err));
            CinnamonRole.getPermissions()
                .then(r => this.permissions = r)
                .catch(err => console.error(err));

            $('#modal-edit-role').on('hidden.bs.modal', () => {
                this.activePermissions = [];
                this.activeRole = null;
            });

            $('#modal-create-role').on('hidden.bs.modal', () => {
                this.activePermissions = [];
                this.activeRole = null;
            });

            CinnamonRole.eventBus.$on('updated-roles', r => this.roles = r);
            CinnamonRole.eventBus.$on('updated-permissions', r => this.permissions = r);
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
