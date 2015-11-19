<?php

class InviteMember extends Eloquent {

  protected $fillable = array('member_id', 'chatroom_id', 'inviter_id');

  protected $table = 'invite_member';

  public static function updateInvitedMember($invited_id, $chatroom_id) {
    self::create(array(
          'member_id' => $invited_id,
          'chatroom_id' => $chatroom_id,
          'inviter_id' => Auth::user()->id
    ));
  }

  public static function checkInvitation($member_id, $chatroom_id) {
      return self::where('member_id', $member_id)
                    ->where('chatroom_id', $chatroom_id)
                    ->first();
  }

  public static function getInviterId($member_id, $chatroom_id) {
      return self::where('member_id', $member_id)
                    ->where('chatroom_id', $chatroom_id)
                    ->pluck('inviter_id');
  }

  public static function deleteInvite($chatroom_id) {
     self::where('chatroom_id', $chatroom_id)
          ->where('member_id', Auth::user()->id)
          ->delete();
  }
}

 ?>
