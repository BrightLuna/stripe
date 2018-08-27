<?php
class CRWSJP_Delete_User{
  function __construct() {
    add_action( 'delete_user', array( $this, 'crwsjp_delete_user' ) );
  }
  // Single Instance check ------------------------------------
  protected static $instance_deleteuser_ob = null;
  public static
  function instance_deleteuser_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_deleteuser_ob ) {
      self::$instance_deleteuser_ob = new self;
    }
    return self::$instance_deleteuser_ob;
    // Single Instance check end.------------------------------------
  }
  function crwsjp_delete_user( $user_id ) {
    global $wpdb;
    //$user_obj = get_userdata( $user_id );
    //$email    = $user_obj->user_email;
    //$headers  = 'From: ' . get_bloginfo( "name" ) . ' <' . get_bloginfo( "admin_email" ) . '>' . "\r\n";
    //wp_mail( $email, 'プラグインのフック次第ですが削除されたよ', '削除したユーザーさんを' . get_bloginfo("name") . ' 削除処理', $headers );
  }
}


