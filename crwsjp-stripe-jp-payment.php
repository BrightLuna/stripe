<?php
/*
Plugin Name: Crebow Stripe JP Payment
Description: This plugin extends WordPress and allows you to accept credit card payments directly via the Stripe API.This plugin is optimized for Japanese, but people in countries other than Japan can also use it.
Version: 0.1.7
Plugin URI: https://crebow.info/crwsjp-stripe-jp-payment/
Author: Tomoya Matsumoto
Author URI: https://crebow.info/
License: GPLv2
Text Domain: crwsjp-stripe-jp-payment
Domain Path: /languages
*/

define( 'CRWSJP_VERSION', '0.1.7' );
define( 'CRWSJP_NAME', 'Crebow Stripe JP Payment' );
define( 'CRWSJP_SUPPORT_URL', 'https://crwsjp.info/crwsjp-stripe-jp-payment/' );
define( 'CRWSJP_REQUIRED_WP_VERSION', '4.9.7' );
define( 'CRWSJP_PLUGIN', __FILE__ );
define( 'CRWSJP_PLUGIN_BASENAME', plugin_basename( CRWSJP_PLUGIN ) );
define( 'CRWSJP_PLUGIN_NAME', trim( dirname( CRWSJP_PLUGIN_BASENAME ), '/' ) );
define( 'CRWSJP_PLUGIN_DIR', untrailingslashit( dirname( CRWSJP_PLUGIN ) ) );
define( 'CRWSJP_PLUGIN_URL', plugins_url( CRWSJP_PLUGIN_NAME ) );
define( 'CRWSJP_PLUGIN_PATH', plugin_dir_path( CRWSJP_PLUGIN ) );
/*
=================================================
Translation List
================================================= */
$crwsjplang = dirname( CRWSJP_PLUGIN_BASENAME ) . '/languages';
load_plugin_textdomain( 'crwsjp-stripe-jp-payment', false, $crwsjplang );
require_once( CRWSJP_PLUGIN_PATH . 'lib/translation-list.php' );
/*
=================================================
Functions
================================================= */
include_once( plugin_dir_path( __FILE__ ) . 'inc/functions.php' );

/*
=================================================
CoreCLASS
================================================= */
class CRWSJP_CoreCLASS {
  static
  function stripe_lib() {
    //Evaluate the class.
    //ex)Stripe PHP bindings(https://github.com/stripe/stripe-php)
    //ex)Documentation (Please see https://stripe.com/docs/api for up-to-date documentation.)
    if ( !class_exists( '\Stripe\Stripe' ) ) {
      require_once( CRWSJP_PLUGIN_PATH . 'lib/stripe-php-6.16.0/init.php' );
      //The method should be called once, before any request is sent to the API.
      \
      Stripe\ Stripe::setAppInfo( CRWSJP_NAME, CRWSJP_VERSION, CRWSJP_SUPPORT_URL );
    }
  }
}
$CRWSJP = new CRWSJP_CoreCLASS();


/*
=================================================
PaymentsCLASS
================================================= */
class CRWSJP_PaymentCLASS {
  private
  function __construct() {
    //Payment notification Check
    add_action( 'init', array( $this, 'crwsjp_payment_check_func' ) );
  }
  public
  function crwsjp_payment_check_func() {
    if ( isset( $_POST[ 'crwsjp_cookie_post' ] ) ) {
      $crwsjp_echo_key          = get_option( 'crwsjp_algo_key' );
      $crwsjp_echo_value        = get_option( 'crwsjp_algo_value' );
      $crwsjp_restoration_value = CRWSJP_OpenSSL_D::crwsjp_OpenSSL_Decoder( $crwsjp_echo_value, $crwsjp_echo_key );
      $crwsjp_post_value        = $_POST[ 'crwsjp_cookie_post' ];
      $crwsjp_post_value        = CRWSJP_OpenSSL_D::crwsjp_OpenSSL_Decoder( $crwsjp_post_value, $crwsjp_echo_key );

      if ( $crwsjp_post_value == $crwsjp_restoration_value ) {
        // Transmission processing.------------------------------------
        $stripeapikeys = CRWSJP_APIkeys::crwsjp_stripe_APIkeys();
        $cookie_post   = $_POST[ 'crwsjp_cookie_post' ];
        $token         = $_POST[ 'stripeToken' ];
        $email         = $_POST[ 'stripeEmail' ];
        $amount        = $_POST[ 'amount' ];
        $description   = $_POST[ 'description' ];
        $currency      = $_POST[ 'currency' ];
        $metadata = array(
          'userid'      => $_POST[ 'userid' ],
          'daytime'     => $_POST[ 'daytime' ],
          'itemname'    => $_POST[ 'itemname' ],
          'productcode' => $_POST[ 'productcode' ],
          'itemmpostid' => $_POST[ 'itemmpostid' ],
          'postid'      => $_POST[ 'postid' ],
          'stockuse'    => $_POST[ 'stockuse' ],
          'stockcount'  => $_POST[ 'stockcount' ],
        );
        CRWSJP_CoreCLASS::stripe_lib();
        \Stripe\ Stripe::setApiKey( $stripeapikeys[ 'secret_key' ] );
        mb_http_output( 'UTF-8' );
        ob_start( 'mb_output_handler' );

        try {
          $charge = \Stripe\ Charge::create( array(
            'amount'        => $amount,
            'currency'      => $currency,
            'source'        => $token,
            'description'   => $description,
            'receipt_email' => $email,
            'metadata'      => $metadata,
          ) );
        } catch ( \Stripe\ Error\ Card $e ) {
        // エラーページへリダイレクト ------------------------------------
          $crwsjp_denial_payment_page = get_option( 'crwsjp_denial_payment_page' );
          if(empty($crwsjp_denial_payment_page)){
            $page_failure_jump = get_page_by_path('crwsjp-failure-page');
            $page_failure_jump = $page_failure_jump->ID;
            if( $page_failure_jump == ''  ){
              $crwsjp_denial_payment_page = home_url().'/';
              unset( $_SESSION[ 'crwsjp_session' ] );
            }else{
              $crwsjp_denial_payment_page = home_url().'/crwsjp-failure-page/';
              session_start();
              $_SESSION['crwsjp_session'] = $cookie_post;
            }
          }
          header( 'Location: '.$crwsjp_denial_payment_page.'' );
          die( '決済が完了しませんでした' );
        }
        unset( $_SESSION[ 'crwsjp_session' ] );
        // サンキューページへリダイレクト ------------------------------------
        $crwsjp_thank_you = get_option( 'crwsjp_thank_you' );
          if(empty($crwsjp_thank_you)){
            $page_success_jump = get_page_by_path('crwsjp-success-page');
            $page_success_jump = $page_success_jump->ID;
            if( $page_success_jump == ''  ){
              $crwsjp_thank_you = home_url().'/';
              unset( $_SESSION[ 'crwsjp_session' ] );
            }else{
              $crwsjp_thank_you = home_url().'/crwsjp-success-page/';
              session_start();
              $_SESSION['crwsjp_session'] = $cookie_post;
            }
          }
          header( 'Location: '.$crwsjp_thank_you.'' );
        exit;
        // Transmission processing end.------------------------------------
      }
    }
  }
  // Single Instance check ------------------------------------
  protected static $instance_ob = null;
  public static
  function instance_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_ob ) {
      self::$instance_ob = new self;
    }
    return self::$instance_ob;
  }
  // Single Instance check end ------------------------------------
}
add_action( 'plugins_loaded', array( 'CRWSJP_PaymentCLASS', 'instance_ob_get' ) );


/*
=================================================
Management screen
================================================= */
//Setting menu
class CRWSJP_Menu_Add_Class {
  public
  function __construct() {
    add_action( 'admin_menu', array( $this, 'action' ) );
  }

  function action() {
    $menu_slug  = 'crwsjp';
    $capability = 'administrator';
    //Main Setting -----------------------------------
    $page_title = 'Crebow Stripe JP Payment';
    $menu_title = 'Crebow Stripe';
    $function   = 'crwsjp_toplevel_page';
    $iconURL    = plugins_url( 'assets/images/logo.svg', __FILE__ );
    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $iconURL );
    add_action( 'admin_init', 'crwsjp_register_setting' );
  }
}
new CRWSJP_Menu_Add_Class();
include_once( plugin_dir_path( __FILE__ ) . 'inc/dashboard-toplevel.php' );

//Add single item.
include_once( plugin_dir_path( __FILE__ ) . 'inc/custom-post-type-item.php' );
add_action( 'plugins_loaded', array( 'CRWSJP_PostItemCLASS', 'instance_postitem_ob_get' ) );
add_action( 'plugins_loaded', array( 'CRWSJP_CustomCieldsCLASS', 'instance_custom_fields_ob_get' ) );


//Purchase history.
$crwsjp_webhook_getcheck = get_option( 'crwsjp_webhook_address' );
if ( !empty( $crwsjp_webhook_getcheck ) ) {
  include_once( plugin_dir_path( __FILE__ ) . 'inc/custom-post-type-history.php' );
  add_action( 'plugins_loaded', array( 'CRWSJP_PostHistoryCLASS', 'instance_historyitem_ob_get' ) );
  add_action( 'plugins_loaded', array( 'CRWSJP_CustomCieldsHistoryCLASS', 'instance_customHistory_fields_ob_get' ) );
}


/*
=================================================
Javascript & CSS
=================================================*/
class CRWSJP_Add_JS_CSS_Class {
  public
  function __construct() {
    add_action( 'admin_head-post.php', array( $this, 'action_stripeItem' ) );
    add_action( 'admin_head-post-new.php', array( $this, 'action_stripeItem' ) );
  }

  public
  function action_stripeItem() {
    $ob = get_post_type_object( 'crwsjp_stripe_item' );
    $switch = $ob->labels->singular_name;
    if ( 'StripeItem' === $switch ) {
      wp_enqueue_script( 'crwsjp_validation-js', CRWSJP_PLUGIN_URL . '/assets/js/post-validation.js', [ 'jquery' ] );
      wp_enqueue_style( 'crwsjp_admin-css', CRWSJP_PLUGIN_URL . '/assets/css/admin.css' );
    }
  }
}
new CRWSJP_Add_JS_CSS_Class();


/*
=================================================
Shortcode
================================================= */
include_once( plugin_dir_path( __FILE__ ) . 'inc/shortcode.php' );
add_action( 'plugins_loaded', array( 'CRWSJP_Shortcode', 'instance_shortcode_ob_get' ) );
add_action( 'plugins_loaded', array( 'CRWSJP_Shortcode_stock', 'instance_shortcode_stock_ob_get' ) );
add_action( 'plugins_loaded', array( 'CRWSJP_Shortcode_contents', 'instance_shortcode_contents_ob_get' ) );



/*
=================================================
Subscription
================================================= */
include_once( plugin_dir_path( __FILE__ ) . 'subscription/shortcode.php' );
/*Subscription-Shortcode */
/* サブスクリプション -- 解除 */
/* 投稿時送信テスト */
/*
add_action( 'transition_post_status', function( $new_status, $old_status, $post ) {
  if ( 'publish' == $new_status  &&  'publish' != $old_status && 'crwsjp_stripe_item' == $post->post_type ) {
    $header = array( 'From: from@example.com' );
    wp_mail( 'from@example.com', $post->post_title, get_permalink( $post->ID ), $header );
  }
}, 10, 3 );
*/
/*

=================================================
Delete User
=================================================*/
require_once ABSPATH."/wp-admin/includes/user.php";
include_once( plugin_dir_path( __FILE__ ) . 'subscription/delete-user.php' );
add_action( 'plugins_loaded', array( 'CRWSJP_Delete_User', 'instance_deleteuser_ob_get' ) );


/*
=================================================
Webhook
=================================================*/
//https://example.com/wp-admin/admin-ajax.php?action=xxxx
class CRWSJP_WEBHOOK_Class {
  public
  function __construct() {
    $var_slug  = get_option( 'crwsjp_webhook_address' );
    $ajax_slug = 'wp_ajax_' . $var_slug;
    $ajax_url  = 'wp_ajax_nopriv_' . $var_slug;
    add_action( $ajax_slug, array( $this, 'crwsjp_single_item_history' ) );
    add_action( $ajax_url, array( $this, 'crwsjp_single_item_history' ) );
  }

  function crwsjp_single_item_history() {
    global $wpdb;
    $body         = file_get_contents( "php://input" );
    $json         = json_decode( $body );
    $hostnameGet  = gethostbyaddr( $_SERVER[ 'REMOTE_ADDR' ] );
    $ipAddressGet = gethostbyname( $hostnameGet );
    $ipLongGet    = ip2long( $ipAddressGet );
    $stripe_IP_ch = CRWSJP_IP_Stripe::crwsjp_stripe_IP_Addresses();
    /*
    $optdata 						=	'購入者ID'.$json->data->object->metadata->userid;
    $optdata 					.=	'商品名'.$json->data->object->metadata->itemname;
    $optdata 					.=	'識別コード'.$json->data->object->metadata->productcode;
    $optdata 					.=	'購入日'.$json->data->object->metadata->daytime;
    $optdata 					.=	'価格'.$json->data->object->amount;
    */
    $webhook_stripeid      = $json->data->object->id;
    $webhook_userid        = $json->data->object->metadata->userid;
    $webhook_itemname      = $json->data->object->metadata->itemname;
    $webhook_user          = $json->data->object->source->name;
    $webhook_receipt_email = $json->data->object->receipt_email;
    $webhook_productcode   = $json->data->object->metadata->productcode;
    $webhook_daytime       = $json->data->object->metadata->daytime;
    $webhook_postid        = $json->data->object->metadata->postid;
    $webhook_amount        = $json->data->object->amount;
    $webhook_status        = $json->data->object->status;

    //在庫管理
    $webhook_itemmpostid   = $json->data->object->metadata->itemmpostid;
    $webhook_stockuse      = $json->data->object->metadata->stockuse;
    $webhook_stockcount    = $json->data->object->metadata->stockcount;



    if ( in_array( $ipLongGet, $stripe_IP_ch, true ) && $webhook_status ==='succeeded' ) {
      $post_id = wp_insert_post( array(
        'post_type'   => 'crwsjp_buy_history',
        'post_title'  => $webhook_stripeid,
        'post_status' => 'publish',
      ) );
      if ( $post_id ) {
        update_post_meta( $post_id, 'crwsjp_webhook_userid', $webhook_userid );
        update_post_meta( $post_id, 'crwsjp_webhook_itemname', $webhook_itemname );
        update_post_meta( $post_id, 'crwsjp_webhook_user', $webhook_user );
        update_post_meta( $post_id, 'crwsjp_webhook_receipt_email', $webhook_receipt_email );
        update_post_meta( $post_id, 'crwsjp_webhook_productcode', $webhook_productcode );
        update_post_meta( $post_id, 'crwsjp_webhook_daytime', $webhook_daytime );
        update_post_meta( $post_id, 'crwsjp_webhook_postid', $webhook_postid );
        update_post_meta( $post_id, 'crwsjp_webhook_amount', $webhook_amount );
        update_post_meta( $post_id, 'crwsjp_webhook_stockcount', $webhook_stockcount );
      }
      //在庫管理
      if($webhook_stockuse == 'true'){
        $number_of_existing = get_post_meta( $webhook_itemmpostid, 'crwsjp_data_stocknumber', true );
        $now_stockcount     = $number_of_existing - $webhook_stockcount;
        update_post_meta( $webhook_itemmpostid, 'crwsjp_data_stocknumber', $now_stockcount );
        /*
        $stock_post_id = wp_update_post(array(
          'ID'  => $webhook_itemmpostid
        ) );
        if ( $stock_post_id  ) {
          $number_of_existing = get_post_meta( $webhook_itemmpostid, 'crwsjp_data_stocknumber', true );
          $now_stockcount     = $number_of_existing - $webhook_stockcount;
          update_post_meta( $webhook_itemmpostid, 'crwsjp_data_stocknumber', $now_stockcount );
        }*/
      }

    }
  }
}
new CRWSJP_WEBHOOK_Class();



/*
=================================================
SuccessPage & FailurePage
=================================================*/
class CRWSJP_SUCC_FAIL_PAGE_Class {
  public
  function __construct() {
    register_activation_hook(__FILE__,  array( $this, 'crwsjp_template_page_add'));
  }
  function crwsjp_template_page_add() {
    $page_success = get_page_by_path('crwsjp-success-page');
    $page_success = $page_success->ID;
    if( $page_success == ''  ){
      $post_value = array(
        'post_title'   => '決済完了',
        'post_name'    => 'crwsjp-success-page',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '<p>ありがとうございます。決済が完了しました。</p>ご入力いただいたメールアドレス宛へ領収書をお送りいたします。</p><p>1営業日以上待っても領収書が届かない場合、恐れ入りますがお問い合わせいただきますようお願いいたします。</p>'
      );
      $insert_id = wp_insert_post($post_value);
    }
    $page_failure = get_page_by_path('crwsjp-failure-page');
    $page_failure = $page_failure->ID;
    if( $page_failure == ''  ){
      $post_failure_value = array(
        'post_title'   => '決済処理失敗',
        'post_name'    => 'crwsjp-failure-page',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '<p>申し訳ございませんが、しばらく時間をあけて購入画面からやり直してください。</p>'
      );
      $insert_failure_id = wp_insert_post($post_failure_value);
    }
  }
}
new CRWSJP_SUCC_FAIL_PAGE_Class();


/*
=================================================
SuccessPage & FailurePage include
=================================================*/
class CRWSJP_INCLUDE_PAGE_Class {
  public
  function __construct() {
    add_filter( 'template_include', array( $this, 'crwsjp_success_template_include') );
    add_filter( 'template_include', array( $this, 'crwsjp_failure_template_include') );
  }
  function crwsjp_success_template_include( $template_success ) {
    if ( is_page( 'crwsjp-success-page' ) ) {
        $template_success = dirname( __FILE__ ) . '/templates/page-crwsjp-success-page.php';
    }
    return $template_success;
  }
  function crwsjp_failure_template_include( $template_failure ) {
    if ( is_page( 'crwsjp-failure-page' ) ) {
        $template_failure = dirname( __FILE__ ) . '/templates/page-crwsjp-failure-page.php';
    }
    return $template_failure;
  }

}
new CRWSJP_INCLUDE_PAGE_Class();
