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

// The admin login page
	Route::get('/','AdminController@getLogin');
	Route::post('admin','AdminController@postLogin');

// The admin logout page
	Route::get('logout','AdminController@getLogout');

// The admin domain page
	Route::get('admin/domains' , 'AdminController@getAddDomain');
	Route::post('admin/domains' , 'AdminController@postAddDomain');
	Route::get('admin/domain-list' , 'AdminController@getDomainList');
	Route::get('delete-domain/{id}' , 'AdminController@deleteDomain');
	Route::post('modal-value/{id}/edit' , 'AdminController@ajaxEdit');
	Route::post('modal-update-value/{id}' , 'AdminController@editDomain');

// The admin domain languages  page		
	Route::get('admin/domain-lang/{id}' , 'AdminController@getdomainLanguage');
	Route::post('admin/add-domain-lang/{id}' , 'AdminController@postAddDomainLang');
	Route::get('admin/delete-domain-lang/{domainId}/{languageId}' , 'AdminController@getDeleteDomainLanguage');

// The admin dashboard page
	Route::get('admin-dashboard' , 'AdminController@getDashboard');
	
// The admin domain files page
	Route::post('admin/add-file/{id}' , 'AdminController@postAddFile');
	Route::get('admin/domain-files/{id}' , 'AdminController@domainFiles');
	Route::get('admin/domain-files-delete/{id}/{domainId}' , 'AdminController@getDeleteDomainFiles');

// The admin language page
	Route::get('admin/add-language' , 'AdminController@getAddLanguage');
	Route::post('admin/add-language' , 'AdminController@postAddLanguage');
	
// The admin language list page
	Route::get('admin/language-list' , 'AdminController@getLanguageList');
	Route::get('admin/language-download/{id}/{fileName}' , 'AdminController@getDownloadLangFile');
	Route::post('admin/languageFile-edit/{id}' , 'AdminController@postEditLanguage');
	Route::get('admin/language-delete/{id}' , 'AdminController@getDeleteLanguage');
	Route::get('admin/languageName/{id}' , 'AdminController@editLangName');
	Route::post('admin/language-modal-valaue/{id}' , 'AdminController@printValueModal');
	Route::post('admin/language-update/{id}' , 'AdminController@editLangName');

// The admin EN language download and update
	Route::get('admin/language-en-download/{fileName}' , 'AdminController@getDownloadEnLang');
	Route::post('admin/langugae-en-update' , 'AdminController@postUpdateEnLang');
	







