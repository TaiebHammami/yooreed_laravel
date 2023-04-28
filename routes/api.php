<?php

use App\Http\Controllers\Auth\PasswordForgotController;
use App\Http\Controllers\Auth\PasswordVerifyPinController;
use App\Http\Controllers\Auth\UserGetController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Firebase\UserFcmTokenController;
use App\Http\Controllers\GouverneratGetController;
use App\Http\Controllers\Notification\AdherentNotificationController;
use App\Http\Controllers\Notification\PartenaireNotificationController;
use App\Http\Controllers\Notification\PartenaireRegisterNotificationController;
use App\Http\Controllers\OfferAdmin\AdminCreateController;
use App\Http\Controllers\Offre\Favorite\FavoriteAddController;
use App\Http\Controllers\Offre\Favorite\FavoriteDeleteController;
use App\Http\Controllers\Offre\Favorite\FavoriteUserController;
use App\Http\Controllers\Offre\Like\AdherentAddLikeController;
use App\Http\Controllers\Offre\Like\AdherentDislikeController;
use App\Http\Controllers\Offre\Like\UsersLikesController;
use App\Http\Controllers\Offre\OffreByPartenaireController;
use App\Http\Controllers\Offre\OffreCreateController;
use App\Http\Controllers\Offre\OffreFindController;
use App\Http\Controllers\OfferAdmin\AdminAcceptController;
use App\Http\Controllers\OfferAdmin\AdminRefuseController;
use App\Http\Controllers\Offre\PartenaireDeleteOfferController;
use App\Http\Controllers\PartenaireListController;
use App\Http\Controllers\Secteur\SecteurGetController;
use App\Http\Controllers\Secteur\SecteurGetPartenaireController;
use App\Http\Controllers\VillesGetController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\UserRegisterController;
use \App\Http\Controllers\Auth\UserLoginController;
use \App\Http\Controllers\Auth\UserLogoutController;
use \App\Http\Controllers\Auth\UserResetPasswordController;
use \App\Http\Controllers\Offre\OffresListController;

Route::prefix('/auth')->group(function () {
    //Public AUTH Routes
    Route::post('/login', UserLoginController::class);
    Route::post('/register', UserRegisterController::class);
    ///
    Route::post('/verify-pin', PasswordVerifyPinController::class);
    Route::post('/forgot', PasswordForgotController::class);
    Route::post('/verify-email', VerifyEmailController::class);

    //Private AUTH Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', UserLogoutController::class);
        Route::post('/reset-password', UserResetPasswordController::class);
        Route::get('/user/{userId}', UserGetController::class);
    });
});

Route::middleware('auth:sanctum')
    ->prefix('/admin')
    ->group(function () {
        Route::post('/create/', AdminCreateController::class);
        Route::post('/accept/{partenaireId}/{offerId}', AdminAcceptController::class);
        Route::post('/refuse/{partenaireId}/{offerId}', AdminRefuseController::class);

    });
Route::middleware('auth:sanctum')
    ->prefix('/partenaire-notification')
    ->group(function () {
        // Route::get('/adherent', AdherentNotificationController::class);
        Route::get('/{userId}', PartenaireRegisterNotificationController::class);
        Route::get('/all/{userId}', PartenaireNotificationController::class);


    });
Route::middleware('auth:sanctum')
    ->prefix('/firebase')
    ->group(function () {
        Route::post('/', UserFcmTokenController::class);

    });

Route::middleware('auth:sanctum')
    ->prefix('/like')
    ->group(function () {
        Route::get('/{userId}', UsersLikesController::class);
        Route::post('/add/{userId}/{offerId}', AdherentAddLikeController::class);
        Route::delete('/dislike/{userId}/{offerId}', AdherentDislikeController::class);

    });


Route::middleware('auth:sanctum')
    ->prefix('/filter')
    ->group(function () {
        Route::get('/partenaire', PartenaireListController::class);

        Route::get('/', GouverneratGetController::class);
        Route::get('/{gouverneratId}', VillesGetController::class);
    });

Route::middleware('auth:sanctum')
    ->prefix('/offre')
    ->group(function () {
        Route::get('/filter/{userId}/{search}', OffresListController::class);
        Route::post('/', OffreCreateController::class);
        Route::get('/{id}/{userId}', OffreFindController::class);
        Route::get('/{partenaireId}', OffreByPartenaireController::class);
        Route::delete('/delete/{offreId}', PartenaireDeleteOfferController::class);

    });
Route::middleware('auth:sanctum')
    ->prefix('/secteur')
    ->group(function () {
        Route::get('/', SecteurGetController::class);
        Route::get('/partenaire/{id}', SecteurGetPartenaireController::class);
    });
Route::middleware('auth:sanctum')
    ->prefix('/favorites-offers')
    ->group(function () {
        Route::get('/{userId}', FavoriteUserController::class);
        Route::post('/add/{userId}/{offerId}', FavoriteAddController::class);
        Route::delete('/delete/{userId}/{favId}', FavoriteDeleteController::class);
    });

