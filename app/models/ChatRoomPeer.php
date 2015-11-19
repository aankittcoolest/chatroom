<?php

class ChatRoomPeer extends ChatRoom {

public static function getChatRoomDetailsById($id) {
  return self::where('id',$id)
              ->first();
}



}


 ?>
