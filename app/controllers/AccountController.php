<?php

class AccountController extends BaseController {

	public function postSignUp() {
		$valid = Validator::make(Input::all(),
			array(
				'name' => 'required|max:50',
				'email' => 'required|max:50|email|unique:users',
				'password' => 'required|min:5',
				'password_again' => 'required|same:password',
			)
		);

		if($valid->fails()) {
			return Redirect::route('sign-up')->withErrors($valid)->withInput();
		}

		$name = Input::get('name');
		$email = Input::get('email');
		$password = Input::get('password');

		$code = str_random(60);

		$user = User::create(array(
			'email' => $email,
			'password' => Hash::make($password),
			'activated' => 0,
			'activation_code' => $code,
			'first_name' => $name,
		));

		if($user) {

			$email = Mail::send('emails.activate', array('name' => $name, 'link' => URL::route('activate-account', $code)), function($message) use ($user) {
				$message->to($user->email, $user->name)->subject('Activate your account');
			});

			if($email) {
				return Redirect::route('sign-up')->with('success', true);
			}
		}

		return Redirect::route('sign-up')->with('unex-error', true)->withInput();
	}

	public function postSignIn() {

		$valid = Validator::make(Input::all(),
			array(
				'email' => 'required|email',
				'password' => 'required'
			)
		);

		if(!$valid->fails()) {
			$user = User::where('email', '=', Input::get('email'));

			if($user->count()) {
				$user = $user->first();
				if(Hash::check(Input::get('password'), $user->password)) {
					if($user->activated == 1) {
						Auth::login($user);
						if($user->password_temp != '') {
							return Redirect::route('change-password')->with('warning', true);
						}
						return Redirect::intended('/');
					}
					return Redirect::route('sign-in')->withInput()->with('error', 'inactive-account');
				}
				else {
					return Redirect::route('sign-in')->withInput()->with('error', 'invalid-account');
				}
			}
			return Redirect::route('sign-in')->withInput()->with('error', 'account-doesnt-exist');
		}

		return Redirect::route('sign-in')->withInput()->with('error', 'invalid-account');
	}

	public function postForgotPassword() {
		$valid = Validator::make(Input::all(),
			array(
				'email' => 'required|email'
			)
		);

		if(!$valid->fails()) {
			$user = User::where('email', '=', Input::get('email'));

			if($user->count()) {
				$user = $user->first();

				if($user->active == 1) {
					$code = str_random(60);
					$password = str_random(10);

					$user->code = $code;
					$user->password_temp = Hash::make($password);

					if($user->save()) {

						$email = Mail::send('emails.forgotpassword', array('name' => $user->name, 'link' => URL::route('forgot-password-activate', array('user' => $user->id, 'code' => $code)), 'password' => $password), function($message) use ($user) {
							$message->to($user->email, $user->name)->subject('Your new password');
						});

						if($email) {
							return Redirect::route('forgot-password')->with('success', true);
						}

						return Redirect::route('forgot-password')->withInput()->with('error', 'unexpected-error');
					}

					return Redirect::route('forgot-password')->withInput()->with('error', 'unexpected-error');
				}

				return Redirect::route('forgot-password')->withInput()->with('error', 'inactive-account');
			}

			return Redirect::route('forgot-password')->withInput()->with('error', 'account-doesnt-exist');
		}

		return Redirect::route('forgot-password')->withInput()->with('error', 'invalid-email');
	}

	public function postChangePassword() {
		$valid = Validator::make(Input::all(), array(
			'old_password' => 'required',
			'password' => 'required|min:5|different:old_password',
			'password_again' => 'required|same:password'
		));

		if($valid->passes()) {
			$user = Auth::user();

			if(Hash::check(Input::get('old_password'), $user->password)) {

				$user->password = Hash::make(Input::get('password'));
				$user->password_temp = '';

				if($user->save()) {
					return Redirect::route('change-password')->with('success', true);
				}

				return Redirect::route('change-password')->with('error', true);
			}

			return Redirect::route('change-password')->withErrors(array('old_password' => 'Incorrect current password'));
		}

		return Redirect::route('change-password')->withErrors($valid);
	}

	public function getSignIn() {
		return View::make('signin');
	}

	public function getSignUp() {
		return View::make('signup');
	}

	public function getActivateAccount($code) {
		$user = User::where('activation_code', '=', $code)->where('activated', '=', 0);
		if($user->count()) {
			$user = $user->first();
			$user->activated = 1;
			$user->activation_code = '';

			if($user->save()) {
				return Redirect::route('sign-in')->with('success', true);
			}
			return Redirect::route('sign-in')->with('error', 'unactive-account');
		}
		return App::abort(404);
	}

	public function getSignOut() {
		Auth::logout();
		return Redirect::route('home');
	}

	public function getForgotPassword() {
		return View::make('forgotpassword');
	}

	public function getForgotPasswordActivate($userId, $code) {
		$user = User::find($userId);
		if($user->code == $code) {
			$user->password = $user->password_temp;
			$user->code = '';

			if($user->save()) {
				return Redirect::route('sign-in');
			}

			return Redirect::route('forgot-password')->with('error', 'unexpected-error');
		}

		return Redirect::route('forgot-password')->with('error', 'account-doesnt-exist');
	}

	public function getChangePassword() {
		return View::make('changepassword');
	}
}
