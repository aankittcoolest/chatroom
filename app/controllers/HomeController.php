<?php

class HomeController extends BaseController {

	public function showWelcome() {
        if(Auth::user()){
        $chat_rooms = $this->getJoinedChatRooms();
		$online_members = $this->getOnlineMembers($chat_rooms);
		$registered = Online::registered()->get();
		foreach($registered as $register){
			$online_users[] = $register->user_id;
		}
		$user_names = User::select('first_name')
								->whereIn('id',$online_users )
								->lists('first_name');



		return View::make('home', array('chatrooms' => $chat_rooms,'online_members' => $online_members, 'user_names'  => $user_names));
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
			foreach ($chat_rooms as $chat_room) {

			$room_members_count[] = 	DB::table('chatroom_member')
				            ->join('sessions', 'chatroom_member.member_id', '=', 'sessions.user_id')
				            ->where('chatroom_member.chatroom_id','=', $chat_room->id)
				            ->count();

			}
			return $room_members_count;
	}

}
