<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'ixpole' => [
			'token_url'     => 'ixpole.com/oauth/token',
		    'client_id'     => 'f4b494c0d30f4f',
		    'client_secret' => '040ccda3',
		    'grant_type'    => 'client_credentials',
		    'url'           => 'ixpole.com/api/'
		],

	]

];



