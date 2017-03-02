// export bus (new Vue());

export default {
	eventBus: new Vue(),
	permissions: null,
	users: null,
	roles: null,
	updatedPermissions(){
		this.eventBus.$emit('updated-permissions', this.permissions);
	},
	updatedRoles(){
		this.eventBus.$emit('updated-roles', this.roles);
	},
	updatedUsers(){
		this.eventBus.$emit('updated-users', this.users);
	},
	getPermissions(){
		return new Promise((resolve, reject) => {
			if(this.permissions){
				return resolve(this.permissions);
			}

			axios.get('/api/cinnamonrole/permissions')
				.then(r => {
					this.permissions = r.data.data;
					resolve(this.permissions);
				})
				.catch(err => console.error(err))
		});
	},
	updatePermission(permissionId, attributes){
		axios.patch('/api/cinnamonrole/permissions/' + permissionId, {
			data: {
				id: permissionId,
				attributes: attributes
			}
		})
			.then(r => {
				let permissionIndex = this.permissions.findIndex(permission => {
					return permission.id == r.data.data.id;
				});
				this.permissions[permissionIndex] = r.data.data;
				this.updatedPermissions();
			})
			.catch(err => console.error(err));
	},
	storePermission(attributes){
		axios.post('/api/cinnamonrole/permissions', {
			data: {
				attributes: attributes
			}
		})
			.then(r => {
				this.permissions.push(r.data.data);
				
				this.updatedPermissions();
			})
			.catch(err => console.error(err));
	},
	deletePermission(permissionId){
		axios.delete('/api/cinnamonrole/permissions/' + permissionId)
			.then(r => {
				let thePermission = this.permissions.find(r => r.id == permissionId);
				this.permissions = _.without(this.permissions, thePermission);
				
				this.updatedPermissions();
			})
			.catch(err => console.error(err));
	},
	getRoles(){
		return new Promise((resolve, reject) => {
			if(this.roles){
				return resolve(this.roles);
			}

			axios.get('/api/cinnamonrole/roles')
				.then(r => {
					this.roles = r.data.data;
					resolve(this.roles);
				})
				.catch(err => console.error(err))
		});
	},
	deleteRole(roleId){
    	axios.delete('/api/cinnamonrole/roles/' + roleId)
        	.then(r => {
        		let theRole = this.roles.find(r => r.id == roleId);
        		this.roles = _.without(this.roles, theRole);

        		this.updatedRoles();
        	})
        	.catch(err => console.error(err))
	},
	createRoleWithPermissions(permissions, attributes){
		permissions = permissions.map(permission => {
			return {
				id: permission,
				type: "permissions"
			};
		});

		let payload = {
			data: {
				"type": "roles",
				"attributes": attributes,
				"relationships": {
					"permissions": {
						"data": permissions
					}
				}
			}
		};

    	axios.post('/api/cinnamonrole/roles', payload)
        	.then(r => {
        		let newRole = r.data.data;
        		this.roles.push(r.data.data);
        		this.updatedRoles();
        	})
        	.catch(err => console.error(err))
	},
	updateRolePermissions(roleId, permissions, attributes){
		permissions = permissions.map(permission => {
			return {
				id: permission,
				type: "permissions"
			};
		});

		let payload = {
			data: {
				"id": roleId,
				"type": "roles",
				"attributes": attributes,
				"relationships": {
					"permissions": {
						"data": permissions
					}
				}
			}
		};

    	axios.patch('/api/cinnamonrole/roles/' + roleId, payload)
        	.then(r => {
        		let updatedRole = this.roles.findIndex(role => {
        			return role.id == r.data.data.id;
        		});
        		this.roles[updatedRole] = r.data.data;
        		this.updatedRoles();
        	})
        	.catch(err => console.error(err))
	},
	getUsers(){
		return new Promise((resolve, reject) => {
			if(this.users){
				return resolve(this.users);
			}

			axios.get('/api/cinnamonrole/users')
				.then(r => {
					this.users = r.data.data;
					resolve(this.users);
				})
				.catch(err => console.error(err))
		});
	},
	updateUserRole(userId, roleId){
		let payload = {
            id: userId,
            type: "users",
            relationships: {
                role: {
                    data: {
                        id: roleId,
                        type: "roles"
                    }
                }
            }
        };

    	axios.patch('/api/cinnamonrole/users/' + userId, {data: payload})
        	.then(r => {
        		let updatedUser = this.users.findIndex(user => {
        			return user.id == r.data.data.id;
        		});
        		this.users[updatedUser] = r.data.data;
        		this.updatedUsers();
        	})
        	.catch(err => console.error(err))
	}
}