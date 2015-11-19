<?php

class ChatRoomMember extends Eloquent {
  protected $fillable = array('member_id', 'chatroom_id');

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'chatroom_member';
}


 ?>
