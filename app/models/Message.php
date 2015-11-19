<?php

class message extends Eloquent
{
    protected $fillable = array('message', 'member_id', 'chatroom_id');

    protected $table = 'messages';

}

 ?>
