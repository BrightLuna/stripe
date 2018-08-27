<?php

function crwsjp_translation_func( $translation_crwsjp ) {
  //  ------------------------------------------
  //  Common
  //  ------------------------------------------
  if ( 'flag_valid' === $translation_crwsjp ) {
    return __( '有効', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'flag_invalid' === $translation_crwsjp ) {
    return __( '無効', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'warning_nyuryoku' === $translation_crwsjp ) {
    return __( '以下の設定を正しく入力してください', 'crwsjp-stripe-jp-payment' );
  }

  //  ------------------------------------------
  // Management setting
  //  ------------------------------------------
  if ( 'title_overall_setting' === $translation_crwsjp ) {
    return __( '全体設定', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'title_users_setting' === $translation_crwsjp ) {
    return __( 'ユーザー管理', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'title_subscription_setting' === $translation_crwsjp ) {
    return __( 'サブスクリプション', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'text_setting' === $translation_crwsjp ) {
    return __( 'Stripeの設定情報を入力します。', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'title_setting_production' === $translation_crwsjp ) {
    return __( '公開設定', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_setting_production' === $translation_crwsjp ) {
    return __( '公開環境', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_setting_test' === $translation_crwsjp ) {
    return __( 'テスト環境', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_secretkey_test' === $translation_crwsjp ) {
    return __( 'シークレットキー ( Test )', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_publishablekey_test' === $translation_crwsjp ) {
    return __( '公開可能キー ( Test )', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_secretkey' === $translation_crwsjp ) {
    return __( 'シークレットキー', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_publishablekey' === $translation_crwsjp ) {
    return __( '公開可能キー', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_thank_you_page' === $translation_crwsjp ) {
    return __( '決済完了リダイレクト', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'text_thank_you_page' === $translation_crwsjp ) {
    return __( '決済完了ページを独自に設定したい場合はURLを入力してください。(通常はスラッグ名crwsjp-success-pageが表示されます。crwsjp-success-pageがない場合はトップページが表示されます)', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'item_denial_payment_page' === $translation_crwsjp ) {
    return __( '決済失敗リダイレクト', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'text_denial_payment_page' === $translation_crwsjp ) {
    return __( '決済失敗ページを独自に設定したい場合はURLを入力してください。(通常はスラッグ名crwsjp-failure-pageが表示されます。crwsjp-failure-pageがない場合はトップページが表示されます)', 'crwsjp-stripe-jp-payment' );
  }

  //  ------------------------------------------
  //  Create item
  //  ------------------------------------------
  if ( 'custom_post_name' === $translation_crwsjp ) {
    return __( 'アイテム（Stripe決済専用）', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_add_new' === $translation_crwsjp ) {
    return __( 'アイテムを作成', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_add_new_item' === $translation_crwsjp ) {
    return __( '新しいアイテムを登録', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_edit_item' === $translation_crwsjp ) {
    return __( 'アイテムを編集', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_new_item' === $translation_crwsjp ) {
    return __( 'New item', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_all_items' === $translation_crwsjp ) {
    return __( '全てのアイテム', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_view_item' === $translation_crwsjp ) {
    return __( 'View item', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_search_items' === $translation_crwsjp ) {
    return __( 'アイテムを検索', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_not_found' === $translation_crwsjp ) {
    return __( 'アイテムはありません', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_not_found_trash' === $translation_crwsjp ) {
    return __( 'ゴミ箱にアイテムはありません', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_post_menu_name' === $translation_crwsjp ) {
    return __( 'Stripe Item', 'crwsjp-stripe-jp-payment' );
  }
  //----------------------------------------------
  if ( 'shortcode_name' === $translation_crwsjp ) {
    return __( 'ショートコードとアイテム識別コード', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'shortcode_title' === $translation_crwsjp ) {
    return __( 'ショートコード', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'identification_title' === $translation_crwsjp ) {
    return __( 'アイテム識別コード	', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_name_name' === $translation_crwsjp ) {
    return __( '販売元名（ショップ名やサイト名）', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_description_name' === $translation_crwsjp ) {
    return __( '説明文', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_amount_name' === $translation_crwsjp ) {
    return __( '価格', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_locale_name' === $translation_crwsjp ) {
    return __( '地域設定', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_zip_code_name' === $translation_crwsjp ) {
    return __( '請求先の郵便番号を検証', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_billing_address_name' === $translation_crwsjp ) {
    return __( 'ユーザーの請求先アドレスを収集', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_currency_name' === $translation_crwsjp ) {
    return __( '通貨', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_panel_label_name' === $translation_crwsjp ) {
    return __( '決済ラベル', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_panel_label_text1' === $translation_crwsjp ) {
    return __( 'クレジットカード情報入力フォームに表示される決定ボタンに表示する名称を設定します。', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_panel_label_text2' === $translation_crwsjp ) {
    return __( '表示内容に金額を含めたい場合は{{amount}}を入力してください。ex){{amount}}を支払う', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_panel_label_text3' === $translation_crwsjp ) {
    return __( '空白の場合は「￥〇〇〇〇を支払う」と表示されます。', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_shipping_address_name' === $translation_crwsjp ) {
    return __( 'ユーザーの配送先住所を収集', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_label_name' === $translation_crwsjp ) {
    return __( 'ボタンラベル', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'data_label_text' === $translation_crwsjp ) {
    return __( '空白の場合"pay with card"と表示されます。', 'crwsjp-stripe-jp-payment' );
  }
  //----------------------------------------------
  if ( 'data_allow_remember_me_name' === $translation_crwsjp ) {
    return __( 'ユーザーの情報をStripeに保存する', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'shortcode_fields_text' === $translation_crwsjp ) {
    return __( '以下のショートコードを投稿や固定ページに入力すると購入へのボタンが表示されます。', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'identification_fields_text' === $translation_crwsjp ) {
    return __( 'このアイテムの固有識別コードです。アイテム作成後は変更することはできません。', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_data_name_text' === $translation_crwsjp ) {
    return __( 'あなたの会社（販売元名）またはウェブサイトの名前を入力してください', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_data_description_text' === $translation_crwsjp ) {
    return __( '販売元名の下に表示される説明文を設定します。（全角17文字は省略されます）', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_data_locale_text' === $translation_crwsjp ) {
    return __( '使用する言語を設定します。', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_data_currency_text' === $translation_crwsjp ) {
    return __( '使用する通貨を設定します。', 'crwsjp-stripe-jp-payment' );
  }
  //----------------------------------------------
  if ( 'crwsjp_data_amount_text01' === $translation_crwsjp ) {
    return __( '日本円以外の通貨について', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_data_amount_url' === $translation_crwsjp ) {
    return __( 'https://stripe.com/docs/currencies', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_data_amount_urltext' === $translation_crwsjp ) {
    return __( 'サポートされている通貨', 'crwsjp-stripe-jp-payment' );
  }
  //  Validation Messege
  if ( 'crwsjp_validation_int' === $translation_crwsjp ) {
    return __( '正しい数値を入力してください', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'crwsjp_validation_discriptionCD' === $translation_crwsjp ) {
    return __( '残り文字数：', 'crwsjp-stripe-jp-payment' );
  }

  //  ------------------------------------------
  //  History item
  //  ------------------------------------------
  if ( 'custom_history_name' === $translation_crwsjp ) {
    return __( '購入履歴', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_history_add' === $translation_crwsjp ) {
    return __( '購入履歴の追加', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_history_edit' === $translation_crwsjp ) {
    return __( '購入履歴の編集', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_history_list' === $translation_crwsjp ) {
    return __( '購入履歴の一覧', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_history_search' === $translation_crwsjp ) {
    return __( '購入履歴の検索', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_history_not_found' === $translation_crwsjp ) {
    return __( '見つかりません', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'custom_history_garbage' === $translation_crwsjp ) {
    return __( 'ゴミ箱にはありません', 'crwsjp-stripe-jp-payment' );
  }


  //  ------------------------------------------
  //  User page
  //  ------------------------------------------
  if ( 'PurchaseHistory' === $translation_crwsjp ) {
    return __( '購入履歴', 'crwsjp-stripe-jp-payment' );
  }
  if ( 'Receipt' === $translation_crwsjp ) {
    return __( '領収書', 'crwsjp-stripe-jp-payment' );
  }





};