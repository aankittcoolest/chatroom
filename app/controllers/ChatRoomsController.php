<?php

class ChatRoomsController extends BaseController {

private $chatroom_id = '';
private $message_id = '';

  public function getChatRooms() {
    $registered = Online::registered()->get();


          $data = DB::table('chat_rooms')
            		      ->whereNotIn('id', function($query) {
            			           $query->select('chatroom_id')
                             ->from('chatroom_member')
            				        ->where('member_id', Auth::user()->id);
            		  })->get();

      return View::make('chatrooms.showChatRooms', array('chatrooms' => $data));
  }

  public function getNewChatRoom() {
      return View::make('chatrooms.createChatRoom');
  }

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
    ChatRoom::create(array(
      'name' => $chatroom_name,
      'file' => str_random(40)
    ));
    return Redirect::route('home');

  }

  public function joinChatRoom($id) {

    $message_status = new MessageStatus;
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
                                    ->lists('id');

          //update message status of all active members
          foreach($active_chatroom_members as $active_chatroom_member) {

              $message_status->member_id    = $active_chatroom_member;
              $message_status->chatroom_id  = $id;
              $message_status->message_id   = $message_id;
              $message_status->is_read      = 0;
              $message_status->save();
          }
        }
        $this->getMessages($id);
    }
    // $message_status->where('member_id','=', Auth::user()->id)
    //               ->delete();


    // $messages = Message::select('message', 'created_at')
    //             ->where('chatroom_id', $id)
    //             ->orderBy('id', 'desc')
    //             ->take(10)
    //             ->lists('message', 'created_at');

              $data =   DB::table('messages')
                ->join('users', 'messages.member_id', '=', 'users.id')
                ->orderBy('messages.id', 'desc')
                ->take(10)
                ->get(array('messages.message','users.first_name', 'users.id'));

                $data = array_reverse($data);


  //  $messages = array_reverse($messages);

    return View::make('chatrooms.joinChatRoom2', array('messages' => $data, 'chatroom'=> 'join-chatroom/'.$id));
  }

private function deleteReadMessages() {
  // //delete read messages from message status table
  // $message_status->where('member_id','=', Auth::user()->id)
  //               ->delete();
  // var_dump("Messages updated successfully");
  // die();
}

public function getMessages($id) {
  $messages = '';
   $messages_id = MessageStatus::select('message_id')
                ->where('chatroom_id', '=', $id)
                ->where('member_id', '=', Auth::user()->id)
                ->where('is_read', '=', 0)
                ->lists('message_id');

        if($messages_id) {
          MessageStatus::whereIn('message_id',$messages_id)
                        ->update(array('is_read' => 1));

            $messages = Message::select('message')
                      ->whereIn('id',$messages_id)
                      ->lists('message');

        }
      return $messages;



  $messages = Message::select('message', 'created_at')
              ->where('chatroom_id', $id)
              ->orderBy('id', 'desc')
              ->take(10)
              ->lists('message', 'created_at');

  $messages = array_reverse($messages);
  return $messages;
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
                                    ->lists('id');

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

public function joinRoom($id) {
 return View::make('chatrooms.joinChat', array('chatroom_id' => $id));
}

public function registerChatroom() {
  $chatroom_id = Input::get('chatroom_id');

$register_room = new ChatRoomMember;
$register_room->member_id = Auth::user()->id;
$register_room->chatroom_id = $chatroom_id;
$register_room->save();

return Redirect::route('show-chatrooms');

}


}


 ?>
