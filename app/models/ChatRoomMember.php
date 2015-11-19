<?php

class ChatRoomMember extends Eloquent {
  protected $fillable = array('member_id', 'chatroom_id');

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'chatroom_member';

  public static function getOnlineChatMembers($id) {
    return self::where('chatroom_id', $id)
                  ->where('is_active', 1)
                  ->where('member_id','<>', Auth::user()->id)
                  ->lists('member_id');

  }

  public static function getChatMembersIds($id) {
    return self::where('chatroom_id', $id)
                                  ->lists('member_id');
  }

  public static function getInactiveChatMembersIds($id) {
    return self::where('chatroom_id', $id)
                  ->where('is_active', 0)
                  ->where('member_id','<>', Auth::user()->id)
                  ->lists('member_id');
  }

  public static function updateUserCurrentChatroomStatus($status, $id) {
     return self::where('member_id',Auth::user()->id)
                   ->where('chatroom_id',$id)
                   ->update(array('is_active' => $status));
  }

  public static function updateInactiveUsersStatus($user_ids) {
      return self::whereIn('member_id', $user_ids)
                  ->update(array('is_active' => 0));
  }

  public static function userChatRoomValidityCheck($chatroom_id) {
      return  self::where('chatroom_id', $chatroom_id)
                ->where('member_id', Auth::user()->id)
                ->first();
  }
}




 ?>
