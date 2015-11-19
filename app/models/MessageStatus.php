<?php

class MessageStatus extends Eloquent {
  public $timestamps = true;
  protected $fillable = array('member_id', 'chatroom_id', 'message_id', 'is_read', 'created_at', 'updated_at');

  protected $table = 'messages_status';
}

 ?>
