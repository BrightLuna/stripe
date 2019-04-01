# Changelog
## 0.1.7 - 2019-04-01
* [Revision]            inc/custom-post-type-item.php  [NG:add_posts_columns OK:add_crwsjp_posts_columns][NG:add_posts_columns_row OK:add_crwsjp_posts_columns_row]

## 0.1.6 - 2019-03-17
* [Support]             Include the settled page ID in the meta.
* [Revision]            Single Shortcode [ get_the_ID() ]
* [Revision]            Custom Post Type History [ crwsjp_webhook_postid']
* [Revision]            Webhook -- Add $webhook_postid

## 0.1.5 - 2018-08-27
* [Support]             SuccessPage & FailurePage
* [Support]             SuccessPage & FailurePage include
* [Revision]            PaymentsCLASS
* [Revision]            Webhook -- Confirm the status sent from the stripe and save it if the charge succeeds.

## 0.1.4 - 2018-08-24
* [Support]             stripe-php-6.16.0
* [delete]              stripe-php-6.12.0
* [Support]             Tax Rate(Truncating the decimal point)
* [Support]             management function
* [Revision]            daytime(NG:date( "YmdHis", time() ) /OK:date_i18n('Y-m-d H:i:s'))
* [Revision]            show_in_rest => false [inc/custom-post-type-item.php -- inc/custom-post-type-history.php]
* [Revision]            Add Custom field [inc/custom-post-type-item.php]
* [Revision]            Tax Validation [assets/js/post-validation.js]
* [Revision]            Stock Validation [assets/js/post-validation.js]
* [Revision]            Adjustment [assets/css/admin.css]

## 0.1.3 - 2018-08-07
* [Revision]            Webhook -- 238 hoge [custom-post-type-item.php]
* [Development started] Subscription Support
* [Development started] Checking Webhook Signatures
* [Development started] Delete User

## 0.1.2 - 2018-07-31
* [Support]             Stripe email receipt
* [Revision]            Correcting title of short code(NG:crwsjp_checkout/OK:crwsjp_checkout id)[custom-post-type-item.php]

## 0.1.0 - 2018-07-30
* [Support]             stripe-php-6.12.0
* [Revision]            Migration of indentation from tab to space started.
* [Revision]            IconImage