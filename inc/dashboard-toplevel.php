<?php

function crwsjp_register_setting() {
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_environment' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_publishable_testkey' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_secret_testkey' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_publishable_key' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_secret_key' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_customer_save' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_thank_you' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_denial_payment_page' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_algo_key' );
  register_setting( 'crwsjp-toplevel-group', 'crwsjp_algo_value' );
  register_setting( 'crwsjp-webhook-group',  'crwsjp_webhook_address' );
}

function crwsjp_toplevel_page() {
  wp_enqueue_media();
  wp_enqueue_style( 'crwsjp-set-css', CRWSJP_PLUGIN_URL . '/lib/css/set.css' );
  ?>
  <div id="wpbody" role="main">
    <div class="wrap">
      <h2>
        <?php echo CRWSJP_NAME;?> <small>Version <?php echo CRWSJP_VERSION;?></small>
      </h2>
      <?php
      if ( empty( $_SERVER[ 'HTTPS' ] ) ) {
        $exurl = home_url( $path = '/', $scheme = https );
        echo '<div class="error settings-error notice is-dismissible"><p><strong>サイト全体がHTTPS(SSL)で接続できるようにサーバーおよびWordPressの設定を行ってください。<br>（' . $exurl . 'というようにhttpsでアクセスできるように設定してください）</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">この通知を非表示にする</span></button></div>';
      };
      ?>

      <style>
        .tab {
          overflow: hidden;
        }

        .tab li {
          background: #ccc;
          padding: 5px 25px;
          float: left;
          margin-right: 1px;
        }

        .tab li.select {
          background: #eee;
        }

        .content li {
          background: #eee;
          padding: 20px;
        }

        .hide {
          display: none;
        }
      </style>
      <script>
        jQuery( function ( $ ) {
          $( '.tab li' ).click( function () {
            var index = $( '.tab li' ).index( this )
            $( '.content form' ).css( 'display', 'none' )
            $( '.content form' ).eq( index ).css( 'display', 'block' )
            $( '.tab li' ).removeClass( 'select' )
            $( this ).addClass( 'select' )
          } )

          $( "#crwsjp_secret_key" ).each( function () {
            $( this ).bind( 'keyup', hoge( this ) )
          } )

          function hoge( elm ) {
            var v, old = elm.value
            return function () {
              if ( old != ( v = elm.value ) ) {
                old = v
                str = $( this ).val()
                if ( str.match( /^([1-9]\d*|0)$/ ) ) {
                  $( "#textarea2" ).text( '整数' )
                } else {
                  $( "#textarea2" ).text( '整数ではない' )
                }
                //$("#textarea2").text(str)
              }
            }
          }
        } )
      </script>
      <ul class="tab">
        <li class="select">
          <?php echo crwsjp_translation_func( 'title_overall_setting' );?>
        </li>
        <li>ユーザー管理</li>
      </ul>

      <div class="content">

        <!--form method="post" action="<?php echo esc_attr($_SERVER['REQUEST_URI']);?>"-->
        <form method="post" action="options.php">
          <?php settings_fields( 'crwsjp-toplevel-group' ); ?>
          <?php do_settings_sections( 'crwsjp-toplevel-group' ); ?>
          <?php //wp_nonce_field('op','_wpnonce');?>

          <h3>
            <?php echo crwsjp_translation_func( 'title_overall_setting' );?>
          </h3>
          <p>
            <?php echo crwsjp_translation_func( 'text_setting' );?>
          </p>
          <table class="form-table">
            <tbody>
              <tr>
                <th scope="row">
                  <?php echo crwsjp_translation_func( 'title_setting_production' );?>
                </th>
                <td>
                  <?php if('flag_valid'===get_option('crwsjp_environment')){?>
                  <label><input type="radio" name="crwsjp_environment" value="flag_valid" checked='checked' ><?php echo crwsjp_translation_func( 'item_setting_production' );?></label>
                  <label><input type="radio" name="crwsjp_environment" value="flag_invalid" ><?php echo crwsjp_translation_func( 'item_setting_test' );?></label>
                  <?php }else{?>
                  <label><input type="radio" name="crwsjp_environment" value="flag_valid" ><?php echo crwsjp_translation_func( 'item_setting_production' );?></label>
                  <label><input type="radio" name="crwsjp_environment" value="flag_invalid" checked='checked' ><?php echo crwsjp_translation_func( 'item_setting_test' );?></label>
                  <?php };?>
                </td>
              </tr>
              <tr>
                <th>
                  <?php echo crwsjp_translation_func( 'item_publishablekey_test' );?>
                </th>
                <td><input type="text" id="crwsjp_publishable_testkey" name="crwsjp_publishable_testkey" size="50" value="<?php echo get_option('crwsjp_publishable_testkey'); ?>"/>
                </td>
              </tr>
              <tr>
                <th>
                  <?php echo crwsjp_translation_func( 'item_secretkey_test' );?>
                </th>
                <td><input type="text" id="crwsjp_secret_testkey" name="crwsjp_secret_testkey" size="50" value="<?php echo get_option('crwsjp_secret_testkey'); ?>"/>
                </td>
              </tr>
              <tr>
                <th>
                  <?php echo crwsjp_translation_func( 'item_publishablekey' );?>
                </th>
                <td><input type="text" id="crwsjp_publishable_key" name="crwsjp_publishable_key" size="50" value="<?php echo get_option('crwsjp_publishable_key'); ?>"/>
                </td>
              </tr>
              <tr>
                <th>
                  <?php echo crwsjp_translation_func( 'item_secretkey' );?>
                </th>
                <td><input type="text" id="crwsjp_secret_key" name="crwsjp_secret_key" size="50" value="<?php echo get_option('crwsjp_secret_key'); ?>"/>
                </td>
              </tr>
              <tr>
                <th>
                  <?php echo crwsjp_translation_func( 'item_thank_you_page' );?>
                </th>
                <td><input type="text" id="crwsjp_thank_you" name="crwsjp_thank_you" size="50" value="<?php echo get_option('crwsjp_thank_you'); ?>"/>
                  <p>
                    <?php echo crwsjp_translation_func( 'text_thank_you_page' );?>
                  </p>
                </td>
              </tr>
              <tr>
                <th>
                  <?php echo crwsjp_translation_func( 'item_denial_payment_page' );?>
                </th>
                <td><input type="text" id="crwsjp_denial_payment_page" name="crwsjp_denial_payment_page" size="50" value="<?php echo get_option('crwsjp_denial_payment_page'); ?>"/>
                  <p>
                    <?php echo crwsjp_translation_func( 'text_denial_payment_page' );?>
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
          <?php
          $crwsjp_algorithm_key = CRWSJP_ENCRYPTION::crwsjp_encryption_func();
          echo '<input type="hidden" id="crwsjp_algo_key" name="crwsjp_algo_key" value="' . $crwsjp_algorithm_key . '">';
          $crwsjp_algorithm_value = CRWSJP_ENCRYPTION::crwsjp_encryption_func();
          $crwsjp_algorithm_value = CRWSJP_OpenSSL_E::crwsjp_OpenSSL_Encoder( $crwsjp_algorithm_value, $crwsjp_algorithm_key );
          echo '<input type="hidden" id="crwsjp_algo_value" name="crwsjp_algo_value" value="' . $crwsjp_algorithm_value . '">';

          //ex)
          //$crwsjp_echo_key           = get_option('crwsjp_algo_key');
          //$crwsjp_echo_value         = get_option('crwsjp_algo_value');
          //$crwsjp_restoration_value  = CRWSJP_OpenSSL_D::crwsjp_OpenSSL_Decoder( $crwsjp_echo_value, $crwsjp_echo_key );
          ?>


          <?php submit_button(); ?>

        </form>

        <form method="post" action="options.php" class="hide">
          <?php settings_fields( 'crwsjp-webhook-group' ); ?>
          <?php do_settings_sections( 'crwsjp-webhook-group' ); ?>
          <h3>
            <?php echo crwsjp_translation_func( 'title_users_setting' );?>
          </h3>
          <p>アドレスはランダムに出力されます。</p>
          <p>Webhook側に403エラーなどが通知される場合はサーバー側のWAFの設定を見直すなどしてWebhookが使用できるか確認をしてください</p>
          <?php
          $crwsjp_wordpressurl = admin_url();
          $crwsjp_webhook_url = CRWSJP_ENCRYPTION::crwsjp_encryption_func();
          $crwsjp_webhook_get = get_option( 'crwsjp_webhook_address' );
          if ( !isset( $crwsjp_webhook_get ) ) {
            echo 'Webhookアドレスを下記のアドレスに設定します。変更保存をクリックしてください。<br>';
            echo $crwsjp_wordpressurl . 'admin-ajax.php?action=' . $crwsjp_webhook_url;
            echo '<input type="hidden" name="crwsjp_webhook_address" value="' . $crwsjp_webhook_url . '">';
          } else {
            if ( !empty( $crwsjp_webhook_get ) ) {
              echo '現在下記のアドレスが設定設定されています。<br>';
              echo '<input type="text" value="' . $crwsjp_wordpressurl . 'admin-ajax.php?action=' . $crwsjp_webhook_get . '" style="width:100%" readonly="readonly"/>';
              echo 'Webhookアドレスを下記のアドレスに変更する場合は変更保存をクリックしてください。<br>';
              echo $crwsjp_wordpressurl . 'admin-ajax.php?action=' . $crwsjp_webhook_url;
              echo '<input type="hidden" name="crwsjp_webhook_address" value="' . $crwsjp_webhook_url . '">';
            } else {
              echo 'Webhookアドレスを下記のアドレスに設定します。変更保存をクリックしてください。<br>';
              echo $crwsjp_wordpressurl . 'admin-ajax.php?action=' . $crwsjp_webhook_url;
              echo '<input type="hidden" name="crwsjp_webhook_address" value="' . $crwsjp_webhook_url . '">';
            }
          }
          if ( empty( $_SERVER[ 'HTTPS' ] ) ) {
            echo '<div class="sptmp-warning"><p>受信アドレスの設定ができません。HTTPS(SSL)の設定を行ってください。</p></div>';
          }
          ?>
          <?php submit_button(); ?>
        </form>

        <form method="post" action="options.php" class="hide">
          <h3>
            <?php echo crwsjp_translation_func( 'title_subscription_setting' );?>
          </h3>

        </form>

      </div>

    </div>
  </div>
  <?php
}