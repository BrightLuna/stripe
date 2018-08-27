<?php
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
Single Shortcode
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- */
class CRWSJP_Shortcode {
  var $CRWSJP_PaymentCLASS = null;

  function __construct() {
    $this->CRWSJP_PaymentCLASS = CRWSJP_PaymentCLASS::instance_ob_get();
    add_shortcode( 'crwsjp_checkout', array( $this, 'crwsjp_shortcode_checkout' ) );
  }
  // Single Instance check ------------------------------------
  protected static $instance_shortcode_ob = null;
  public static
  function instance_shortcode_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_shortcode_ob ) {
      self::$instance_shortcode_ob = new self;
    }
    return self::$instance_shortcode_ob;
    // Single Instance check end.------------------------------------
  }
  /*
  =================================================
  Button Only Shortcode
  ================================================= */
  function crwsjp_shortcode_checkout( $postid ) {
    $atts                         = shortcode_atts( array( 'id' => '0', ), $postid, 'crwsjp_checkout' );
    $post_ID                      = $atts[ 'id' ];
    $post                         = get_post( $post_ID );
    $eye_img                      = get_the_post_thumbnail_url( $post, 'medium' );
    $title                        = get_the_title( $post );
    $title                        = esc_html( $title );
    $crwsjp_opt_userid            = get_current_user_id();
    $crwsjp_opt_productcode       = get_post_meta( $post_ID, 'crwsjp_identification_code', true );
    $crwsjp_kye                   = CRWSJP_APIkeys::crwsjp_stripe_APIkeys();
    $crwsjp_checkout_url          = plugins_url() . '/crwsjp-stripe-jp-payment/checkout.php';
    $crwsjp_opt_name              = get_post_meta( $post_ID, 'crwsjp_data_name', true );
    $crwsjp_opt_name              = esc_html( $crwsjp_opt_name );
    $crwsjp_opt_description       = get_post_meta( $post_ID, 'crwsjp_data_description', true );
    $crwsjp_opt_description       = esc_html( $crwsjp_opt_description );
    $crwsjp_opt_amount            = get_post_meta( $post_ID, 'crwsjp_data_amount', true );
    $crwsjp_opt_amount            = esc_html( $crwsjp_opt_amount );
    //税率計算
    $crwsjp_data_taxuse           = get_post_meta( $post_ID, 'crwsjp_data_taxuse', true );
    $crwsjp_data_taxrate          = get_post_meta( $post_ID, 'crwsjp_data_taxrate', true );
      if($crwsjp_data_taxuse === 'true'){
        $crwsjp_opt_amount_tax = $crwsjp_opt_amount * ($crwsjp_data_taxrate / 100) ;
        $crwsjp_opt_amount     = floor( $crwsjp_opt_amount + $crwsjp_opt_amount_tax );
      }
    //在庫管理
    $crwsjp_data_stockuse         = get_post_meta( $post_ID, 'crwsjp_data_stockuse', true );
      if(empty($crwsjp_data_stockuse)){
        $crwsjp_data_stockuse = 'false';
      }
    $crwsjp_data_stocknumber      = get_post_meta( $post_ID, 'crwsjp_data_stocknumber', true );
      if($crwsjp_data_stockuse === 'true'){
        $crwsjp_data_stockuse_count = 1;
      }else{
        $crwsjp_data_stockuse_count = 1;
      }
    $crwsjp_opt_locale            = 'auto';
    $crwsjp_opt_billing_address   = get_post_meta( $post_ID, 'crwsjp_data_billing_address', true );
    $crwsjp_opt_billing_address   = esc_html( $crwsjp_opt_billing_address );
    $crwsjp_opt_currency          = 'jpy';
    $crwsjp_opt_panel_label       = get_post_meta( $post_ID, 'crwsjp_data_panel_label', true );
    $crwsjp_opt_panel_label       = esc_html( $crwsjp_opt_panel_label );
    $crwsjp_opt_shipping_address  = get_post_meta( $post_ID, 'crwsjp_data_shipping_address', true );
    $crwsjp_opt_shipping_address  = esc_html( $crwsjp_opt_shipping_address );
    $crwsjp_opt_label             = get_post_meta( $post_ID, 'crwsjp_data_label', true );
    $crwsjp_opt_label             = esc_html( $crwsjp_opt_label );
    $crwsjp_opt_allow_remember_me = 'false';
    $crwsjp_opt_echo_value        = get_option( 'crwsjp_algo_value' );
    $crwsjp_opt_cookie            = $_SESSION[ 'crwsjp_session' ];
    //$crwsjp_opt_locale                  = get_post_meta($post_ID, 'crwsjp_data_locale', true);
    //$crwsjp_opt_zip_code                = get_post_meta($post_ID, 'crwsjp_data_zip_code', true);
    //$crwsjp_opt_currency                = get_post_meta($post_ID, 'crwsjp_data_currency', true);
    //$crwsjp_opt_allow_remember_me       = get_post_meta($post_ID, 'crwsjp_data_allow_remember_me', true);
    if( $crwsjp_data_stockuse === 'true' and $crwsjp_data_stocknumber <= 0 ){
      $crwsjp_checkout_return = '<div class="crwsjp-checkout-zero">販売終了</div>';
    }else{
      // Output -------------------------------------------
      $crwsjp_checkout_return = '<form action="" method="POST"><script src="https://checkout.stripe.com/checkout.js" class="stripe-button"';
      $crwsjp_checkout_return .= 'data-key="' . $crwsjp_kye[ 'publishable_key' ] . '"';
      $crwsjp_checkout_return .= 'data-image ="' . $eye_img . '"';
      $crwsjp_checkout_return .= 'data-name ="' . $crwsjp_opt_name . '"';
      $crwsjp_checkout_return .= 'data-description ="' . $crwsjp_opt_description . '"';
      $crwsjp_checkout_return .= 'data-amount ="' . $crwsjp_opt_amount . '"';
      $crwsjp_checkout_return .= 'data-locale ="' . $crwsjp_opt_locale . '"';
      //$crwsjp_checkout_return           .='data-zip-code ="'.$crwsjp_opt_zip_code.'"';
      $crwsjp_checkout_return .= 'data-billing-address ="' . $crwsjp_opt_billing_address . '"';
      $crwsjp_checkout_return .= 'data-currency ="' . $crwsjp_opt_currency . '"';
      $crwsjp_checkout_return .= 'data-panel-label ="' . $crwsjp_opt_panel_label . '"';
      $crwsjp_checkout_return .= 'data-shipping-address ="' . $crwsjp_opt_shipping_address . '"';
      $crwsjp_checkout_return .= 'data-label ="' . $crwsjp_opt_label . '"';
      $crwsjp_checkout_return .= 'data-allow-remember-me ="' . $crwsjp_opt_allow_remember_me . '">';
      $crwsjp_checkout_return .= '</script>';
      $crwsjp_checkout_return .= '<input type="hidden" name="amount" value="' . $crwsjp_opt_amount . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="description" value="' . $title . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="currency" value="' . $crwsjp_opt_currency . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="userid" value="' . $crwsjp_opt_userid . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="itemname" value="' . $title . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="daytime" value="' . date_i18n('Y-m-d H:i:s') . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="itemmpostid" value="' . $post_ID . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="stockuse" value="' . $crwsjp_data_stockuse.'">';
      $crwsjp_checkout_return .= '<input type="hidden" name="stockcount" value="'.$crwsjp_data_stockuse_count.'">';
      $crwsjp_checkout_return .= '<input type="hidden" name="productcode" value="' . $crwsjp_opt_productcode . '">';
      $crwsjp_checkout_return .= '<input type="hidden" name="crwsjp_cookie_post" value="' . $crwsjp_opt_echo_value . '">';
      $crwsjp_checkout_return .= '</form>';
      // Output end -------------------------------------------
    }
    return $crwsjp_checkout_return;
  }
}

class CRWSJP_Shortcode_stock{
  var $CRWSJP_PaymentCLASS = null;
  function __construct() {
    $this->CRWSJP_PaymentCLASS = CRWSJP_PaymentCLASS::instance_ob_get();
    add_shortcode( 'crwsjp_checkout_stock', array( $this, 'crwsjp_shortcode_checkout_stock' ) );
  }
  // Single Instance check ------------------------------------
  protected static $instance_shortcode_stock_ob = null;
  public static
  function instance_shortcode_stock_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_shortcode_stock_ob ) {
      self::$instance_shortcode_stock_ob = new self;
    }
    return self::$instance_shortcode_stock_ob;
    // Single Instance check end.------------------------------------
  }

  function crwsjp_shortcode_checkout_stock( $postid ) {
    $atts                         = shortcode_atts( array( 'id' => '0', ), $postid, 'crwsjp_checkout_stock' );
    $post_ID                      = $atts[ 'id' ];
    $post                         = get_post( $post_ID );
    $eye_img                      = get_the_post_thumbnail_url( $post, 'medium' );
    $title                        = get_the_title( $post );
    $title                        = esc_html( $title );
    $crwsjp_opt_userid            = get_current_user_id();
    $crwsjp_opt_productcode       = get_post_meta( $post_ID, 'crwsjp_identification_code', true );
    $crwsjp_kye                   = CRWSJP_APIkeys::crwsjp_stripe_APIkeys();
    $crwsjp_checkout_url          = plugins_url() . '/crwsjp-stripe-jp-payment/checkout.php';
    $crwsjp_opt_name              = get_post_meta( $post_ID, 'crwsjp_data_name', true );
    $crwsjp_opt_name              = esc_html( $crwsjp_opt_name );
    $crwsjp_opt_description       = get_post_meta( $post_ID, 'crwsjp_data_description', true );
    $crwsjp_opt_description       = esc_html( $crwsjp_opt_description );
    $crwsjp_opt_amount            = get_post_meta( $post_ID, 'crwsjp_data_amount', true );
    $crwsjp_opt_amount            = esc_html( $crwsjp_opt_amount );
    //税率計算
    $crwsjp_data_taxuse           = get_post_meta( $post_ID, 'crwsjp_data_taxuse', true );
      if(empty($crwsjp_data_stockuse)){
        $crwsjp_data_stockuse = 'false';
      }
    $crwsjp_data_taxrate          = get_post_meta( $post_ID, 'crwsjp_data_taxrate', true );
      if($crwsjp_data_taxuse === 'true'){
        $crwsjp_opt_amount_tax = $crwsjp_opt_amount * ($crwsjp_data_taxrate / 100) ;
        $crwsjp_opt_amount_tax = floor( $crwsjp_opt_amount + $crwsjp_opt_amount_tax );
      }
    //在庫管理
    $crwsjp_data_stockuse         = get_post_meta( $post_ID, 'crwsjp_data_stockuse', true );
    $crwsjp_data_stocknumber      = get_post_meta( $post_ID, 'crwsjp_data_stocknumber', true );

    //計算ID用のランダムな文字列を生成する
    $crwsjp_rand_str              = chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90)) . chr(mt_rand(65,90));
    $crwsjp_opt_locale            = 'auto';
    $crwsjp_opt_billing_address   = get_post_meta( $post_ID, 'crwsjp_data_billing_address', true );
    $crwsjp_opt_billing_address   = esc_html( $crwsjp_opt_billing_address );
    $crwsjp_opt_currency          = 'jpy';
    $crwsjp_opt_panel_label       = get_post_meta( $post_ID, 'crwsjp_data_panel_label', true );
    $crwsjp_opt_panel_label       = esc_html( $crwsjp_opt_panel_label );
      if(empty($crwsjp_opt_panel_label)){
        $crwsjp_opt_panel_label   ='購入を確定する';
      }
    $crwsjp_opt_shipping_address  = get_post_meta( $post_ID, 'crwsjp_data_shipping_address', true );
    $crwsjp_opt_shipping_address  = esc_html( $crwsjp_opt_shipping_address );
    $crwsjp_opt_label             = get_post_meta( $post_ID, 'crwsjp_data_label', true );
    $crwsjp_opt_label             = esc_html( $crwsjp_opt_label );
    $crwsjp_opt_allow_remember_me = 'false';
    $crwsjp_opt_echo_value        = get_option( 'crwsjp_algo_value' );
    $crwsjp_opt_cookie            = $_SESSION[ 'crwsjp_session' ];
    //$crwsjp_opt_locale                  = get_post_meta($post_ID, 'crwsjp_data_locale', true);
    //$crwsjp_opt_zip_code                = get_post_meta($post_ID, 'crwsjp_data_zip_code', true);
    //$crwsjp_opt_currency                = get_post_meta($post_ID, 'crwsjp_data_currency', true);
    //$crwsjp_opt_allow_remember_me       = get_post_meta($post_ID, 'crwsjp_data_allow_remember_me', true);


    // Output -------------------------------------------
    if( $crwsjp_data_stockuse === 'true' and $crwsjp_data_stocknumber <= 0 ){
      $crwsjp_checkout_stock_return = '<div class="crwsjp-checkout-zero">販売終了</div>';
    }else{
    $crwsjp_checkout_stock_return ='';
      if($crwsjp_data_taxuse === 'true'){
        //税別の場合の計算
        $crwsjp_checkout_stock_return .= '<script type="text/javascript">'."\n";
        $crwsjp_checkout_stock_return .= 'function keisan'.$crwsjp_rand_str.'(){'."\n";
        $crwsjp_checkout_stock_return .= 'var tax       = '.$crwsjp_data_taxrate.';'."\n"; // 消費税率
        $crwsjp_checkout_stock_return .= 'var price     = document.getElementById("stockcount'.$crwsjp_rand_str.'").selectedIndex * '.$crwsjp_opt_amount .';'."\n";
        $crwsjp_checkout_stock_return .= 'var stripdata = document.getElementById("stripejs'.$crwsjp_rand_str.'");'."\n";
        $crwsjp_checkout_stock_return .= 'var tax     = Math.round((price * tax) / 100);'."\n";
        $crwsjp_checkout_stock_return .= 'var target  = document.getElementById("output'.$crwsjp_rand_str.'");'."\n";
        $crwsjp_checkout_stock_return .= 'stripdata.dataset.amount     = price + tax;'."\n";
        //$crwsjp_checkout_stock_return .= 'stripdata.dataset.panelLabel = price + tax +"これ";'."\n";
        $crwsjp_checkout_stock_return .= 'target.innerHTML =  price + tax;'."\n";
        //$crwsjp_checkout_stock_return .= 'document.form'.$crwsjp_rand_str.'.field_total.value = price + tax;'."\n";
        $crwsjp_checkout_stock_return .= 'document.form'.$crwsjp_rand_str.'.amount.value = price + tax;'."\n";
        $crwsjp_checkout_stock_return .= '}'."\n";
        $crwsjp_checkout_stock_return .= '</script>'."\n";
      }else{
        //税込の場合の計算
        $crwsjp_checkout_stock_return .= '<script type="text/javascript">'."\n";
        $crwsjp_checkout_stock_return .= 'function keisan'.$crwsjp_rand_str.'(){'."\n";
        $crwsjp_checkout_stock_return .= 'var price     = document.getElementById("stockcount'.$crwsjp_rand_str.'").selectedIndex * '.$crwsjp_opt_amount .';'."\n";
        $crwsjp_checkout_stock_return .= 'var stripdata = document.getElementById("stripejs'.$crwsjp_rand_str.'");'."\n";
        $crwsjp_checkout_stock_return .= 'var target  = document.getElementById("output'.$crwsjp_rand_str.'");'."\n";
        $crwsjp_checkout_stock_return .= 'stripdata.dataset.amount     = price;'."\n";
        $crwsjp_checkout_stock_return .= 'target.innerHTML =  price;'."\n";
        $crwsjp_checkout_stock_return .= 'document.form'.$crwsjp_rand_str.'.amount.value = price ;'."\n";
        $crwsjp_checkout_stock_return .= '}'."\n";
        $crwsjp_checkout_stock_return .= '</script>'."\n";
      }



    $crwsjp_checkout_stock_return .= '<form action="" method="POST" name="form'.$crwsjp_rand_str.'">';

    $crwsjp_checkout_stock_return .= '<div class="stockselect"><select id="stockcount'.$crwsjp_rand_str.'" name="stockcount" onChange="keisan'.$crwsjp_rand_str.'()">';
    $crwsjp_data_stocknumber_for = $crwsjp_data_stocknumber+1;
    for ($i=0; $i<$crwsjp_data_stocknumber_for; $i++) {
      $crwsjp_checkout_stock_return .= '<option value="'.$i.'">'.$i.'</option>';
    }
    $crwsjp_checkout_stock_return .= '</select><span class="stockselect-t">点</span></div>';
    $crwsjp_checkout_stock_return .= '<div class="stock-amount"><span class="yen-mark">¥</span><span id="output'.$crwsjp_rand_str.'" class="total-amount-opt">0</span><span class="tax-included">(税込)</span></div>'."\n";
    $crwsjp_checkout_stock_return .= '<div class="unit-price">単価:<span class="yen-mark">¥</span><span class="unit-price-opt">'.$crwsjp_opt_amount.'</span><span class="tax-included">/1点</span></div>';


    $crwsjp_checkout_stock_return .= '<script id="stripejs'.$crwsjp_rand_str.'" src="https://checkout.stripe.com/checkout.js" class="stripe-button"';
    $crwsjp_checkout_stock_return .= 'data-key="' . $crwsjp_kye[ 'publishable_key' ] . '"';
    $crwsjp_checkout_stock_return .= 'data-image ="' . $eye_img . '"';
    $crwsjp_checkout_stock_return .= 'data-name ="' . $crwsjp_opt_name . '"';
    $crwsjp_checkout_stock_return .= 'data-description ="' . $crwsjp_opt_description . '"';
    //$crwsjp_checkout_stock_return .= 'data-amount ="' . $crwsjp_opt_amount . '"';
    $crwsjp_checkout_stock_return .= 'data-locale ="' . $crwsjp_opt_locale . '"';
    //$crwsjp_checkout_return           .='data-zip-code ="'.$crwsjp_opt_zip_code.'"';
    $crwsjp_checkout_stock_return .= 'data-billing-address ="' . $crwsjp_opt_billing_address . '"';
    $crwsjp_checkout_stock_return .= 'data-currency ="' . $crwsjp_opt_currency . '"';
    $crwsjp_checkout_stock_return .= 'data-panel-label ="' . $crwsjp_opt_panel_label . '"';
    $crwsjp_checkout_stock_return .= 'data-shipping-address ="' . $crwsjp_opt_shipping_address . '"';
    $crwsjp_checkout_stock_return .= 'data-label ="' . $crwsjp_opt_label . '"';
    $crwsjp_checkout_stock_return .= 'data-allow-remember-me ="' . $crwsjp_opt_allow_remember_me . '">';
    $crwsjp_checkout_stock_return .= '</script>';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="amount" value="' . $crwsjp_opt_amount . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="description" value="' . $title . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="currency" value="' . $crwsjp_opt_currency . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="userid" value="' . $crwsjp_opt_userid . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="itemname" value="' . $title . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="daytime" value="' . date_i18n('Y-m-d H:i:s'). '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="productcode" value="' . $crwsjp_opt_productcode . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="crwsjp_cookie_post" value="' . $crwsjp_opt_echo_value . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="itemmpostid" value="' . $post_ID . '">';
    $crwsjp_checkout_stock_return .= '<input type="hidden" name="stockuse" value="' . $crwsjp_data_stockuse.'">';
    $crwsjp_checkout_stock_return .= '</form>';
  }
    // Output end -------------------------------------------
    return $crwsjp_checkout_stock_return;
  }

}







/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
Login Contents Shortcode
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- */
class CRWSJP_Shortcode_contents {
  var $CRWSJP_PaymentCLASS = null;

  function __construct() {
    $this->CRWSJP_PaymentCLASS = CRWSJP_PaymentCLASS::instance_ob_get();
    add_shortcode( 'crwsjp_contents', array( $this, 'crwsjp_shortcode_contents' ) );
  }
  // Single Instance check ------------------------------------
  protected static $instance_shortcode_contents_ob = null;
  public static
  function instance_shortcode_contents_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_shortcode_contents_ob ) {
      self::$instance_shortcode_contents_ob = new self;
    }
    return self::$instance_shortcode_contents_ob;
    // Single Instance check end.------------------------------------
  }
  /*
  =================================================
  Button Only Shortcode
  ================================================= */
  function crwsjp_shortcode_contents( $postid ) {
    $atts                          = shortcode_atts( array( 'id' => '0', ), $postid, 'crwsjp_contents' );
    $post_ID                       = $atts[ 'id' ];
    $post                          = get_post( $post_ID );
    $eye_img                       = get_the_post_thumbnail_url( $post, 'medium' );
    $title                         = get_the_title( $post );
    $title                         = esc_html( $title );
    $content                       = $post->post_content;
    $crwsjp_opt_userid             = get_current_user_id();
    $crwsjp_opt_user_only          = get_post_meta( $post_ID, 'crwsjp_user_only', true );
    $crwsjp_opt_productcode        = get_post_meta( $post_ID, 'crwsjp_identification_code', true );
    $crwsjp_kye                    = CRWSJP_APIkeys::crwsjp_stripe_APIkeys();
    $crwsjp_checkout_url           = plugins_url() . '/crwsjp-stripe-jp-payment/checkout.php';
    $crwsjp_opt_name               = get_post_meta( $post_ID, 'crwsjp_data_name', true );
    $crwsjp_opt_name               = esc_html( $crwsjp_opt_name );
    $crwsjp_opt_description        = get_post_meta( $post_ID, 'crwsjp_data_description', true );
    $crwsjp_opt_description        = esc_html( $crwsjp_opt_description );
    $crwsjp_opt_amount             = get_post_meta( $post_ID, 'crwsjp_data_amount', true );
    $crwsjp_opt_amount             = esc_html( $crwsjp_opt_amount );
    //税率計算
    $crwsjp_data_taxuse           = get_post_meta( $post_ID, 'crwsjp_data_taxuse', true );
    $crwsjp_data_taxrate          = get_post_meta( $post_ID, 'crwsjp_data_taxrate', true );
      if($crwsjp_data_taxuse === 'true'){
        $crwsjp_opt_amount_tax = $crwsjp_opt_amount * ($crwsjp_data_taxrate / 100) ;
        $crwsjp_opt_amount     = floor( $crwsjp_opt_amount + $crwsjp_opt_amount_tax );
      }
    //在庫管理
    $crwsjp_data_stockuse         = get_post_meta( $post_ID, 'crwsjp_data_stockuse', true );
      if(empty($crwsjp_data_stockuse)){
        $crwsjp_data_stockuse = 'false';
      }
    $crwsjp_data_stocknumber      = get_post_meta( $post_ID, 'crwsjp_data_stocknumber', true );
      if($crwsjp_data_stockuse === 'true'){
        $crwsjp_data_stockuse_count = 1;
      }else{
        $crwsjp_data_stockuse_count = 0;
      }
    $crwsjp_opt_locale             = 'auto';
    $crwsjp_opt_billing_address    = get_post_meta( $post_ID, 'crwsjp_data_billing_address', true );
    $crwsjp_opt_billing_address    = esc_html( $crwsjp_opt_billing_address );
    $crwsjp_opt_currency           = 'jpy';
    $crwsjp_opt_panel_label        = get_post_meta( $post_ID, 'crwsjp_data_panel_label', true );
    $crwsjp_opt_panel_label        = esc_html( $crwsjp_opt_panel_label );
    $crwsjp_opt_shipping_address   = get_post_meta( $post_ID, 'crwsjp_data_shipping_address', true );
    $crwsjp_opt_shipping_address   = esc_html( $crwsjp_opt_shipping_address );
    $crwsjp_opt_label              = get_post_meta( $post_ID, 'crwsjp_data_label', true );
    $crwsjp_opt_label              = esc_html( $crwsjp_opt_label );
    $crwsjp_opt_allow_remember_me  = 'false';
    $crwsjp_opt_echo_value         = get_option( 'crwsjp_algo_value' );
    $crwsjp_opt_cookie             = $_SESSION[ 'crwsjp_session' ];
    //$crwsjp_opt_allow_remember_me       = get_post_meta($post_ID, 'crwsjp_data_allow_remember_me', true);

    if ( is_user_logged_in() ) {
      global $wpdb;
      //現在表示している商品ページの固有番号
      $re_productcode = $crwsjp_opt_productcode;

      //検索現在上記商品を購入している人を検索
      $data = $wpdb->get_results( "
				SELECT post_id
				FROM $wpdb->postmeta
				WHERE meta_key = 'crwsjp_webhook_productcode'
				AND meta_value = '$re_productcode'
			" );
      //購入者を格納しているポストIDを配列化

      $postid_list = array();
      foreach ( $data as $value ) {
        array_push( $postid_list, $value->post_id );
      }

      //ポストIDより購入者のIDを取得
      $postnumber = array();
      foreach ( $postid_list as $value ) {
        $databaseADD = $wpdb->get_results( "
					SELECT meta_value
					FROM $wpdb->postmeta
					WHERE post_id = '$value'
					AND meta_key = 'crwsjp_webhook_userid'
				" );
        array_push( $postnumber, $databaseADD );
      }


      //購入者のIDを配列化
      $buyid_list = array();
      foreach ( $postnumber as $value ) {
        array_push( $buyid_list, $value[ 0 ]->meta_value );
      }

      //ユーザーIDの取得
      $userid = wp_get_current_user();
      $search_id = $userid->ID;


      //ユーザーID検索と照合
      if ( array_search( $search_id, $buyid_list ) !== false ) {
        $result_value = true;
      } else {
        $result_value = false;
      }
    }else{
      $result_value = false;
    }

    if ( is_user_logged_in() ) {
        // Output -------------------------------------------
        if ( $result_value === true ) {
          $crwsjp_contents_return = $content;
        } elseif ( $result_value === false and $crwsjp_data_stockuse === 'true' and $crwsjp_data_stocknumber  <= 0 ){
          $crwsjp_contents_return = '<div class="crwsjp-checkout-zero">販売終了</div>';
        } else {
          $crwsjp_contents_return = '<div class="">';
          $crwsjp_contents_return .= $crwsjp_opt_user_only;
          $crwsjp_contents_return .= '<form action="" method="POST"><script src="https://checkout.stripe.com/checkout.js" class="stripe-button"';
          $crwsjp_contents_return .= 'data-key="' . $crwsjp_kye[ 'publishable_key' ] . '"';
          $crwsjp_contents_return .= 'data-image ="' . $eye_img . '"';
          $crwsjp_contents_return .= 'data-name ="' . $crwsjp_opt_name . '"';
          $crwsjp_contents_return .= 'data-description ="' . $crwsjp_opt_description . '"';
          $crwsjp_contents_return .= 'data-amount ="' . $crwsjp_opt_amount . '"';
          $crwsjp_contents_return .= 'data-locale ="' . $crwsjp_opt_locale . '"';
          $crwsjp_contents_return .= 'data-billing-address ="' . $crwsjp_opt_billing_address . '"';
          $crwsjp_contents_return .= 'data-currency ="' . $crwsjp_opt_currency . '"';
          $crwsjp_contents_return .= 'data-panel-label ="' . $crwsjp_opt_panel_label . '"';
          $crwsjp_contents_return .= 'data-shipping-address ="' . $crwsjp_opt_shipping_address . '"';
          $crwsjp_contents_return .= 'data-label ="' . $crwsjp_opt_label . '"';
          $crwsjp_contents_return .= 'data-allow-remember-me ="' . $crwsjp_opt_allow_remember_me . '">';
          $crwsjp_contents_return .= '</script>';
          $crwsjp_contents_return .= '<input type="hidden" name="amount" value="' . $crwsjp_opt_amount . '">';
          $crwsjp_contents_return .= '<input type="hidden" name="description" value="' . $title . '">';
          $crwsjp_contents_return .= '<input type="hidden" name="currency" value="' . $crwsjp_opt_currency . '">';
          $crwsjp_contents_return .= '<input type="hidden" name="userid" value="' . $crwsjp_opt_userid . '">';
          $crwsjp_contents_return .= '<input type="hidden" name="itemname" value="' . $title . '">';
          $crwsjp_contents_return .= '<input type="hidden" name="daytime" value="' . date_i18n('Y-m-d H:i:s'). '">';
          $crwsjp_contents_return .= '<input type="hidden" name="stockcount" value="'.$crwsjp_data_stockuse_count.'">';
          $crwsjp_contents_return .= '<input type="hidden" name="productcode" value="' . $crwsjp_opt_productcode . '">';
          $crwsjp_contents_return .= '<input type="hidden" name="crwsjp_cookie_post" value="' . $crwsjp_opt_echo_value . '">';
          $crwsjp_contents_return .= '</form>';
          $crwsjp_contents_return .= '</div>';
        }
        // Output end ---------------------------------------
    } else {
      $crwsjp_contents_return = '<div class="">';
      $crwsjp_contents_return .= $crwsjp_opt_user_only;
      $crwsjp_contents_return .= '<p>会員の方はログインしてください。</p>';
      $crwsjp_contents_return .= '</div>';
    }

    return $crwsjp_contents_return;
  }

}