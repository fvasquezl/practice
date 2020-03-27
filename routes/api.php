<?php

Route::name('api.')->group(function(){
    Route::Resource('users','Api\UsersController');
 });
