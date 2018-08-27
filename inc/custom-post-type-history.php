<?php
/*
=================================================
Custom Post Type History
================================================= */
class CRWSJP_PostHistoryCLASS {

  function __construct() {
    add_action( 'init', array( $this, 'action_custom_init' ) );
  }

  // Single Instance check ------------------------------------
  protected static $instance_historyitem_ob = null;
  public static

  function instance_historyitem_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_historyitem_ob ) {
      self::$instance_historyitem_ob = new self;
    }
    return self::$instance_historyitem_ob;
    // Single Instance check end.------------------------------------
  }


  public

  function action_custom_init() {
    $labels = array(
      'name'               => crwsjp_translation_func( 'custom_history_name' ),
      'singular_name'      => crwsjp_translation_func( 'custom_history_name' ),
      'add_new'            => crwsjp_translation_func( 'custom_history_add' ),
      'add_new_item'       => crwsjp_translation_func( 'custom_history_add' ),
      'edit_item'          => crwsjp_translation_func( 'custom_history_edit' ),
      'new_item'           => crwsjp_translation_func( 'custom_history_add' ),
      'all_items'          => crwsjp_translation_func( 'custom_history_list' ),
      'view_item'          => crwsjp_translation_func( 'custom_history_edit' ),
      'search_items'       => crwsjp_translation_func( 'custom_history_search' ),
      'not_found'          => crwsjp_translation_func( 'ustom_history_not_found' ),
      'not_found_in_trash' => crwsjp_translation_func( 'custom_history_garbage' ),
      'parent_item_colon'  => '',
      'menu_name'          => crwsjp_translation_func( 'custom_history_name' )
    );
    $args = array(
      'labels'              => $labels,
      'public'              => true, //公開場合はtrue
      'publicly_queryable'  => false, //false//post_type=(カスタム投稿タイプ名) でその投稿タイプの記事一覧を表示
      'show_ui'             => true, //true,管理画面にカスタム投稿タイプを表示する場合はtrue
      'show_in_menu'        => true, //false,管理画面にカスタム投稿タイプを表示する場合はtrue
      'show_in_rest'        => false,
      'query_var'           => true, //
      'rewrite'             => array( 'slug' => 'crwsjp_buy_history' ),
      'capability_type'     => 'post', //権限のタイプ
      'has_archive'         => false, //アーカイブページの表示を許可する場合はtrue
      'hierarchical'        => false, //投稿タイプ同士に親子関係を持たせる場合はtrue
      'exclude_from_search' => true, //検索反映にさせない場合はtrue,
      'menu_position'       => null, //管理画面サイドバー上の位置を半角数字で指定。5ごとに移動されます
      'supports'            => array( 'title' )
    );
    register_post_type( 'crwsjp_buy_history', $args );
  }
}



/*
=================================================
Setting
================================================= */
class CRWSJP_CustomCieldsHistoryCLASS {

  function __construct() {
    add_action( 'admin_menu', array( $this, 'action_customhistory_fields' ) );
    add_action( 'save_post', array( $this, 'save_crwsjp_itemhistory_fields' ) );
  }

  // Single Instance check ------------------------------------
  protected static $instance_customHistory_fields_ob = null;
  public static

  function instance_customHistory_fields_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_customHistory_fields_ob ) {
      self::$instance_customHistory_fields_ob = new self;
    }
    return self::$instance_customHistory_fields_ob;
    // Single Instance check end.------------------------------------
  }

  public

  function action_customhistory_fields() {

    add_meta_box(
      'crwsjp_webhook_userid',
      '購入者ID',
      array( $this, 'crwsjp_webhook_userid' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_user',
      '購入者',
      array( $this, 'crwsjp_webhook_user' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_receipt_email',
      'E-mail',
      array( $this, 'crwsjp_webhook_receipt_email' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_itemname',
      '商品名',
      array( $this, 'crwsjp_webhook_itemname' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_stockcount',
      '購入数',
      array( $this, 'crwsjp_webhook_stockcount' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_productcode',
      '商品識別コード',
      array( $this, 'crwsjp_webhook_productcode' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_daytime',
      '購入日',
      array( $this, 'crwsjp_webhook_daytime' ),
      'crwsjp_buy_history',
      'normal'
    );

    add_meta_box(
      'crwsjp_webhook_amount',
      '価格',
      array( $this, 'crwsjp_webhook_amount' ),
      'crwsjp_buy_history',
      'normal'
    );
  }



  function crwsjp_webhook_userid() {
    global $post;
    $crwsjp_webhook_userid_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_userid', true ) );
    echo '<input type="text" name="crwsjp_webhook_userid" value="' . $crwsjp_webhook_userid_esc . '" />';
  }

  function crwsjp_webhook_user() {
    global $post;
    $crwsjp_webhook_user_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_user', true ) );
    echo '<input type="text" name="crwsjp_webhook_user" value="' . $crwsjp_webhook_user_esc . '" style="width:100%" />';
  }

  function crwsjp_webhook_receipt_email() {
    global $post;
    $crwsjp_webhook_receipt_email_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_receipt_email', true ) );
    echo '<input type="text" name="crwsjp_webhook_receipt_email" value="' . $crwsjp_webhook_receipt_email_esc . '" style="width:100%" />';
  }

  function crwsjp_webhook_itemname() {
    global $post;
    $crwsjp_webhook_itemname_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_itemname', true ) );
    echo '<input type="text" name="crwsjp_webhook_itemname" value="' . $crwsjp_webhook_itemname_esc . '" style="width:100%" />';
  }

  function crwsjp_webhook_stockcount() {
    global $post;
    $crwsjp_webhook_stockcount_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_stockcount', true ) );
    echo '<input type="text" name="crwsjp_webhook_stockcount" value="' . $crwsjp_webhook_stockcount_esc . '" style="width:100%" />';
  }

  function crwsjp_webhook_productcode() {
    global $post;
    $crwsjp_webhook_productcode_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_productcode', true ) );
    echo '<input type="text" name="crwsjp_webhook_productcode" value="' . $crwsjp_webhook_productcode_esc . '" style="width:100%" />';
  }

  function crwsjp_webhook_daytime() {
    global $post;
    $crwsjp_webhook_daytime_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_daytime', true ) );
    echo '<input type="text" name="crwsjp_webhook_daytime" value="' . $crwsjp_webhook_daytime_esc . '" />';
  }

  function crwsjp_webhook_amount() {
    global $post;
    $crwsjp_webhook_amount_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_webhook_amount', true ) );
    echo '<input type="text" name="crwsjp_webhook_amount" value="' . $crwsjp_webhook_amount_esc . '" />';
  }



  public

  function save_crwsjp_itemhistory_fields( $post_id ) {

    //crwsjp_webhook_userid
    if ( !empty( $_POST[ 'crwsjp_webhook_userid' ] ) ) {
      $crwsjp_webhook_userid_esc = esc_html( $_POST[ 'crwsjp_webhook_userid' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_userid', $crwsjp_webhook_userid_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_userid' );
    }

    //crwsjp_webhook_user
    if ( !empty( $_POST[ 'crwsjp_webhook_user' ] ) ) {
      $crwsjp_webhook_user_esc = esc_html( $_POST[ 'crwsjp_webhook_user' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_user', $crwsjp_webhook_user_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_user' );
    }

    //crwsjp_receipt_email
    if ( !empty( $_POST[ 'crwsjp_receipt_email' ] ) ) {
      $crwsjp_receipt_email_esc = esc_html( $_POST[ 'crwsjp_receipt_email' ] );
      update_post_meta( $post_id, 'crwsjp_receipt_email', $crwsjp_receipt_email_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_receipt_email' );
    }

    //crwsjp_webhook_itemname
    if ( !empty( $_POST[ 'crwsjp_webhook_itemname' ] ) ) {
      $crwsjp_webhook_itemname_esc = esc_html( $_POST[ 'crwsjp_webhook_itemname' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_itemname', $crwsjp_webhook_itemname_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_itemname' );
    }

    //crwsjp_webhook_stockcount
    if ( !empty( $_POST[ 'crwsjp_webhook_stockcount' ] ) ) {
      $crwsjp_webhook_stockcount_esc = esc_html( $_POST[ 'crwsjp_webhook_stockcount' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_stockcount', $crwsjp_webhook_stockcount_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_stockcount' );
    }

    //crwsjp_webhook_productcode
    if ( !empty( $_POST[ 'crwsjp_webhook_productcode' ] ) ) {
      $crwsjp_webhook_productcode_esc = esc_html( $_POST[ 'crwsjp_webhook_productcode' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_productcode', $crwsjp_webhook_productcode_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_productcode' );
    }

    //crwsjp_webhook_daytime
    if ( !empty( $_POST[ 'crwsjp_webhook_daytime' ] ) ) {
      $crwsjp_webhook_daytime_esc = esc_html( $_POST[ 'crwsjp_webhook_daytime' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_daytime', $crwsjp_webhook_daytime_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_daytime' );
    }

    //crwsjp_webhook_amount
    if ( !empty( $_POST[ 'crwsjp_webhook_amount' ] ) ) {
      $crwsjp_webhook_amount_esc = esc_html( $_POST[ 'crwsjp_webhook_amount' ] );
      update_post_meta( $post_id, 'crwsjp_webhook_amount', $crwsjp_webhook_amount_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_webhook_amount' );
    }


  }

}



/*
=================================================
Setting
================================================= */
// 一覧表のカスタマイズ
function add_posts_history_columns( $columns ) {
  unset($columns['title']); // タイトル
  unset($columns['date']); // 日付
  $columns[ 'title'                        ] = 'Stripe決済ID';
  $columns[ 'crwsjp_webhook_itemname'      ] = '商品名';
  $columns[ 'crwsjp_webhook_amount'        ] = '売上';
  $columns[ 'crwsjp_webhook_stockcount'    ] = '数量';
  $columns[ 'crwsjp_webhook_daytime'       ] = '決済日';
  $columns[ 'crwsjp_webhook_user'          ] = '購入者・請求先';
  $columns[ 'crwsjp_webhook_receipt_email' ] = 'E-mail';
  return $columns;
}

function add_posts_history_columns_row( $column_name, $post_id ) {
  if ( 'crwsjp_webhook_itemname' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_webhook_itemname', true) === "" ){
      echo 'データなし';
    }else{
      echo get_post_meta($post_id, 'crwsjp_webhook_itemname', true);
    }
  }

  if ( 'crwsjp_webhook_amount' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_webhook_amount', true) === "" ){
      echo 'データなし';
    }else{
      echo get_post_meta($post_id, 'crwsjp_webhook_amount', true).'円';
    }
  }

  if ( 'crwsjp_webhook_stockcount' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_webhook_stockcount', true) === "" ){
      echo 'データなし';
    }else{
      echo get_post_meta($post_id, 'crwsjp_webhook_stockcount', true).'点';
    }
  }

  if ( 'crwsjp_webhook_daytime' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_webhook_daytime', true) === "" ){
      echo 'データなし';
    }else{
      echo get_post_meta($post_id, 'crwsjp_webhook_daytime', true) ;
    }
  }

  if ( 'crwsjp_webhook_user' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_webhook_user', true) === "" ){
      echo 'データなし';
    }else{
      echo get_post_meta($post_id, 'crwsjp_webhook_user', true) ;
    }
  }

  if ( 'crwsjp_webhook_receipt_email' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_webhook_receipt_email', true) === "" ){
      echo 'データなし';
    }else{
      echo get_post_meta($post_id, 'crwsjp_webhook_receipt_email', true) ;
    }
  }

}
add_filter( 'manage_edit-crwsjp_buy_history_columns', 'add_posts_history_columns' );
add_action( 'manage_posts_custom_column', 'add_posts_history_columns_row', 10, 2 );