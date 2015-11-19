<?php

use Illuminate\Session\Store;
class SessionHandle extends Eloquent
{

  protected $fillable = array('user_id');

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'sessions';

  public static function getOnlineMembersIds() {
    return self::distinct('user_id')
            ->whereNotNull('user_id')
            ->lists('user_id');
  }


}

 ?>
