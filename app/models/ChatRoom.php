<?php

class ChatRoom extends Eloquent {
	protected $fillable = array('name', 'file');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'chat_rooms';
}
