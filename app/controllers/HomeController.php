<?php

class HomeController extends BaseController {

	public function showWelcome() {

			$message = '';
			//getting a flash message when a new chat room is created
			if (Session::has('message'))
				{
					$message =  Session::get('message', 'default');
					Session::forget('message');
				}

        if(Auth::user()){
      $chat_rooms = $this->getJoinedChatRooms();
			$unread_messages_counts = $this->getUnreadMessagesCount($chat_rooms);
			$online_members_per_room = $this->getOnlineMembers($chat_rooms);
			$available_chat_rooms = $this->getAvailableChatRooms();
			$invited_chatrooms = $this->getInvitedChatRoomDetails();
			$registered = Online::registered()->distinct('user_id')->get();
			$online_users = '';
			foreach($registered as $register){
				$online_users[] = $register->user_id;
			}
			//$online_users = array_unique($online_users);			var_dump($online_users);die();
			$user_names = User::select('first_name')
									->whereIn('id',array_unique($online_users) )
									->lists('first_name');



		return View::make('home', array('chatrooms' => $chat_rooms,'online_members' => $online_members_per_room,
																	'user_names'  => $user_names, 'message' => $message,
																 	'available_chat_rooms' => $available_chat_rooms,
																	'unread_messages_counts' => $unread_messages_counts,
																	'invited_chatrooms'  => $invited_chatrooms));
        } else {
					Online::updateCurrent();
				}

		return View::make('home');
	}

	private function getJoinedChatRooms() {

		   	return			DB::table('chat_rooms')
									->whereIn('id', function($query) {
															 $query->select('chatroom_id')
															 ->from('chatroom_member')
																->where('member_id', Auth::user()->id);
									})->get();
	}

	private function getOnlineMembers($chat_rooms) {
			$room_members_count = '';
			foreach ($chat_rooms as $chat_room) {

			$room_members_count[] = 	DB::table('chatroom_member')
									            ->join('sessions', 'chatroom_member.member_id', '=', 'sessions.user_id')
									            ->where('chatroom_member.chatroom_id','=', $chat_room->id)
															->distinct('sessions.user_id')
									            ->count('sessions.user_id');

			}
			return $room_members_count;
	}

	private function getAvailableChatRooms() {
		return  DB::table('chat_rooms')
								->whereNotIn('id', function($query) {
											 $query->select('chatroom_id')
											 ->from('chatroom_member')
											->where('member_id', Auth::user()->id);
						})->get();
	}

	private function getUnreadMessagesCount($chat_rooms) {
			$messages_counts = '';
			foreach($chat_rooms as $chat_room) {
				$messages_counts[] = MessageStatus::where('chatroom_id', '=', $chat_room->id)
										 ->where('member_id', '=', Auth::user()->id)
										 ->where('is_read', '=', 0)
										 ->count();
			}
			return($messages_counts);
	}

	private function getInvitedChatRoomDetails() {

		return  	DB::table('invite_member')
						->join('users', 'invite_member.inviter_id', '=', 'users.id')
						->join('chat_rooms', 'invite_member.chatroom_id', '=', 'chat_rooms.id')
						->where('invite_member.member_id', Auth::user()->id)
						->get(array('chat_rooms.name', 'users.first_name', 'invite_member.chatroom_id'));


	}

}
