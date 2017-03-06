# Cinnamon Role - Easy Role management for Laravel 5
[![StyleCI](https://styleci.io/repos/83485720/shield?branch=master)](https://styleci.io/repos/83485720)

Cinnamon Role is a simple Role management system built for Laravel 5 with a backend Json Api for easy implementation.

## Feature List: 
- [x] Permissions List
- [x] Roles list
- [x] Users list
- [x] Add Permissions and Roles
- [x] Connect Roles to Permissions
- [x] Connect Users to Roles
- [x] Create Gates for Permissions
- [x] Add Permissions to the `Can` and `Allows` methods
- [x] Easy Backend UI using ajax with Vue.js 2 components

## Installation
Using Composer:
``` bash
composer require mission4/cinnamon-role
```
Then add the service provider to your `config/app.php` providers list.
``` php
Mission4\CinnamonRole\CinnamonRoleServiceProvider::class
```
Add the `Rolable` trait to the `User` model.
``` php
use \Mission4\CinnamonRole\Traits\Rolable;
```
And register your policies in the Route service provider `boot()` method.
``` php
public function boot()
{
    $this->registerPolicies();
    // Register CinnamonRole Permissions Policies
    CinnamonRole::registerPermissions();
}
```

## Using the Vue Components For the UI
Using Laravel Mix.
``` bash
# Publish the Vue Components to the resources/assets/js/vendor/cinnamon-role directory
php artisan vendor:publish --tag=cinnamon-role
```
And add the Vue Components to your `app.js` file and then compile your JavaScript.
``` javascript
Vue.component('cinnamon-role-users-table', require('./components/cinnamon-role/cinnamonRoleUsersTable.vue'));
Vue.component('cinnamon-role-permissions-table', require('./components/cinnamon-role/cinnamonRolePermissionsTable.vue'));
Vue.component('cinnamon-role-roles-table', require('./components/cinnamon-role/cinnamonRoleRolesTable.vue'));
```
Add these to your Blade file that you want to edit roles and permissions on.
``` html
<cinnamon-role-users-table></cinnamon-role-users-table>
<cinnamon-role-permissions-table></cinnamon-role-permissions-table>
<cinnamon-role-roles-table></cinnamon-role-roles-table>
```

## Current Issues
Migrations do not rollback due to Foreign Key Constraints