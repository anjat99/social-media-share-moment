<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\FrontendController;
use \App\Http\Controllers\ContactController;
use \App\Http\Controllers\user\ProfileController;
use \App\Http\Controllers\user\FriendController;
use \App\Http\Controllers\user\AlbumController;
use \App\Http\Controllers\user\PostController;
use \App\Http\Controllers\user\TagController;
use \App\Http\Controllers\user\LocationController;
use \App\Http\Controllers\user\CommentController;
use \App\Http\Controllers\admin\AdminController;
use \App\Http\Controllers\admin\UserController;
use \App\Http\Controllers\admin\CategoryController;
use \App\Http\Controllers\admin\AlbumController as AdminAlbumController;
use \App\Http\Controllers\admin\PostController as AdminPostController;
use \App\Http\Controllers\admin\TagController as AdminTagController;
use \App\Http\Controllers\admin\LocationController as AdminLocationController;
use \App\Http\Controllers\admin\MessageController;
use \App\Http\Controllers\admin\CommentController as AdminCommentController;

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

Route::get('/', function () {
    return view("frontend.pages.auth.login");
});

Route::get('/login/create', [AuthController::class, 'showLoginForm'])->name('login.create');
Route::get("/register/create", [AuthController::class, 'showRegisterForm'])->name('register.create');
Route::POST("/register", [AuthController::class, 'register'])->name("register.store");
Route::POST("/login", [AuthController::class, 'login'])->name("login.store");


//region CONTROLLERS FOR USER MANAGING
Route::prefix('/user')->middleware("isUserLoggedIn")->group(function(){
    Route::get("/logout", [AuthController::class, "logout"])->name("user.logout");

    Route::get('/fetch-stories', [FrontendController::class,'fetchStories'])->name('stories.fetch');
    Route::get('/feed', [FrontendController::class, "index"])->name('user.feed');
    Route::get('/feed-stories/{id}', [PostController::class, "showStory"])->name('user-feed.story');
    Route::resource('/profile', ProfileController::class);
    Route::get('/user-friends/{id}',[FriendController::class, 'userFriends'])->name('userFriends');
    Route::get('/user/friends/{id}',[FriendController::class, 'getFriends'])->name('friend.friends');
    Route::get('/people/search', [FriendController::class, 'search'])->name('people.search');
    Route::POST('/addFriend',[FriendController::class, 'addFriend'])->name('addFriend');

    Route::put('/report-user/{id}', [FriendController::class,'reportUser'])->name('report-user');
    Route::put('/cancel-report-user/{id}', [FriendController::class,'cancelReport'])->name('cancel-report-user');
    Route::POST('/follow-user/{id}', [FriendController::class,'followUser'])->name('follow-user');
    Route::delete('/unfollow-user/{id}', [FriendController::class,'unfollowUser'])->name('unfollow-user');

    Route::put('/report-comment/{id}', [CommentController::class,'reportComment'])->name('report-comment');
    Route::put('/cancel-comment-user/{id}', [CommentController::class,'cancelReportComment'])->name('cancel-report-comment');


    Route::get('/change-password/{id}/edit', [ProfileController::class, "formChangePassword"])->name('change-password.edit');
    Route::put('/change-password/{id}', [ProfileController::class, "changePassword"])->name('change-password.update');

    Route::get('/api/album-manage', [AlbumController::class, 'getAll'])->name('album-manage.fetch');
    Route::resource('/albums', AlbumController::class);
    Route::get('/album-create/{id}', [AlbumController::class,"createAlbum"])->name('album-create');

    Route::get('/filter-stories', [PostController::class, "filterStories"])->name('stories.filter');
    Route::resource('/stories', PostController::class);

    Route::get('/api-stories/{id}', [PostController::class,"showMyStory"])->name("story");
    Route::resource('/tags', TagController::class);
    Route::resource('/locations', LocationController::class);
    Route::get('/society-search', [FrontendController::class, 'search'])->name('society.search');
    Route::get('/society', [FrontendController::class, 'showAllUsers'])->name('society');
    Route::get('/society/{id}', [FrontendController::class, 'showUserProfile'])->name('society.profile');
    Route::resource('/friends', FriendController::class);
    Route::get('/shared-stories', [FriendController::class, "getSharedStories"])->name('friends.stories');
    Route::resource('/comments', CommentController::class);

    Route::resource('/contact', ContactController::class);
});
//endregion

//region CONTROLLERS FOR ADMIN MANAGING
Route::prefix('/admin')->middleware("isAdminLoggedIn")->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/activities-filter', [AdminController::class, 'filterByDate'])->name('activities-filter');
    Route::get("/logout", [AdminController::class, "logout"])->name("admin.logout");
    Route::resource('/users', UserController::class);
    Route::put('/block-user/{id}', [UserController::class,'blockUser'])->name('block-user');
    Route::put('/unblock-user/{id}', [UserController::class,'unblockUser'])->name('unblock-user');
    Route::get('/api/categories-manages', [CategoryController::class, 'getAll'])->name('categories.fetch');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/albums-manage', AdminAlbumController::class);
    Route::resource('/stories-manage', AdminPostController::class);
    Route::put('/approve-story/{id}', [AdminPostController::class,'approveStory'])->name('approve-story');
    Route::get('/api/tags-manages', [AdminTagController::class, 'getAll'])->name('tags-manage.fetch');
    Route::resource('/tags-manage', AdminTagController::class);
    Route::get('/api/location-manages', [AdminLocationController::class, 'getAll'])->name('location-manage.fetch');
    Route::resource('/locations-manage', AdminLocationController::class);
    Route::get('/api/messages-manages', [MessageController::class, 'getAll'])->name('messages-manage.fetch');
    Route::resource('/messages', MessageController::class);
    Route::resource('/comments-manage', AdminCommentController::class);
});
//endregion
