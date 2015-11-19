<?php

 class UserPeer extends User {

  public static function getMemberDetailsFromIds($ids_list) {
    return self::whereIn('id', $ids_list)
        ->lists( 'first_name','id');
  }

  public static function getTotalMemberIds() {
    return self::lists('id');
  }

  public static function getMemberDetailsFromId($id) {
    return self::where('id', $id)
        ->lists( 'first_name','id');
  }
}


 ?>
