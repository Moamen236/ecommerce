<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if(config('app.admin_routes_enabled'))
    include 'adminRoutes.php';

if(config('app.user_routes_enabled'))
    include 'userRoutes.php';