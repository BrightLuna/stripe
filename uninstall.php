<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
  exit();

function crebow_delete_plugin() {
  global $wpdb;
  delete_option( 'crwsjp_environment' );
  delete_option( 'crwsjp_publishable_testkey' );
  delete_option( 'crwsjp_secret_testkey' );
  delete_option( 'crwsjp_publishable_key' );
  delete_option( 'crwsjp_secret_key' );
  delete_option( 'crwsjp_customer_save' );
  delete_option( 'crwsjp_thank_you' );
  delete_option( 'crwsjp_denial_payment_page' );
  delete_option( 'crwsjp_algo_key' );
  delete_option( 'crwsjp_algo_value' );
  delete_option( 'crwsjp_webhook_address' );
  delete_option( 'crwsjp_mail_address _submit' );
  delete_option( 'crwsjp_mail_address _reception' );
  delete_option( 'crwsjp_mail_type' );
  delete_option( 'crwsjp_mail_smtp_host' );
  delete_option( 'crwsjp_mail_smtp_port' );
  delete_option( 'crwsjp_mail_smtp_id' );
  delete_option( 'crwsjp_mail_smtp_pass' );
  delete_option( 'crwsjp_mail_smtp_ssl' );
  delete_option( 'crwsjp_mail_submit_name' );
  delete_option( 'crwsjp_mail_submit_title_customer' );
  delete_option( 'crwsjp_mail_submit_title_manager' );
  delete_option( 'crwsjp_mail_submit_greeting_text' );
  delete_option( 'crwsjp_mail_submit_footer_text' );

}
crebow_delete_plugin();

?>
