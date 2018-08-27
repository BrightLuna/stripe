<?php
session_start();
$reSiteURL = esc_url( home_url() );
if(!$_SESSION['crwsjp_session']){
    header('Location:'.$reSiteURL );
  }
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<?php wp_head(); ?>
<style>
*, *:before, *:after {
  box-sizing: border-box;
}
h1 {
  font-size: 1.8rem;
}
.crwsjp_success_wrapper {
  position: absolute;
  left: 0px;
  right: 0px;
  top: 0px;
  bottom: 0px;
  margin: auto;
  width: 100%;
  height: 100%;
  background-color:#fff;
}
.crwsjp_success_wrap{
  position: relative;
  width: 100%;
  height: 100%;
}
.crwsjp_success_h2{
}
.crwsjp_success_box{
  position: absolute;
  left: 0px;
  right: 0px;
  top: 0px;
  bottom: 0px;
  margin: auto;
  width: 80%;
  height: 60%;
  background-color:#fff;
  padding:5%;
  border: #ccc solid 1px;
  overflow: auto;
}
.crwsjp_return_btn{
  color: #fff;
  background-color: #292c2e;
  padding: 10px 20px;
  display: inline-block;
  border-radius: 8px;
  text-decoration: none;
  -webkit-transition: .35s ease-in-out;
  -o-transition: .35s ease-in-out;
  transition: .35s ease-in-out;
}
.crwsjp_return_btn:hover{
  color: #fff;
  text-decoration: none;
  background-color: #292c2e;
  opacity: 0.7;
}
</style>
</header>
<body>
<div class="crwsjp_success_wrapper">
<div class="crwsjp_success_wrap">
<div class="crwsjp_success_box">
<h2 class="crwsjp_success_h2"><?php echo get_the_title(); ?></h2>
<?php if(have_posts()): while(have_posts()):the_post();?>
<?php the_content('[more...]'); ?>
<?php endwhile; endif; ?>
  <a href="<?php echo esc_url( home_url() ); ?>" class="crwsjp_return_btn">HOMEへ戻る</a>
</div>
</div>
</div>

<?php wp_footer();?>
</body>
</html>
<?php
unset( $_SESSION[ 'crwsjp_session' ] );
?>