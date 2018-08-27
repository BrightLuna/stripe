<?php

/*
=================================================
String encryption
================================================= */
class CRWSJP_ENCRYPTION {
  function crwsjp_encryption_func() {
    $datatime = time();
    $length = 10;
    $str = array_merge( range( 'a', 'z' ), range( '0', '9' ), range( 'A', 'Z' ) );
    $r_str = null;
    for ( $i = 0; $i < $length; $i++ ) {
      $r_str .= $str[ rand( 0, count( $str ) - 1 ) ];
    }
    $datatime = $datatime . $r_str;
    $password = rand();
    $method = 'aes-128-cbc';
    $ivLength = openssl_cipher_iv_length( $method );
    $iv = openssl_random_pseudo_bytes( $ivLength );
    $options = 0;
    $encrypted = openssl_encrypt( $datatime, $method, $password, $options, $iv );
    $str = $encrypted;
    $search = array( '\\', '-', '_', '.', '!', ",", '*', '(', ')', '<', '>', '#', '"', '%', '{', '}', '|', '^', '[', ']', '`', ':', '?', '/', '?', ':', '@', '%', '!', '$', '&', '(', ')', '*', '+', ',', ';', '=', '-', '.', '_' );
    $replace = array( '', '', '', '', '', "", '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' );
    $result = str_replace( $search, $replace, $str );
    return $result;
  }
}


/*
=================================================
IP address checklist
ex) https://stripe.com/docs/ips
================================================= */
class CRWSJP_IP_Stripe {
  function crwsjp_stripe_IP_Addresses() {
    $ip_addresses_list = array(
      '54.187.174.169',
      '54.187.205.235',
      '54.187.216.72',
      '54.241.31.99',
      '54.241.31.102',
      '54.241.34.107',
    );
    foreach ( $ip_addresses_list as $valued ) {
      $ip2Long = ip2long( $valued );
      if ( !isset( $ip_result_list ) ) {
        $ip_result_list = array( $ip2Long );
      } else {
        array_push( $ip_result_list, $ip2Long );
      }
    }
    return $ip_result_list;
  }
}


/*
=================================================
OpenSSL
================================================= */
class CRWSJP_OpenSSL_E {
  function crwsjp_OpenSSL_Encoder( $data, $password ) {
    $encrypted = openssl_encrypt( $data, 'aes-256-ecb', $password );
    $result_e = $encrypted;
    return $result_e;
  }
}

class CRWSJP_OpenSSL_D {
  function crwsjp_OpenSSL_Decoder( $algorithm, $password ) {
    $decrypted = openssl_decrypt( $algorithm, 'aes-256-ecb', $password );
    $result_d = $decrypted;
    return $result_d;
  }
}


/*
=================================================
 API keys
================================================= */
class CRWSJP_APIkeys {
  function crwsjp_stripe_APIkeys() {
    $crwsjp_environment_check = get_option( 'crwsjp_environment' );
    if ( !isset( $crwsjp_environment_check ) ) {
      //NULL or variable not defined.
      $stripe = array(
        "secret_key" => NULL,
        "publishable_key" => NULL
      );
    } else {
      //In case of empty, check here by empty as this is output.
      if ( !empty( $crwsjp_webhook_get ) ) {
        //If there is a variable and 0 or '0', this is output if array ().
        $stripe = array(
          "secret_key" => NULL,
          "publishable_key" => NULL
        );
      } else {
        //Processing when there is any variable.
        //---------------------------------------
        if ( 'flag_valid' === $crwsjp_environment_check ) {
          $crwsjp_secret_key_check = get_option( 'crwsjp_secret_key' );
          $crwsjp_publishable_key_check = get_option( 'crwsjp_publishable_key' );
          $stripe = array(
            "secret_key" => $crwsjp_secret_key_check,
            "publishable_key" => $crwsjp_publishable_key_check
          );
        } elseif ( 'flag_invalid' === $crwsjp_environment_check ) {
            $crwsjp_secret_testkey_check = get_option( 'crwsjp_secret_testkey' );
            $crwsjp_publishable_testkey_check = get_option( 'crwsjp_publishable_testkey' );
            $stripe = array(
              "secret_key" => $crwsjp_secret_testkey_check,
              "publishable_key" => $crwsjp_publishable_testkey_check
            );
          } else {
            $stripe = array(
              "secret_key" => NULL,
              "publishable_key" => NULL
            );
          }
          //---------------------------------------
      }
    }
    return $stripe;
  }
}