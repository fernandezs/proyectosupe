<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::get('/', function () {
        return redirect('/home');
    });
    Route::get('/users/datatable', [
        'uses' => 'UsersController@datatables',
        'as' => 'users.datatable'
    ]);
    Route::get('/users/groups/users-group/{id}', [
        'uses' => 'GroupsController@usersGroup',
        'as' => 'groups.usersGroup'
    ]);
    Route::get('/projects/users-group/{id}', [
       'uses' => 'ProjectsController@usersProject',
        'as' => 'projects.usersProject'
    ]);
    Route::get('/users/groups/datatable', [
    'uses' => 'GroupsController@datatable',
    'as' => 'groups.datatable'
    ]);

    Route::get('projects/participan', [
        'uses' => 'ProjectsController@getParticipantes',
        'as' => 'projects.participantes'
    ]);

});

Route::post('/tasks/{id}/comments', [
        'uses' => 'TasksController@insertComment',
        'as' => 'tasks.comment']);
Route::post('comments/{id}/reply', [
        'uses' => 'TasksController@replyComment',
        'as' => 'comments.reply']);
Route::get('projects/datatable', [
    'uses' => 'ProjectsController@datatable',
    'as' => 'projects.datatable'
]);
Route::get('tasks/datatable', [
    'uses' => 'TasksController@datatable',
    'as' => 'tasks.datatable'
]);
Route::get('projects/{slug}/datatable', [
    'uses' => 'TasksController@tasksOfProjects',
    'as' => 'tasks.tasksOfProjects'
]);
Route::get('projects/{slug}/tasks', [
    'uses' => 'TasksController@tasksOfProjectsView',
    'as' => 'tasks.tasksOfProjectsView'
]);

Route::post('tasks/{slug}/addFiles', [
    'uses' => 'FilesController@addFiles',
    'as' => 'tasks.addFiles'
]);
Route::get('storage/download/{file}', [
    'uses' => 'FilesController@downloadFile',
    'as'   => 'file.download']);

Route::get('/profile', [
    'uses' => 'ProfileController@edit',
    'as' => 'profile.edit'
]);
Route::put('/profile/update', [
    'uses' => 'ProfileController@update',
    'as' => 'profile.update'
]);
Route::get('/profile/change-password', [
    'uses' => 'ProfileController@editPassword',
    'as' => 'profile.editPassword'
]);
Route::put('/profile/change-password', [
    'uses' => 'ProfileController@changePassword',
    'as' => 'profile.changePassword'
]);
Route::group(['prefix' => 'users'], function()
{
    Route::resource('groups', 'GroupsController');
    Route::get('/groups/{id}/edit', ['middleware' => 'group:{id}']);

});
Route::auth();

Route::resource('users', 'UsersController');
Route::resource('projects', 'ProjectsController');
Route::resource('tasks', 'TasksController');
Route::get('/home', 'HomeController@getDashboard');

Route::post('/tasks/approve-refuse/{slug}', [
        'uses' => 'TasksController@approveRefuseTask',
        'as'=> 'approveRefuse']);
Route::get('notifications', ['as' => 'notifications.index',
    'uses' => 'NotificationsController@index']);

Route::get('notifications/{id}/read', [
    'uses' => 'NotificationsController@read',
    'as' => 'notifications.read' ]);
Route::get('/users/assign/{slug}/{id}', [
    'uses' => 'ProjectsController@assignShow',
    'as' => 'users.assignShow']);
Route::post('/users/assign/{id}', [
    'uses' => 'ProjectsController@assign',
    'as' => 'users.assign']);


Route::get('/alerts', [
    'uses' => 'TasksController@alerts',
    'as' => 'tasks.alerts']
    );