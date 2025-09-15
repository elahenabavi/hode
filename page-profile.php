<?php 
/*
Template Name: پروفایل
*/

get_header();

global $wpdb;
$user_id = get_current_user_id();

// دریافت اطلاعات کاربر از جدول wp_users
//اگر نبود کاربر دمو حساب میشه 
$user_info = get_userdata($user_id);
$user_name = $user_info ? $user_info->display_name : 'کاربر';
$user_email = $user_info ? $user_info->user_email : 'demo@example.com';

// دریافت کیف پول
$wallet = $wpdb->get_row($wpdb->prepare("
    SELECT balance, locked 
    FROM wp_user_wallet 
    WHERE user_id = %d
", $user_id));
$balance = $wallet ? floatval($wallet->balance) : 0;
$locked = $wallet ? floatval($wallet->locked) : 0;

// دریافت اشتراک فعال
$subscription = $wpdb->get_row($wpdb->prepare("
    SELECT plan, start_date, end_date 
    FROM wp_user_subscriptions 
    WHERE user_id = %d AND status = 'active'
", $user_id));

// دریافت تراکنش‌ها
$transactions = $wpdb->get_results($wpdb->prepare("
    SELECT type, amount, description, transaction_date 
    FROM wp_user_transactions 
    WHERE user_id = %d 
    ORDER BY transaction_date DESC
", $user_id));

// دریافت رزروها
$reservations = $wpdb->get_results($wpdb->prepare("
    SELECT product_id, deposit, days, start_date, expire_date, status 
    FROM wp_user_reservations 
    WHERE user_id = %d 
    ORDER BY start_date DESC
", $user_id));
// اضافه کردن اسم محصول به هر رزرو
$reservations = array_map(function($r){
  $r->product_name = get_the_title($r->product_id);
  return $r;
}, $reservations);

?>
<script>
const USER = {
  name: "<?php echo esc_js($user_name); ?>",
  email: "<?php echo esc_js($user_email); ?>"
};

const WALLET = {
  balance: <?php echo $balance; ?>,
  locked: <?php echo $locked; ?>
};

const SUBSCRIPTION = <?php echo $subscription ? json_encode([
  'plan'  => $subscription->plan,
  'start' => $subscription->start_date,
  'end'   => $subscription->end_date
]) : 'null'; ?>;

const TRANSACTIONS = <?php echo json_encode(array_map(function($t){
  return [
    'type'  => $t->type,
    'amount'=> floatval($t->amount),
    'desc'  => $t->description,
    'date'  => $t->transaction_date
  ];
}, $transactions)); ?>;

const RESERVATIONS = <?php echo json_encode(array_map(function($r){
  return [
    'product_id'   => $r->product_id,
    'product_name' => $r->product_name,
    'deposit'      => floatval($r->deposit),
    'days'         => intval($r->days),
    'start'        => $r->start_date,
    'expire'       => $r->expire_date,
    'status'       => $r->status
  ];
}, $reservations)); ?>;
</script>
<div class="bg-gray-50 text-gray-800">
  <?php 

get_header();

if ( ! $user_id ) {
    ?>
    <div class="lg:max-w-[90%] max-w-[80%] flex items-center justify-center my-20">
        <div class="bg-[#fafafa] p-6 rounded-lg shadow-md text-center max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-[#4a4a4a]">برای مشاهده پروفایل باید وارد شوید</h2>
            <a href="form/  " 
               class="px-4 py-2 bg-[#c9a6df] text-white rounded-md hover:bg-[#c0c0c0] transition">
               ورود به سایت
            </a>
        </div>
    </div>
    <?php
    get_footer();
    exit;
}
?>
<div class="lg:max-w-[80%] max-w-[90%] mx-auto my-10">
<div class="bg-[#f8f8f8] text-[#4a4a4a] min-h-screen flex flex-col lg:flex-row">
  <aside class="w-full lg:w-80 bg-white border-b lg:border-b-0 lg:border-l 
  border-[#c0c0c0] shadow-sm p-5 flex flex-col gap-4 rounded-md">
    <div>
      <div class="text-2xl font-bold text-[#c9a6df]">پنل نمونه</div>
      <div class="text-sm text-[#4a4a4a] opacity-75">نسخه‌ی دمو — بدون پرداخت واقعی</div>
    </div>
    <div id="userCard" class="bg-white p-3 rounded-lg border border-[#c0c0c0]">
      <div id="userName" class="font-semibold text-[#4a4a4a]">کاربر دمو</div>
      <div id="userEmail" class="text-sm text-[#4a4a4a] opacity-75">demo@example.com</div>
      <div class="mt-3">
        <button id="btnLogin" class="px-3 py-1 text-sm border rounded-md text-[#c9a6df] border-[#c9a6df] hover:bg-[#4a4a4a] hover:text-[#fafafa]">ورود / ویرایش</button>
      </div>
    </div>
    <!-- لاگ اوت کاربر -->
    <div class="mx-auto">
      <a href="<?php wp_logout_url( wp_login_url());?>" class="bg-white border border-[#e35053] text-[#e35053] rounded-md text-sm px-2 py-2  ">خروج از حساب</a>
    </div>

    <nav class="flex-1 overflow-auto">
      <ul class="space-y-2 text-sm">
        <li><button data-page="dashboard" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">داشبورد</button></li>
        <li><button data-page="profile" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">پروفایل</button></li>
        <li><button data-page="subscriptions" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">اشتراک‌ها</button></li>
        <li><button data-page="wallet" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">کیف پول</button></li>
        <li><button data-page="transactions" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">تراکنش‌ها</button></li>
        <li><button data-page="support" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">پشتیبانی</button></li>
        <li><button data-page="warranties" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">ضمانت‌نامه‌ها</button></li>
        <li><button data-page="replacements" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">تعویض کالاها</button></li>
        <li><button data-page="durables" class="w-full lg:text-left text-start px-3 py-2 rounded-md hover:bg-gray-100">خریدهای مدت‌دار</button></li>
      </ul>
    </nav>

    <div class="text-xs text-[#4a4a4a] opacity-75 mt-2">توجه:پرداخت ها شبیه سازی شده اند.میتونید کیف پولتون رو رایگان شارژکنید و عششق کنید.</div>
  </aside>

  <!-- Main -->
  <main class="flex-1 p-6 relative overflow-auto">
    <div id="contentArea"></div>
  </main>
</div>

<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">ورود به دمو</h3>
      <button id="closeLogin" class="text-[#4a4a4a] opacity-75">✕</button>
    </div>
    <div class="mt-3 space-y-3">
      <div>
        <label class="text-sm text-[#4a4a4a] opacity-75">نام کاربری</label>
        <input id="inputName" class="w-full mt-1 border border-[#c0c0c0] rounded-md p-2" placeholder="نام:">
      </div>
      <div>
        <label class="text-sm text-[#4a4a4a] opacity-75">ایمیل</label>
        <input id="inputEmail" class="w-full mt-1 border border-[#c0c0c0] rounded-md p-2" placeholder="example@lustera.com">
      </div>
    </div>
    <div class="mt-4 flex justify-end">
      <button id="saveLogin" class="px-4 py-2 bg-[#c9a6df] text-[#fafafa] rounded-md">ذخیره</button>
    </div>
  </div>
</div>
</div>
<!-- Toast -->
<div id="toast" class="fixed top-[24%] right-3 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 transition-opacity duration-500 z-50"></div>

<?php get_footer();
$durables = $wpdb->get_results($wpdb->prepare("
  SELECT product_name, purchase_time, session_duration, expiration_time
  FROM wp_durable_purchases
  WHERE user_id = %d
  ORDER BY purchase_time DESC
", $user_id));
 ?>


</div>
<?php get_footer(); ?>