<?php
// Home
	Online::updateCurrent();
Route::get('/',
	array(
		'as' => 'home',
		'uses' => 'HomeController@showWelcome'
	)
);


// Unauthenticated group

Route::group(array('before' => 'guest'), function() {

	// CSRF protection group

	Route::group(array('before' => 'csrf'), function() {

		// Sign In post

		Route::post('account/sign-in',
			array(
				'as' => 'sign-in-post',
				'uses' => 'AccountController@postSignIn'
			)
		);

		// Sign Up post

		Route::post('account/sign-up',
			array(
				'as' => 'sign-up-post',
				'uses' => 'AccountController@postSignUp'
			)
		);

		// Forgot password post

		Route::post('account/forgot-password',
			array(
				'as' => 'forgot-password-post',
				'uses' => 'AccountController@postForgotPassword'
			)
		);

	});

	// Sign In

	Route::get('account/sign-in',
		array(
			'as' => 'sign-in',
			'uses' => 'AccountController@getSignIn'
		)
	);

	// Sign Up

	Route::get('account/sign-up',
		array(
			'as' => 'sign-up',
			'uses' => 'AccountController@getSignUp'
		)
	);

	// Activate account

	Route::get('account/activate/{code}',
		array(
			'as' => 'activate-account',
			'uses' => 'AccountController@getActivateAccount'
		)
	);

	// Forgot password

	Route::get('account/forgot-password',
		array(
			'as' => 'forgot-password',
			'uses' => 'AccountController@getForgotPassword'
		)
	);

	// Activate temporary password

	Route::get('account/forgot-password/{user}/{code}',
		array(
			'as' => 'forgot-password-activate',
			'uses' => 'AccountController@getForgotPasswordActivate'
		)
	);
});

// Authenticated group

Route::group(array('before' => 'auth'), function() {

	// CSRF protection group

	Route::group(array('before' => 'csrf'), function() {

		// Change password post

		Route::post('account/change-password',
			array(
				'as' => 'change-password-post',
				'uses' => 'AccountController@postChangePassword'
			)
		);

	});

	// Sign Out

	Route::get('account/sign-out',
		array (
			'as' => 'sign-out',
			'uses' => 'AccountController@getSignOut'
		)
	);

	// Change password

	Route::get('account/change-password',
		array(
			'as' => 'change-password',
			'uses' => 'AccountController@getChangePassword'
		)
	);

	//show all chatrooms

	Route::get('chatrooms/show-chatrooms',
		array(
			'as'	=> 'show-chatrooms',
			'uses' => 'ChatRoomsController@getChatRooms'
		)
);

	Route::post('create-chatroom',
			array(
				'as'	=>	'create-chatroom',
				'uses'	=>	'ChatRoomsController@createChatRoom'
			));


 	Route::match(array('GET', 'POST'),'join-chatroom/{id}', array(
				'as'	=> 'join-chatroom',
				'uses'	=> 'ChatRoomsController@joinChatRoom'
		));

	Route::get('get-messages/{id}',
			array(
					'as'	=> 'get-messages',
					'uses'	=> 'ChatRoomsController@getMessages'
			));

			Route::post('update-message/{id}',
					array(
							'as'	=> 'get-messages',
							'uses'	=> 'ChatRoomsController@UpdateMessage'
					));


		Route::get('join-room/{id}',
			array(
				'as'	=> 'join-room',
				'uses'	=> 'ChatRoomsController@joinRoom'
			));

			Route::match(array('GET', 'POST'), 'register-chatroom/{chatroom_id?}/accept={accept?}',
				array(
					'as'	=> 'register-chatroom',
					'uses'	=> 'ChatRoomsController@registerChatroom'
				));

			Route::get('online-chat-members/{id}',
				array(
					'as'	=> 'online-chat-members',
					'uses'	=> 'MemberController@getOnlineChatMembers'
				));

			Route::get('online-nonchat-members/{id}',
				array(
					'as'	=> 'online-nonchat-members',
					'uses'	=> 'MemberController@getOnlineNonChatMembers'
				));

			Route::get('offline-chat-members/{id}',
				array(
					'as'	=> 'offline-chat-members',
					'uses'	=> 'MemberController@getOfflineChatMembers'
				));

			Route::get('offline-nonchat-members/{id}',
				array(
					'as'	=> 'offline-nonchat-members',
					'uses'	=> 'MemberController@getOfflineNonChatMembers'
				));

				Route::get('invite-member/{id}/chatroom={chatroom_id}',
					array(
						'as'	=> 'invite_member',
						'uses'	=> 'InviteController@inviteMember'
					));

				Route::get('check-invite/{id}/chatroom={chatroom_id}',
					array(
						'as'	=> 'invite_member',
						'uses'	=> 'InviteController@checkInvited'
					));

				Route::get('get-inviter/{id}/chatroom={chatroom_id}',
					array(
						'as'	=> 'invite_member',
						'uses'	=> 'InviteController@getInviterDetails'
					));




});
