<?php

class ChatRoomsController extends BaseController {

private $chatroom_id = '';
private $message_id = '';

  public function createChatRoom() {
    $valid = Validator::make(Input::all(),
      array(
        'name' => 'required|max:50|unique:chat_rooms'
      )
    );
    if($valid->fails()){
      return Redirect::route('home')->withErrors($valid)->withInput();
    }
    $chatroom_name = Input::get('name');
    $chat_room_id =     ChatRoom::insertGetId(array(
                        'name' => $chatroom_name,
                        'file' => str_random(40)
                      ));
    Session::put('message', 'New chatroom has been added successfully');
    return $this->registerChatroom($chat_room_id);
  }


  public function joinRoom($id) {
    $room_details = ChatRoomPeer::getChatRoomDetailsById($id);
    if(!$room_details) {
      return Redirect::route('home');
    }
   return   ChatRoomMember::userChatRoomValidityCheck($id) ? View::make('chatrooms.joinChat', array('room_details' => $room_details)) : Redirect::route('home');
  }

  //get the frame via frame call
  public function joinChatRoom($id) {
       if($this->setAndValidateChatSession($id)){
          return View::make('chatrooms.sessionExpired');
       };

    $data = $this->getMessages($id);
    return View::make('chatrooms.joinChatRoom2', array('messages' => $data, 'chatroom'=> 'join-chatroom/'.$id));
  }

  private function setAndValidateChatSession($id) {
    session_start();
    if(!isset($_SESSION['timestamp'.$id])) {
      $_SESSION['timestamp'.$id] = time();
      ChatRoomMember::updateUserCurrentChatroomStatus(1, $id);
    }
      if(time() - $_SESSION['timestamp'.$id] > 100) {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();
        ChatRoomMember::updateUserCurrentChatroomStatus(0, $id);
        return true;
      }
  }


public function getMessages($id) {

   $messages_id = MessageStatus::select('message_id')
                ->where('chatroom_id', '=', $id)
                ->where('member_id', '=', Auth::user()->id)
                ->where('is_read', '=', 0)
                ->lists('message_id');

        if($messages_id) {
          MessageStatus::whereIn('message_id',$messages_id)
                        ->update(array('is_read' => 1));
        }
        $data =   DB::table('messages')
          ->join('users', 'messages.member_id', '=', 'users.id')
          ->where('messages.chatroom_id', '=', $id)
          ->orderBy('messages.id', 'desc')
          ->take(40)
          ->get(array('messages.message','users.first_name', 'users.id'));

          $data = array_reverse($data);
      return $data;

}

public function updateMessage($id) {

  //$message_status = new MessageStatus;
  if(Request::isMethod('post')) {
      $message = Input::get('message');
              if($message) {

          //insert the message in the db
          $message_id =   Message::insertGetId(
              array(
                  'message' => $message,
                  'member_id' => Auth::user()->id,
                  'chatroom_id' => $id
              ));

          //get list of active members in the group
          $active_chatroom_members = ChatRoomMember::select()
                                    ->where('chatroom_id', $id)
                                    ->where('member_id', '<>', Auth::user()->id)
                                    ->lists('member_id');

          //update message status of all active members
      $message_status = new MessageStatus;        foreach($active_chatroom_members as $active_chatroom_member) {

              $message_status->member_id    = $active_chatroom_member;
              $message_status->chatroom_id  = $id;
              $message_status->message_id   = $message_id;
              $message_status->is_read      = 0;
              $message_status->save();
          }
        }
      return $message;
  }
}



public function registerChatroom($chatroom_id, $accept = null) {
   if($accept == false) {
     InviteMember::deleteInvite($chatroom_id);
     return Redirect::route('home');
   } elseif( $accept == true) {
     InviteMember::deleteInvite($chatroom_id);
   }


  if(!$chatroom_id) {
      $chatroom_id = Input::get('chatroom_id');
  }
  if($chatroom_id) {
    $register_room = new ChatRoomMember;
    $register_room->member_id = Auth::user()->id;
    $register_room->chatroom_id = $chatroom_id;
    $register_room->is_active = 0;
    $register_room->save();
  }

return Redirect::route('home');

}


}


 ?>
