<?php
/*
=================================================
Custom Post Type ITEM
================================================= */
class CRWSJP_PostItemCLASS {
  function __construct() {
    add_action( 'init', array( $this, 'action_custom_init' ) );
  }
  // Single Instance check ------------------------------------
  protected static $instance_postitem_ob = null;
  public static
  function instance_postitem_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_postitem_ob ) {
      self::$instance_postitem_ob = new self;
    }
    return self::$instance_postitem_ob;
    // Single Instance check end.------------------------------------
  }
  public
  function action_custom_init() {
    $labels = array(
      'name'                => crwsjp_translation_func( 'custom_post_name' ),
      'singular_name'       => 'StripeItem',
      'add_new'             => crwsjp_translation_func( 'custom_post_add_new' ),
      'add_new_item'        => crwsjp_translation_func( 'custom_post_add_new_item' ),
      'edit_item'           => crwsjp_translation_func( 'custom_post_edit_item' ),
      'new_item'            => crwsjp_translation_func( 'custom_post_new_item' ),
      'all_items'           => crwsjp_translation_func( 'custom_post_all_items' ),
      'view_item'           => crwsjp_translation_func( 'custom_post_view_item' ),
      'search_items'        => crwsjp_translation_func( 'custom_post_search_items' ),
      'not_found'           => crwsjp_translation_func( 'custom_post_not_found' ),
      'not_found_in_trash'  => crwsjp_translation_func( 'custom_post_not_found_trash' ),
      'parent_item_colon'   => '',
      'menu_name'           => crwsjp_translation_func( 'custom_post_menu_name' ),
    );
    $args = array(
      'labels'              => $labels,
      'public'              => true,
      'publicly_queryable'  => false, //false
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_rest'        => false,
      'query_var'           => true,
      'rewrite'             => array( 'slug' => 'crwsjp_stripe_item' ),
      'capability_type'     => 'post',
      'has_archive'         => false, //false
      'hierarchical'        => false, //false
      'exclude_from_search' => true,
      'menu_position'       => null,
      'supports'            => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'crwsjp_stripe_item', $args );
  }
}


/*
=================================================
Setting
================================================= */
class CRWSJP_CustomCieldsCLASS {

  function __construct() {
    add_action( 'admin_menu', array( $this, 'action_custom_fields' ) );
    add_action( 'save_post', array( $this, 'save_crwsjp_item_fields' ) );
  }

  // Single Instance check ------------------------------------
  protected static $instance_custom_fields_ob = null;
  public static
  function instance_custom_fields_ob_get() {
    // Single Instance Configuration Branch
    if ( null == self::$instance_custom_fields_ob ) {
      self::$instance_custom_fields_ob = new self;
    }
    return self::$instance_custom_fields_ob;
    // Single Instance check end.------------------------------------
  }

  public
  function action_custom_fields() {
    // shortcode meta box
    add_meta_box(
      'crwsjp_shortcode_setting',
      crwsjp_translation_func( 'shortcode_name' ),
      array( $this, 'crwsjp_shortcode_fields' ),
      'crwsjp_stripe_item',
      'normal'
    );

    //user_only meta box
    add_meta_box(
      'crwsjp_user_only_setting',
      '商品説明',
      array( $this, 'crwsjp_user_only_fields' ),
      'crwsjp_stripe_item',
      'normal'
    );

    // data-name meta box
    add_meta_box(
      'crwsjp_data_name_setting',
      crwsjp_translation_func( 'data_name_name' ),
      array( $this, 'crwsjp_data_name_fields' ),
      'crwsjp_stripe_item',
      'normal'
    );

    // data-description meta box
    add_meta_box(
      'crwsjp_data_description_setting',
      crwsjp_translation_func( 'data_description_name' ),
      array( $this, 'crwsjp_data_description_fields' ),
      'crwsjp_stripe_item',
      'normal'
    );

    // data-amount meta box
    add_meta_box(
      'crwsjp_data_amount_setting',
      crwsjp_translation_func( 'data_amount_name' ),
      array( $this, 'crwsjp_data_amount_fields' ),
      'crwsjp_stripe_item',
      'side'
    );

    // stock meta box
    add_meta_box(
      'crwsjp_data_stock_setting',
      '在庫数',
      array( $this, 'crwsjp_data_stock_fields' ),
      'crwsjp_stripe_item',
      'side'
    );

    // data-zip-code meta box
    /*
    add_meta_box(
    	'crwsjp_data_zip_code_setting',
    	crwsjp_translation_func( 'data_zip_code_name' ),
    	array( $this, 'crwsjp_data_zip_code_fields'),
    	'crwsjp_stripe_item',
    	'side'
    );
    */

    // data-billing-address meta box
    add_meta_box(
      'crwsjp_data_billing_address_setting',
      crwsjp_translation_func( 'data_billing_address_name' ),
      array( $this, 'crwsjp_data_billing_address_fields' ),
      'crwsjp_stripe_item',
      'side'
    );

    //data-panel-label meta box
    add_meta_box(
      'crwsjp_data_panel_label_setting',
      crwsjp_translation_func( 'data_panel_label_name' ),
      array( $this, 'crwsjp_data_panel_label_fields' ),
      'crwsjp_stripe_item',
      'normal'
    );

    //data_shipping_address meta box
    /*add_meta_box(
      'crwsjp_data_shipping_address_setting',
      crwsjp_translation_func( 'data_shipping_address_name' ),
      array( $this, 'crwsjp_data_shipping_address_fields' ),
      'crwsjp_stripe_item',
      'side'
    );*/

    //data_label meta box
    add_meta_box(
      'crwsjp_data_label_setting',
      crwsjp_translation_func( 'data_label_name' ),
      array( $this, 'crwsjp_data_label_fields' ),
      'crwsjp_stripe_item',
      'normal'
    );

  }

  /*
  ------------------------------------------
  Post
  ------------------------------------------ */
  // shortcode
  public
  function crwsjp_shortcode_fields() {
    $posingid = get_the_ID();
    echo '<p>' . crwsjp_translation_func( 'shortcode_fields_text' ) . '</p>';
    echo crwsjp_translation_func( 'shortcode_title' ) . '<input type="text" value="[crwsjp_checkout id=&#34;' . $posingid . '&#34;]" style="width:100%" readonly="readonly"/>';
    echo '<hr>';
    echo '<p>' . crwsjp_translation_func( 'identification_fields_text' ) . '</p>';
    global $post;
    $crwsjp_identification_code = get_post_meta( $post->ID, 'crwsjp_identification_code', true );
    if ( is_null( $crwsjp_identification_code ) || $crwsjp_identification_code === 1 || $crwsjp_identification_code === "" || $crwsjp_identification_code === "0" || $crwsjp_identification_code === array() || $crwsjp_identification_code === array( 1 ) ) {
      $str_r = 'CRWSJP-' . $posingid . '-';
      $str_r .= md5( uniqid( rand(), true ) );
      echo crwsjp_translation_func( 'identification_title' ) . '<strong>' . $str_r . '</strong>';
      echo '<input type="hidden" id="crwsjp_identification_code" name="crwsjp_identification_code" value="' . $str_r . '">';
    } else {
      echo crwsjp_translation_func( 'identification_title' ) . '<input type="text" value="' . $crwsjp_identification_code . '" style="width:100%" readonly="readonly"/>';
      echo '<input type="hidden" id="crwsjp_identification_code" name="crwsjp_identification_code" value="' . $crwsjp_identification_code . '">';
    }
  }

  // user_only
  function crwsjp_user_only_fields() {
    global $post;
    echo '<p>商品説明を入力してください。</p>';
    echo '<textarea name="crwsjp_user_only" rows="4" style="width:100%">' . get_post_meta( $post->ID, 'crwsjp_user_only', true ) . '</textarea><br>';
  }

  // data-name
  function crwsjp_data_name_fields() {
    global $post;
    $crwsjp_data_name_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_data_name', true ) );
    echo '<p>' . crwsjp_translation_func( 'crwsjp_data_name_text' ) . '</p>';
    echo '<input type="text" name="crwsjp_data_name" value="' . $crwsjp_data_name_esc . '" style="width:100%" />';
  }

  // data-description
  function crwsjp_data_description_fields() {
    global $post;
    $crwsjp_data_description_esc = esc_html( get_post_meta( $post->ID, 'crwsjp_data_description', true ) );
    echo '<p>' . crwsjp_translation_func( 'crwsjp_data_description_text' ) . '</p>';
    echo '<input type="text" id="crwsjp_data_description" name="crwsjp_data_description" value="' . $crwsjp_data_description_esc . '" style="width:100%" />';
    echo '<span>' . crwsjp_translation_func( 'crwsjp_validation_discriptionCD' ) . '</span><span id="description-validation"></span>';
  }

  // data-amount
  function crwsjp_data_amount_fields() {
    global $post;
    $crwsjp_data_amount_esc   = esc_html( get_post_meta( $post->ID, 'crwsjp_data_amount', true ) );
    $crwsjp_data_taxrate_esc  = esc_html( get_post_meta( $post->ID, 'crwsjp_data_taxrate', true ) );
    $crwsjp_data_taxrate      = get_post_meta( $post->ID, 'crwsjp_data_taxrate', true );

    echo '<label><input type="text" id="crwsjp_data_amount" name="crwsjp_data_amount" value="' . $crwsjp_data_amount_esc . '" /> 円</label><br>';
    //echo '<p><strong>'.crwsjp_translation_func( 'crwsjp_data_amount_text01' ).'</strong> <a href="'.crwsjp_translation_func( 'crwsjp_data_amount_url' ).'" target="_blank">'.crwsjp_translation_func( 'crwsjp_data_amount_urltext' ).'</a></p>';
    echo '<span id="amount-validation" class="validation_set">' . crwsjp_translation_func( 'crwsjp_validation_int' ) . '</span>';

    if ( 'true' === get_post_meta( $post->ID, 'crwsjp_data_taxuse', true ) ) {
      echo '<div class="crwsjp-tax-fieldbox">';
      echo '<span class="crwsjp-tax-title">税率</span>';
      echo '<label><input type="radio" name="crwsjp_data_taxuse" value="false" >内税</label>';
      echo '<label><input type="radio" name="crwsjp_data_taxuse" value="true" checked="checked">外税</label>';
      if ( !empty($crwsjp_data_taxrate_esc)) {
        echo '<label><input type="text" id="crwsjp_data_taxrate" name="crwsjp_data_taxrate" value="' . $crwsjp_data_taxrate_esc . '" /> ％</label><br>';
      }else{
        echo '<label><input type="text" id="crwsjp_data_taxrate" name="crwsjp_data_taxrate" value="8" /> ％</label><br>';
      }
      echo '</div>';
    } else {
      echo '<div class="crwsjp-tax-fieldbox">';
      echo '<span class="crwsjp-tax-title">税率</span>';
      echo '<label><input type="radio" name="crwsjp_data_taxuse" value="false" checked="checked">内税</label>';
      echo '<label><input type="radio" name="crwsjp_data_taxuse" value="true" >外税</label>';
      if ( !empty($crwsjp_data_taxrate_esc)) {
        echo '<label><input type="text" id="crwsjp_data_taxrate" name="crwsjp_data_taxrate" value="'. $crwsjp_data_taxrate_esc .'" /> ％</label><br>';
      }else{
        echo '<label><input type="text" id="crwsjp_data_taxrate" name="crwsjp_data_taxrate" value="8" /> ％</label><br>';
      }
      echo '</div>';
    }
    echo '<span id="tax-validation" class="validation_set">' . crwsjp_translation_func( 'crwsjp_validation_int' ) . '</span>';
  }

  // data-shipping-address
  function crwsjp_data_stock_fields() {
    global $post;
    $crwsjp_data_stocknumber_esc   = esc_html( get_post_meta( $post->ID, 'crwsjp_data_stocknumber', true ) );
    if ( 'true' === get_post_meta( $post->ID, 'crwsjp_data_stockuse', true ) ) {
      echo '<span class="crwsjp-stock-title">在庫数機能の利用</span>';
      echo '<div class="crwsjp-stock-fieldbox">';
      echo '<label><input type="radio" name="crwsjp_data_stockuse" value="true" checked="checked">' . crwsjp_translation_func( 'flag_valid' ) . '</label>';
      echo '<label><input type="radio" name="crwsjp_data_stockuse" value="false" >' . crwsjp_translation_func( 'flag_invalid' ) . '</label>';
      echo '</div>';
    } else {
      echo '<span class="crwsjp-stock-title">在庫数機能の利用</span>';
      echo '<div class="crwsjp-stock-fieldbox">';
      echo '<label><input type="radio" name="crwsjp_data_stockuse" value="true" >' . crwsjp_translation_func( 'flag_valid' ) . '</label>';
      echo '<label><input type="radio" name="crwsjp_data_stockuse" value="false" checked="checked">' . crwsjp_translation_func( 'flag_invalid' ) . '</label>';
      echo '</div>';
    }
     echo '<span class="crwsjp-stock-title">数量</span>';
     echo '<input type="text" id="crwsjp_data_stocknumber" name="crwsjp_data_stocknumber" value="' . $crwsjp_data_stocknumber_esc . '" /><br>';
     echo '<span id="stock-validation" class="validation_set">' . crwsjp_translation_func( 'crwsjp_validation_int' ) . '</span>';
  }

  // data-zip-code
  /*function crwsjp_data_zip_code_fields() {
  	global $post;
  	if('true' === get_post_meta($post->ID, 'crwsjp_data_zip_code', true)){
  		echo '<input type="radio" name="crwsjp_data_zip_code" value="true" checked="checked" >'.crwsjp_translation_func( 'flag_valid' );
  		echo '<input type="radio" name="crwsjp_data_zip_code" value="false" >'.crwsjp_translation_func( 'flag_invalid' );
  	}else{
  		echo '<input type="radio" name="crwsjp_data_zip_code" value="true" >'.crwsjp_translation_func( 'flag_valid' );
  		echo '<input type="radio" name="crwsjp_data_zip_code" value="false" checked="checked" >'.crwsjp_translation_func( 'flag_invalid' );
  	}
  }*/

  // data-billing-address
  function crwsjp_data_billing_address_fields() {
    global $post;
    if ( 'true' === get_post_meta( $post->ID, 'crwsjp_data_billing_address', true ) ) {
      echo '<label><input type="radio" name="crwsjp_data_billing_address" value="true" checked="checked" >' . crwsjp_translation_func( 'flag_valid' ). '</label>';
      echo '<label><input type="radio" name="crwsjp_data_billing_address" value="false" >' . crwsjp_translation_func( 'flag_invalid' ). '</label>';
    } else {
      echo '<label><input type="radio" name="crwsjp_data_billing_address" value="true" >' . crwsjp_translation_func( 'flag_valid' ). '</label>';
      echo '<label><input type="radio" name="crwsjp_data_billing_address" value="false" checked="checked" >' . crwsjp_translation_func( 'flag_invalid' ). '</label>';
    }
  }

  // data-panel-label
  function crwsjp_data_panel_label_fields() {
    global $post;
    echo '<p>' . crwsjp_translation_func( 'data_panel_label_text1' ) . '<br>';
    echo crwsjp_translation_func( 'data_panel_label_text2' ) . '<br>';
    echo crwsjp_translation_func( 'data_panel_label_text3' ) . '</p>';
    echo '<input type="text" name="crwsjp_data_panel_label" value="' . get_post_meta( $post->ID, 'crwsjp_data_panel_label', true ) . '" />';
  }

  // data-shipping-address
  /*function crwsjp_data_shipping_address_fields() {
    global $post;
    if ( 'true' === get_post_meta( $post->ID, 'crwsjp_data_shipping_address', true ) ) {
      echo '<label><input type="radio" name="crwsjp_data_shipping_address" value="true" checked="checked">' . crwsjp_translation_func( 'flag_valid' ). '</label>';
      echo '<label><input type="radio" name="crwsjp_data_shipping_address" value="false" >' . crwsjp_translation_func( 'flag_invalid' ). '</label>';
    } else {
      echo '<label><input type="radio" name="crwsjp_data_shipping_address" value="true" >' . crwsjp_translation_func( 'flag_valid' ). '</label>';
      echo '<label><input type="radio" name="crwsjp_data_shipping_address" value="false" checked="checked">' . crwsjp_translation_func( 'flag_invalid' ). '</label>';
    }
  }*/

  // data-label
  function crwsjp_data_label_fields() {
    global $post;
    echo '<p>' . crwsjp_translation_func( 'data_label_text' ) . '</p>';
    echo '<input type="text" name="crwsjp_data_label" value="' . get_post_meta( $post->ID, 'crwsjp_data_label', true ) . '" /><br>';
  }


  /*
  ------------------------------------------
  Save
  ------------------------------------------ */
  public
  function save_crwsjp_item_fields( $post_id ) {
    //data-name
    if ( !empty( $_POST[ 'crwsjp_data_name' ] ) ) {
      $crwsjp_post_name_esc = esc_html( $_POST[ 'crwsjp_data_name' ] );
      update_post_meta( $post_id, 'crwsjp_data_name', $crwsjp_post_name_esc );
    } elseif ( $_POST[ 'crwsjp_data_name' ] === array( 1 ) ) {
      delete_post_meta( $post_id, 'crwsjp_data_name' );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_name' );
    }

    if ( !empty( $_POST[ 'crwsjp_identification_code' ] ) ) {
      update_post_meta( $post_id, 'crwsjp_identification_code', $_POST[ 'crwsjp_identification_code' ] );
    } elseif ( $_POST[ 'crwsjp_identification_code' ] === array( 1 ) ) {
      delete_post_meta( $post_id, 'crwsjp_identification_code' );
    } else {
      delete_post_meta( $post_id, 'crwsjp_identification_code' );
    }

    //data-description
    if ( !empty( $_POST[ 'crwsjp_data_description' ] ) ) {
      $crwsjp_post_description_esc = esc_html( $_POST[ 'crwsjp_data_description' ] );
      update_post_meta( $post_id, 'crwsjp_data_description', $crwsjp_post_description_esc );
    } elseif ( $_POST[ 'crwsjp_data_description' ] === array( 1 ) ) {
      delete_post_meta( $post_id, 'crwsjp_data_description' );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_description' );
    }

    //data-amount
    if ( !empty( $_POST[ 'crwsjp_data_amount' ] ) ) {
      if ( ctype_digit( $_POST[ 'crwsjp_data_amount' ] ) ) {
        $crwsjp_post_amount_esc = esc_html( $_POST[ 'crwsjp_data_amount' ] );
        update_post_meta( $post_id, 'crwsjp_data_amount', $crwsjp_post_amount_esc );
      } else {
        delete_post_meta( $post_id, 'crwsjp_data_amount' );
      }
    } elseif ( $_POST[ 'crwsjp_data_amount' ] === array( 1 ) ) {
      delete_post_meta( $post_id, 'crwsjp_data_amount' );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_amount' );
    }

    //data_taxuse
    if ( !empty( $_POST[ 'crwsjp_data_taxuse' ] ) ) {
      update_post_meta( $post_id, 'crwsjp_data_taxuse', $_POST[ 'crwsjp_data_taxuse' ] );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_taxuse' );
    }

    //data_taxrate
    if ( !empty( $_POST[ 'crwsjp_data_taxrate' ] ) ) {
      if ( ctype_digit( $_POST[ 'crwsjp_data_taxrate' ] ) ) {
        $crwsjp_data_taxrate_esc = esc_html( $_POST[ 'crwsjp_data_taxrate' ] );
        update_post_meta( $post_id, 'crwsjp_data_taxrate', $crwsjp_data_taxrate_esc );
      } else {
        update_post_meta( $post_id, 'crwsjp_data_taxrate', 8 );
      }
    } elseif ( $_POST[ 'crwsjp_data_taxrate' ] === array( 1 ) ) {
      update_post_meta( $post_id, 'crwsjp_data_taxrate', 8 );
    } else {
      update_post_meta( $post_id, 'crwsjp_data_taxrate', 8 );
    }


    //data_stockuse
    if ( !empty( $_POST[ 'crwsjp_data_stockuse' ] ) ) {
      update_post_meta( $post_id, 'crwsjp_data_stockuse', $_POST[ 'crwsjp_data_stockuse' ] );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_stockuse' );
    }

    //data_stocknumber
    if ( !empty( $_POST[ 'crwsjp_data_stocknumber' ] ) ) {
      if ( ctype_digit( $_POST[ 'crwsjp_data_stocknumber' ] ) ) {
        $crwsjp_data_stocknumber_esc = esc_html( $_POST[ 'crwsjp_data_stocknumber' ] );
        update_post_meta( $post_id, 'crwsjp_data_stocknumber', $crwsjp_data_stocknumber_esc );
      } else {
        update_post_meta( $post_id, 'crwsjp_data_stocknumber', 0 );
      }
    } elseif ( $_POST[ 'crwsjp_data_stocknumber' ] === array( 1 ) ) {
      update_post_meta( $post_id, 'crwsjp_data_stocknumber', 0 );
    } else {
      update_post_meta( $post_id, 'crwsjp_data_stocknumber', 0 );
    }


    //data-zip-code
    /*
    if(!empty($_POST['crwsjp_data_zip_code'])){
    	$crwsjp_post_zip_code_esc = esc_html( $_POST['crwsjp_data_zip_code'] );
    	update_post_meta($post_id, 'crwsjp_data_zip_code', $crwsjp_post_zip_code_esc );
    }else{
    	delete_post_meta($post_id, 'crwsjp_data_zip_code');
    }
    */

    //data-billing-address
    if ( !empty( $_POST[ 'crwsjp_data_billing_address' ] ) ) {
      $crwsjp_post_billing_address_esc = esc_html( $_POST[ 'crwsjp_data_billing_address' ] );
      update_post_meta( $post_id, 'crwsjp_data_billing_address', $crwsjp_post_billing_address_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_billing_address' );
    }

    //data-panel-label
    if ( !empty( $_POST[ 'crwsjp_data_panel_label' ] ) ) {
      update_post_meta( $post_id, 'crwsjp_data_panel_label', $_POST[ 'crwsjp_data_panel_label' ] );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_panel_label' );
    }

    //data-shipping-address
  /*if ( !empty( $_POST[ 'crwsjp_data_shipping_address' ] ) ) {
      update_post_meta( $post_id, 'crwsjp_data_shipping_address', $_POST[ 'crwsjp_data_shipping_address' ] );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_shipping_address' );
    }*/

    //data-label
    if ( !empty( $_POST[ 'crwsjp_data_label' ] ) ) {
      update_post_meta( $post_id, 'crwsjp_data_label', $_POST[ 'crwsjp_data_label' ] );
    } else {
      delete_post_meta( $post_id, 'crwsjp_data_label' );
    }


    //user_only
    if ( !empty( $_POST[ 'crwsjp_user_only' ] ) ) {
      $allowed_html = wp_kses_allowed_html( 'post' );
      $crwsjp_user_only_esc = wp_kses( $_POST[ 'crwsjp_user_only' ], $allowed_html );
      update_post_meta( $post_id, 'crwsjp_user_only', $crwsjp_user_only_esc );
    } else {
      delete_post_meta( $post_id, 'crwsjp_user_only' );
    }


  }

}


/*
=================================================
Setting
================================================= */
// 一覧表のカスタマイズ
function add_crwsjp_posts_columns( $columns ) {
  unset($columns['title']); // タイトル
  unset($columns['date']); // 日付
  $columns[ 'title'                     ] = '商品名';
  $columns[ 'date'                      ] = '登録日';
  $columns[ 'crwsjp_data_amount'        ] = '価格/税率';
  //$columns[ 'crwsjp_data_taxuse'        ] = '税率';
  //$columns[ 'crwsjp_data_stockuse'      ] = '在庫管理';
  $columns[ 'crwsjp_data_stocknumber'   ] = '在庫数/管理';
  $columns[ 'postid'                    ] = 'Shortcode';
  $columns[ 'thumbnail'                 ] = 'サムネイル';
  return $columns;
}

function add_crwsjp_posts_columns_row( $column_name, $post_id ) {
  // ----------------------------------------------------
  //サムネイル
  if ( 'thumbnail' == $column_name ) {
    $thumb = get_the_post_thumbnail( $post_id, array( 50, 50 ), 'thumbnail' );
    echo( $thumb ) ? $thumb : '－';
  }
  // ----------------------------------------------------
  //ショートコード
  if ( 'postid' == $column_name ) {
    echo '[crwsjp_checkout id="' . $post_id . '"]';
  }
  // ----------------------------------------------------
  //価格 税率
  if ( 'crwsjp_data_amount' == $column_name ) {
    echo get_post_meta($post_id, 'crwsjp_data_amount', true).'円 / ';
    if( get_post_meta($post_id, 'crwsjp_data_taxuse', true) === "true" ){
      echo '外税';
      echo '（'.get_post_meta($post_id, 'crwsjp_data_taxrate', true).'％）';
    }elseif( get_post_meta($post_id, 'crwsjp_data_taxuse', true) === "false" ){
      echo '内税';
    }else{
      echo '内税';
    }
  }

  // ----------------------------------------------------
  //在庫機能
  if ( 'crwsjp_data_stocknumber' == $column_name ) {
   if( get_post_meta($post_id, 'crwsjp_data_stocknumber', true) === "" ){
      echo '未登録';
    }else{
      echo get_post_meta($post_id, 'crwsjp_data_stocknumber', true).'点';
    }
    echo ' / ';
    if( get_post_meta($post_id, 'crwsjp_data_stockuse', true) === "true" ){
      echo '有効';
    }elseif( get_post_meta($post_id, 'crwsjp_data_stockuse', true) === "false" ){
      echo '無効';
    }else{
      echo '未設定';
    }

  }

}
add_filter( 'manage_edit-crwsjp_stripe_item_columns', 'add_crwsjp_posts_columns' );
add_action( 'manage_posts_custom_column', 'add_crwsjp_posts_columns_row', 10, 2 );
