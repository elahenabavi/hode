<?php
session_start();
$_SESSION["pay"]="no";
get_header();
defined( 'ABSPATH' ) || exit;
?>

<div style="text-align:center; padding: 50px;">
  <h2 style="color:#6a2c91;">✅ سفارش شما با موفقیت ثبت شد</h2>
  <p>ممنون از خریدتون دوست عزیز 💜</p>
  <a href="<?php echo esc_url( site_url('/profile') ); ?>" 
     style="display:inline-block; margin-top:20px; padding:10px 20px; background:#c9a6df; color:#fff; border-radius:8px; text-decoration:none;">
    رفتن به پنل کاربری
  </a>
</div>
<?php 
get_footer();
?>