<?php

class InviteController extends BaseController {

  public function inviteMember($member_id, $chatroom_id) {
    if($this->checkInvited($member_id, $chatroom_id) == 'false') {
        InviteMember::updateInvitedMember($member_id, $chatroom_id);
    }

  return Redirect::route('join-room', array($chatroom_id));

  }

  public function checkInvited($member_id, $chatroom_id) {
      return (InviteMember::checkInvitation($member_id, $chatroom_id)) ? 'true' : 'false';
  }

  public function getInviterDetails($member_id, $chatroom_id) {
    if($this->checkInvited($member_id, $chatroom_id) == 'true') {
        $inviter_id = InviteMember::getInviterId($member_id, $chatroom_id);
        return UserPeer::getMemberDetailsFromId($inviter_id);

    }
  }
}

 ?>
