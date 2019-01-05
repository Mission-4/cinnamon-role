<template>
    <div class="card card-default">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>
                Users
            </span>
        </div>

        <div class="card-block">
            <table class="table table-borderless table-striped m-b-none">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="user in users">
                        <td style="vertical-align: middle;" v-text="user.attributes.name"></td>
                        <td style="vertical-align: middle;"><code v-text="user.attributes.email"></code></td>
                        <td style="vertical-align: middle; text-align: right">
                            <button class="btn btn-success m-r-10" @click="editUser(user)">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit User
                        </h4>

                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <!-- Edit User Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="saveUser">

                        <div class="modal-body">
                                <!-- Role -->
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Role</label>

                                    <div class="col-md-7">
                                        <select id="edit-client-name" class="form-control" v-model="editForm.role">
                                            <option v-for="role in roles" :value="role.attributes.id">{{ role.attributes.name }}</option>
                                        </select>
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
            users: [],
            roles: [],
            editForm: {
                errors: [],
                role: null,
                userId: null 
            }
        }),
        methods: {
            editUser(user){
                this.editForm.role = user.attributes.role_id;
                this.editForm.userId = user.id;
                $('#modal-edit-user').modal('show');
            },
            saveUser(){
                CinnamonRole.updateUserRole(this.editForm.userId, this.editForm.role)
                $("#modal-edit-user").modal('hide');
            }
        },
        
        mounted() {
            CinnamonRole.getUsers()
                .then(r => this.users = r)
                .catch(err => console.error(err));

            CinnamonRole.getRoles()
                .then(r => this.roles = r)
                .catch(err => console.error(err));

            $("#modal-edit-user").on('hidden.bs.modal', () => {
                this.editForm.role = null;
                this.editForm.userId = null;
            });

            CinnamonRole.eventBus.$on('updated-users', users => this.users = users);
            CinnamonRole.eventBus.$on('updated-roles', roles => this.roles = roles);
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
