<?php

class MemberController extends BaseController {

  public function getOnlineChatMembers($id) {
    $online_chat_members_id = 	ChatRoomMember::getOnlineChatMembers($id);
    $total_online_members_id =  SessionHandle::getOnlineMembersIds();

    $updated_online_chat_members_id = array_intersect($online_chat_members_id,$total_online_members_id);
    $offline_chat_members = array_diff($online_chat_members_id, $updated_online_chat_members_id);
    if($offline_chat_members) {
          ChatRoomMember::updateInactiveUsersStatus($offline_chat_members);
    }


    if($updated_online_chat_members_id) {
        $online_members = UserPeer::getMemberDetailsFromIds($updated_online_chat_members_id);
    }
    return $online_members;
  }

  public function getOnlineNonChatMembers($id) {
    $online_chat_nonmembers_id =  $this->getOnlineNonChatMembersIds($id);
    if($online_chat_nonmembers_id) {
        return UserPeer::getMemberDetailsFromIds($online_chat_nonmembers_id);

    }
  }

  private function getOnlineNonChatMembersIds($id) {
    $chatroom_members_id = 	ChatRoomMember::getChatMembersIds($id);
    $online_members_id =    SessionHandle::getOnlineMembersIds();
    return array_diff($online_members_id, $chatroom_members_id);
  }

  public function getOfflineChatMembers($id) {
    $inactive_members =  	ChatRoomMember::getInactiveChatMembersIds($id);
    if($inactive_members) {
        return UserPeer::getMemberDetailsFromIds($inactive_members);
    }

  }

  public function getOfflineNonChatMembers($id) {
    $chatroom_members_id = array();
     $online_nonchat_members_id = array();
    $chatroom_members_id = 	ChatRoomMember::getChatMembersIds($id);
    $online_nonchat_members_id =  $this->getOnlineNonChatMembersIds($id);
    if(!is_null($online_nonchat_members_id) && !is_null($chatroom_members_id)) {

    }
    $data = array_merge($chatroom_members_id,$online_nonchat_members_id);
    $total_member_ids = UserPeer::getTotalMemberIds();
    $offline_nonchat_members_id = array_diff($total_member_ids, $data);
    if($offline_nonchat_members_id) {
        return UserPeer::getMemberDetailsFromIds($offline_nonchat_members_id);

    }


  }



}

 ?>
