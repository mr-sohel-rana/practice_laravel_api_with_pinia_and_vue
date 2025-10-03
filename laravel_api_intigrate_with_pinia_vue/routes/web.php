<?php

use Illuminate\Support\Facades\Route;
 

// যদি কোন API বা অন্য route না হয়, সব request Vue app কে দিন
Route::get('/{any?}', function () {
    return view('welcome'); // Vue mount point
})->where('any', '.*');

