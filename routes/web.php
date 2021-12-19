<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WelcomeController@index')->name('/');
Route::get('/review', 'WelcomeController@review')->name('review');
Route::post('/filter-event', 'WelcomeController@filterEvent')->name('filter-event');
Route::get('/event-details-search-result/{search_value}', 'WelcomeController@detailedEventSearch')->name('event-details-search-result');
Auth::routes();

Route::get('/home', 'EventsController@index')->name('home')->middleware('auth');

Route::get('/create-event', 'EventsController@create')->name('create-event')->middleware('auth');
Route::post('/event-store', 'EventsController@store')->name('event-store')->middleware('auth');
Route::get('/invite-to-event/{event_id}', 'EventsController@createInvitation')->name('invite-to-event')->middleware('auth');

Route::post('/send-invitation', 'InviteesController@sendInvitation')->name('send-invitation')->middleware('auth');
Route::get('/invitee-list/{event_id}', 'InviteesController@inviteeList')->name('invitee-list')->middleware('auth');
/*Route::post('/remove-invitee/{id}', 'InviteesController@removeInvitee')->name('remove-invitee')->middleware('auth');*/
Route::post('/remove-invitee', 'InviteesController@removeInvitee')->name('remove-invitee');
/*Route::get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('bittu.at.work@gmail.com')->send(new \App\Mail\EventInvitationMail());
   
    dd("Email is Sent.");
});*/
/*Route::get('send-mail', function () {
   
    
    //Mail::to('bittu.at.work@gmail.com')->send(new \App\Mail\EventInvitationMail());
    Mail::mailer('mailgun')->to('bittu.at.work@gmail.com')->send(new EventInvitationMail());
    return 'done';
});*/