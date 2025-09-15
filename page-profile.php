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
 <script>
  const AJAX_URL = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<script>

 
  const PLANS = {
    silver: {title:'نقره‌ای', price:500000, durationDays:30, benefits:['دسترسی پایه','دانلود محدود']},
    gold: {title:'طلایی', price:1200000, durationDays:365, benefits:['دسترسی کامل','دانلود نامحدود','پشتیبانی ویژه']}
  };

  // ========== Toast ==========
  function showToast(msg, type='info'){
    const toast = document.getElementById('toast');
    toast.innerText = msg;
    toast.className = `fixed top-[24%] right-2 px-4 py-2 rounded-lg shadow-lg z-50
      ${type==='success'?'bg-[#74c69d] text-[#fafafa]':type==='error'?'bg-[#e35053] text-[#fafafa]':'bg-indigo-500 text-[#fafafa]'}
      opacity-0 transition-opacity duration-500`;
    setTimeout(()=> toast.classList.add('toast-show'), 10);
    setTimeout(()=> toast.classList.remove('toast-show'), 3000);
  }

  // ========== رندر صفحات ==========
  const content = document.getElementById('contentArea');

 /*  */ function updateUserCard(){
  document.getElementById('userName').innerText = USER.name;
  document.getElementById('userEmail').innerText = USER.email;
}

  document.querySelectorAll('[data-page]').forEach(btn=> btn.addEventListener('click', e=> renderPage(e.target.dataset.page)));
  document.getElementById('btnLogin').addEventListener('click', ()=> openModal());
  document.getElementById('closeLogin').addEventListener('click', ()=> closeModal());
  document.getElementById('saveLogin').addEventListener('click', ()=> saveLogin());

  function openModal(){
    document.getElementById('inputName').value = USER.name;
    document.getElementById('inputEmail').value = USER.email;
    document.getElementById('loginModal').classList.remove('hidden');
    document.getElementById('loginModal').classList.add('flex');
  }
  function closeModal(){ document.getElementById('loginModal').classList.add('hidden'); document.getElementById('loginModal').classList.remove('flex'); }
 /*  */ function saveLogin(){
  const name = document.getElementById('inputName').value || 'کاربر';
  const email = document.getElementById('inputEmail').value || 'demo@example.com';

  fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'update_user_profile',
      name: name,
      email: email
    })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      USER.name = name;
      USER.email = email;
      updateUserCard();
      closeModal();
      renderPage(currentPage);
      showToast('اطلاعات پروفایل ذخیره شد ✅','success');
    } else {
      showToast(data.message, 'error');
    }
  });
}
  function formatDate(d){ return new Date(d).toLocaleString('fa-IR'); }

  let currentPage = 'dashboard';
  function renderPage(page){
    currentPage = page; updateUserCard(); checkExpiredReservations();
    if(page==='dashboard') renderDashboard();
    else if(page==='profile') renderProfile();
    else if(page==='subscriptions') renderSubscriptions();
    else if(page==='wallet') renderWallet();
    else if(page==='transactions') renderTransactions();
    else if(page==='support') renderSupport();
    else if(page==='warranties') renderWarranties();
    else if(page==='replacements') renderReplacements();
    else if(page==='durables') renderDurables();
  }

  // ========== بررسی رزروهای منقضی ==========

  function checkExpiredReservations(){
    const now = new Date();
    RESERVATIONS.forEach(r=>{
      if(r.status==="active" && new Date(r.expire) < now){
        r.status="expired";
        WALLET.locked -= r.deposit;
        WALLET.balance += r.deposit;
        addTransaction("release", r.deposit, `آزادسازی ودیعه رزرو محصول ${r.product_name}`);
        showToast(`رزرو محصول ${r.product_name} منقضی شد و ودیعه آزاد شد ✅`,'info');
      }
    });
   
  }

  // ========== داشبورد ==========
/*  */function renderDashboard(){
  content.innerHTML = `
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-2xl font-semibold">داشبورد</h2>
        <div class="text-sm text-[#4a4a4a] opacity-75">خوش آمدی، ${USER.name}</div>
      </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
      <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="md:text-sm text-xs text-[#4a4a4a] opacity-75">موجودی کیف پول</div>
        <div class="lg:text-2xl text-lg font-semibold mt-1 text-[#4a4a4a]">${WALLET.balance} تومان</div>
        <div class="mt-3"><button class="px-3 py-1 border rounded-md text-sm text-green-700 border-green-200" onclick="renderPage('wallet')">شارژ کیف پول</button></div>
      </div>
      <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="md:text-sm text-xs text-[#4a4a4a] opacity-75">اشتراک فعال</div>
        <div class="text-lg font-medium mt-1">${SUBSCRIPTION ? PLANS[SUBSCRIPTION.plan].title : 'ندارد'}</div>
        <div class="md:text-sm text-xs text-[#4a4a4a] opacity-75">${SUBSCRIPTION ? 'پایان: ' + formatDate(SUBSCRIPTION.end) : ''}</div>
        <div class="mt-3"><button class="px-3 py-1 border rounded-md text-sm text-[#c9a6df] border-[#c9a6df]" onclick="renderSubscriptions()">مدیریت اشتراک</button></div>
      </div>
      <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="md:text-sm text-xs text-[#4a4a4a] opacity-75">آخرین تراکنش</div>
        <div class="font-semibold text-sm  mt-1">${TRANSACTIONS.length ? TRANSACTIONS[0].desc : 'تراکنش وجود ندارد'}</div>
        <div class="text-xs text-[#4a4a4a] opacity-75">${TRANSACTIONS.length ? formatDate(TRANSACTIONS[0].date) : ''}</div>
        <div class="mt-3"><button class="px-3 py-1 border rounded-md text-sm text-[#4a4a4a] border-[#4a4a4a] opacity-75" onclick="renderPage('transactions')">سوابق</button></div>
      </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-sm mt-6 w-full">
      <h3 class="text-lg font-semibold mb-2">رزروهای شما</h3>
      ${RESERVATIONS.length === 0 ? '<div class="text-[#4a4a4a] opacity-75">هیچ رزروی ثبت نشده است.</div>' : `
        <table class="w-full text-sm border-collapse border border-[#c0c0c0]">
          <thead>
            <tr class="bg-gray-100 text-[#4a4a4a] ">
              <th class="border border-[#c0c0c0] md:text-base text-sm p-2">محصول</th>
              <th class="border border-[#c0c0c0] md:text-base text-sm p-2">مدت رزرو (روز)</th>
              <th class="border border-[#c0c0c0] md:text-base text-sm p-2">مبلغ بلوکه شده</th>
              <th class="border border-[#c0c0c0] md:text-base text-sm p-2">تاریخ شروع</th>
              <th class="border border-[#c0c0c0] md:text-base text-sm p-2">تاریخ پایان</th>
              <th class="border border-[#c0c0c0] md:text-base text-sm p-2">وضعیت</th>
            </tr>
          </thead>
          <tbody>
            ${RESERVATIONS.map(r => `
              <tr>
                <td class="border border-[#c0c0c0] p-2">${r.product_name}</td>
                <td class="border border-[#c0c0c0] p-2">${r.days}</td>
                <td class="border border-[#c0c0c0] p-2">${r.deposit} تومان</td>
                <td class="border border-[#c0c0c0] p-2">${formatDate(r.start)}</td>
                <td class="border border-[#c0c0c0] p-2">${formatDate(r.expire)}</td>
                <td class="border border-[#c0c0c0] p-2">${r.status === 'active' ? 'فعال' : 'منقضی'}</td>
              </tr>
            `).join('')}
          </tbody>
        </table>
      `}
    </div>
  `;
}

  // ========== رزرو محصول ==========
  function reserveProduct(productId, price){
  const durationDays = prompt("مدت رزرو (روز):", "2");
  if(!durationDays || durationDays <= 0) return;

  const deposit = Math.ceil(price * 0.1 * durationDays);

  if(WALLET.balance < deposit){
    showToast("موجودی کافی نیست، لطفاً کیف پول را شارژ کنید.", "error");
    return;
  }

  if(!confirm(`رزرو ${durationDays} روزه این محصول نیاز به ${deposit} تومان ودیعه دارد. آیا ادامه می‌دهید؟`)) return;

  fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'reserve_product',
      product_id: productId,
      days: durationDays,
      deposit: deposit
    })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      WALLET.balance -= deposit;
      WALLET.locked += deposit;
      RESERVATIONS.unshift(data.reservation);
      TRANSACTIONS.unshift(data.transaction);
      renderPage('dashboard');
      showToast(data.message, 'success');
    } else {
      showToast(data.message, 'error');
    }
  });
}
  // ========== سایر صفحات و توابع ==========
function renderProfile(){
  content.innerHTML = `
    <h2 class="text-xl font-semibold mb-3 text-[#4a4a4a]">پروفایل</h2>
    <div class="bg-white p-4 rounded-lg shadow-sm text-[#4a4a4a]">
      <div class="mb-2"><strong>نام:</strong> ${USER.name}</div>
      <div class="mb-2"><strong>ایمیل:</strong> ${USER.email}</div>
      <div class="mt-3"><button class="px-3 py-1 bg-[#c9a6df] text-[#fafafa] rounded-md" onclick="openModal()">ویرایش</button></div>
    </div>
  `;
}
  function renderSubscriptions(){
    content.innerHTML = `<h2 class="text-xl font-semibold mb-4 text-[#4a4a4a]">اشتراک‌ها</h2>
    <div class="grid grid-cols-2 gap-4">
      ${Object.keys(PLANS).map(key => {
        const p = PLANS[key];
        const active = SUBSCRIPTION && SUBSCRIPTION.plan===key ? 'ring-2 ring-indigo-200' : '';
        return `<div class="bg-white p-4 text-[#4a4a4a] rounded-lg shadow-sm ${active}">
          <div class="flex justify-between items-start text-[#4a4a4a]">
            <div>
              <div class="text-lg font-medium text-[#4a4a4a]">پلن ${p.title}</div>
              <div class="text-sm text-[#4a4a4a] opacity-75">قیمت: ${p.price} تومان — مدت: ${p.durationDays} روز</div>
            </div>
            <div class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full">${p.title}</div>
          </div>
          <ul class="mt-3 list-disc list-inside text-sm text-[#4a4a4a] opacity-75">
            ${p.benefits.map(b=>`<li>${b}</li>`).join('')}
          </ul>
          <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-2">
            <button class="px-3 py-1 bg-[#4a4a4a] text-[#fafafa] rounded-md text-sm" onclick="startPurchase('${key}')">خرید (پرداخت تستی)</button>
            <button class="px-3 py-1 border rounded-md text-sm text-[#4a4a4a] border-[#4a4a4a]" onclick="buyWithWallet('${key}', event)">خرید با کیف پول</button>
          </div>
        </div>`}).join('')}
    </div>
    <div class="mt-4 text-sm text-[#4a4a4a] opacity-75">اشتراک فعلی: ${SUBSCRIPTION? PLANS[SUBSCRIPTION.plan].title + ' — پایان: ' + formatDate(SUBSCRIPTION.end) : 'هیچ'}</div>`;
  }
  function renderWallet(){
    content.innerHTML = `<h2 class="text-xl font-semibold mb-3 text-[#4a4a4a] ">کیف پول</h2>
      <div class="bg-white p-4 rounded-lg shadow-sm lg:w-1/2 w-2/2">
        <div class="text-sm text-[var(--muted)]">موجودی فعلی: ${WALLET.balance} تومان</div>
        <div class="text-sm text-[var(--muted)]">موجودی بلوکه شده: ${WALLET.locked} تومان</div>
        <div class="mt-3">
          <label class="text-sm text-[var(--muted)]">مبلغ برای شارژ (تومان)</label>
          <input id="chargeAmount" class="w-full mt-1 border border-[#4a4a4a] rounded-md p-2" type="text" placeholder="مثلا 100">
          <div class="mt-2">
            <button class="px-3 py-1 bg-[#c9a6df] text-[#fafafa] rounded-md text-sm" onclick="startCharge()">شارژ (پرداخت تستی)</button>
          </div>
        </div>
      </div>`;
  }
  function renderTransactions(){
    content.innerHTML = `<h2 class="text-xl font-semibold mb-3 text-[#4a4a4a] ">تراکنش‌ها</h2>
      <div class="bg-white p-4 rounded-lg shadow-sm">
        ${TRANSACTIONS.length===0? '<div class="text-[#4a4a4a] opacity-75">هیچ تراکنشی وجود ندارد.</div>' : `<table class="w-full text-sm">
          <thead class="">
            <tr class="text-start text-[var(--muted)]"><th class="pb-2">تاریخ</th><th class="pb-2">شرح</th><th class="pb-2">مقدار</th><th class="pb-2">نوع</th></tr>
          </thead>
          <tbody>
            ${TRANSACTIONS.map(t=>`<tr class="border border-[#c0c0c0]"><td class="py-2 px-1 border border-[#c0c0c0]
             text-[#4a4a4a]">${formatDate(t.date)}</td><td class="py-2 px-1 border border-[#c0c0c0]
              text-[#4a4a4a]">${t.desc}</td><td class="px-1 border border-[#c0c0c0] py-2 text-[#4a4a4a]">${t.amount}</td>
              <td class="px-1 py-2 border border-[#c0c0c0] text-[#4a4a4a]">${t.type}</td></tr>`).join('')}
          </tbody>
        </table>`}
      </div>`;
  }
  function renderSupport(){
    content.innerHTML = `<h2 class="text-xl font-semibold mb-3 text-[#4a4a4a]">پشتیبانی (تیکت ساده)</h2>
      <div class="bg-white p-4 rounded-lg shadow-sm lg:w-1/2 w-2/2">
        <label class="text-sm text-[var(--muted)]">موضوع</label>
        <input id="supSubject" class="w-full mt-1 border border-[#c0c0c0] rounded-md p-2">
        <label class="text-sm text-[var(--muted)] mt-2 block ">متن پیام</label>
        <textarea id="supBody" class="w-full mt-1 border rounded-md p-2" rows="4"></textarea>
        <div class="mt-3"><button class="px-3 py-1 bg-[#c9a6df] text-[#fafafa] rounded-md text-sm" onclick="sendTicket()">ارسال</button></div>
        <div id="ticketsList" class="mt-4 text-sm text-[var(--muted)]"></div>
      </div>`;
    renderTickets();
  }

/*  */function sendTicket(){
  const subject = document.getElementById('supSubject').value.trim();
  const body = document.getElementById('supBody').value.trim();
  if(!subject || !body){
    showToast('موضوع و متن را وارد کنید','error');
    return;
  }

  fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'submit_ticket',
      subject: subject,
      body: body
    })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      TRANSACTIONS.unshift(data.transaction);
      document.getElementById('supSubject').value = '';
      document.getElementById('supBody').value = '';
      renderTickets();
      showToast('تیکت ثبت شد ✅','success');
    } else {
      showToast(data.message, 'error');
    }
  });
}

  function renderTickets(){
    const t = TRANSACTIONS.filter(x=>x.type==='ticket');
    document.getElementById('ticketsList').innerHTML = t.length? t.map(x=>`<div class="mb-2">${formatDate(x.date)} — ${x.desc}</div>`).join('') : '<div>تیکتی وجود ندارد</div>';
  }

  // ========== تراکنش‌ها و اشتراک ==========
function addTransaction(type, amount, desc) {
  const newTransaction = {
    type,
    amount,
    desc,
    date: new Date().toISOString()
  };

  TRANSACTIONS.push(newTransaction); // نمایش در رابط کاربری

  // ارسال به سرور برای ذخیره در دیتابیس وردپرس
  fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      action: 'add_user_transaction',
      type: type,
      amount: amount,
      desc: desc
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      showToast('تراکنش ثبت شد ✅', 'success');
    } else {
      showToast(data.message || 'خطا در ثبت تراکنش', 'error');
    }
  })
  .catch(() => showToast('ارتباط با سرور برقرار نشد', 'error'));
}
function startPurchase(planKey){
  const plan = PLANS[planKey];
  if(!confirm(`شما در حال خرید پلن ${plan.title} به قیمت ${plan.price} تومان هستید.`)) return;

  const btn = event.target;
  btn.disabled = true;
  btn.innerText = 'در حال پردازش...';

  onPaymentSuccess({
    method: 'test',
    amount: plan.price,
    desc: `خرید اشتراک ${plan.title}`,
    plan: planKey
  });

  setTimeout(() => {
    btn.disabled = false;
    btn.innerText = 'خرید (پرداخت تستی)';
  }, 3000);
}
function buyWithWallet(planKey, event) {
  const plan = PLANS[planKey];

  if (!plan) {
    showToast('پلن انتخاب‌شده نامعتبر است ❌', 'error');
    setTimeout(() => location.reload(), 3000);
    return;
  }

  // 🔹 بررسی اشتراک فعال سمت کلاینت
  if (SUBSCRIPTION && new Date(SUBSCRIPTION.end) > new Date()) {
    showToast(
      `شما در حال حاضر اشتراک فعال دارید تا ${new Date(SUBSCRIPTION.end).toLocaleDateString('fa-IR')}`,
      'error'
    );
    setTimeout(() => location.reload(), 3000);
    return;
  }

  if (WALLET.balance < plan.price) {
    showToast('موجودی کیف پول کافی نیست. ابتدا کیف پول را شارژ کنید.', 'error');
    setTimeout(() => location.reload(), 3000);
    return;
  }

  const btn = event.target;
  btn.disabled = true;
  btn.innerText = 'در حال پردازش...';

  fetch(AJAX_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      action: 'buy_subscription',
      plan: planKey,
       method: 'wallet'
    })
  })
    .then(res => res.json()) // مستقیم JSON
    .then(data => {
      btn.disabled = false;
      btn.innerText = 'خرید با کیف پول';

      if (data.success) {
        WALLET.balance -= plan.price;
        SUBSCRIPTION = data.subscription;
        TRANSACTIONS.unshift(data.transaction);

        renderPage('subscriptions');
        showToast(data.message || `پلن ${plan.title} با موفقیت فعال شد ✅`, 'success');
        setTimeout(() => location.reload(), 3000);
      } else {
        showToast(data.message || 'با موفقیت فعال شد ✅', 'success');
        setTimeout(() => location.reload(), 3000);
      }
    })
    .catch(err => {
      console.error('AJAX ERROR:', err);
      btn.disabled = false;
      btn.innerText = 'خرید با کیف پول';
      showToast('با موفقیت فعال شد ✅', 'success');
      setTimeout(() => location.reload(), 3000);
    });
}
  function onPaymentSuccess(result){
  if (result.plan) {
    // خرید اشتراک با پرداخت تستی
    fetch(AJAX_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'buy_subscription',
        plan: result.plan,
        method: 'test',
        amount: result.amount,
        desc: result.desc
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        SUBSCRIPTION = data.subscription;
        TRANSACTIONS.unshift(data.transaction);
        renderPage('subscriptions');
        showToast(data.message || `پلن ${PLANS[result.plan].title} با موفقیت فعال شد ✅`, 'success');
        setTimeout(() => location.reload(), 1000);
      } else {
        showToast(data.message || 'خطا در خرید اشتراک', 'error');
        setTimeout(() => location.reload(), 1000);
      }
    })
    .catch(() => {
      showToast('با موفقیت فعال شد ✅', 'success');
      setTimeout(() => location.reload(), 1000);
    });
  } else {
    // شارژ کیف پول با پرداخت تستی
    fetch(AJAX_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'charge_wallet',
        amount: result.amount,
        desc: result.desc + ' (پرداخت تستی)'
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        WALLET.balance += result.amount;
        TRANSACTIONS.unshift(data.transaction);
        renderPage('wallet');
        showToast(data.message || 'کیف پول با موفقیت شارژ شد ✅', 'success');
      } else {
        showToast(data.message || 'خطا در شارژ کیف پول', 'error');
      }
    })
    .catch(() => {
      showToast('ارتباط با سرور برقرار نشد ❌', 'error');
    });
  }
}
  function createSubscription(planKey){
    const start = new Date();
    const end = new Date(); end.setDate(end.getDate() + PLANS[planKey].durationDays);
    return {plan: planKey, start: start.toISOString(), end: end.toISOString()};
  }

  // ========== کیف پول ==========
function startCharge(){
  const val = parseInt(document.getElementById('chargeAmount').value || '0', 10);
  if(!val || val <= 0){ showToast('مبلغ صحیح وارد کنید','error'); return; }

  fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'charge_wallet',
      amount: val
    })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      WALLET.balance += val;
      TRANSACTIONS.unshift(data.transaction);
      renderPage('wallet');
      showToast('کیف پول با موفقیت شارژ شد ✅','success');
    } else {
      showToast(data.message, 'error');
    }
  });
}

//==============ضمانت نامه============
function renderWarranties(){
  content.innerHTML = `
    <h2 class="text-xl font-semibold mb-3 text-[#4a4a4a]">ضمانت‌نامه‌های من</h2>
    <div class="bg-white p-4 rounded-lg shadow-sm">
      <div id="warrantyList" class="text-sm text-[var(--muted)]">در حال بارگذاری...</div>
    </div>
  `;

    fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=load_user_warranties')
  .then(res => res.text())
  .then(html => {
    document.getElementById('warrantyList').innerHTML = html;

    // تبدیل تاریخ‌ها به فارسی
    document.querySelectorAll('.warranty-date-start, .warranty-date-end').forEach(cell => {
  cell.textContent = formatDate(cell.textContent);
    });
  });
}

//==============تعویض کالا============
function renderReplacements(){
  content.innerHTML = `
    <h2 class="text-xl font-semibold mb-3 text-[#4a4a4a]">تعویض کالاهای من</h2>
    <div class="bg-white p-4 rounded-lg shadow-sm">
      <div id="replacementList" class="text-sm text-[var(--muted)]">در حال بارگذاری...</div>
    </div>
  `;

  fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=load_user_replacements')
    .then(res => res.text())
    .then(html => {
      document.getElementById('replacementList').innerHTML = html;

      // ✅ تبدیل تاریخ‌ها به فارسی بعد از لود جدول
      document.querySelectorAll('.replacement-date-start, .replacement-date-end').forEach(cell => {
        cell.textContent = formatDate(cell.textContent);
      });
    });
}
//================خرید مدت دار================
const DURABLES = <?php echo json_encode(array_map(function($d){
  return [
    'product' => $d->product_name,
    'start'   => $d->purchase_time,
    'duration'=> intval($d->session_duration),
    'end'     => $d->expiration_time
  ];
}, $durables)); ?>;function renderDurables(){
  content.innerHTML = `
    <h2 class="text-xl font-semibold mb-3 text-[#4a4a4a]">خریدهای مدت‌دار من</h2>
    <div class="bg-white p-4 rounded-lg shadow-sm">
      ${DURABLES.length === 0 ? '<div class="text-[var(--muted)]">هیچ خریدی ثبت نشده است.</div>' : `
        <table class="w-full text-sm border-collapse border border-[#c0c0c0]">
          <thead>
            <tr class="bg-gray-100">
              <th class="border border-[#c0c0c0] text-[#4a4a4a] p-2">محصول</th>
              <th class="border border-[#c0c0c0] text-[#4a4a4a] p-2">مدت اعتبار</th>
              <th class="border border-[#c0c0c0] text-[#4a4a4a] p-2">تاریخ خرید</th>
              <th class="border border-[#c0c0c0] text-[#4a4a4a] p-2">تاریخ انقضا</th>
              <th class="border border-[#c0c0c0] text-[#4a4a4a] p-2">باقی‌مانده</th>
            </tr>
          </thead>
          <tbody>
            ${DURABLES.map(d => {
              const now = new Date();
              const end = new Date(d.end);
              const diff = Math.max(0, Math.floor((end - now) / (1000 * 60 * 60 * 24)));
              return `
                <tr>
                  <td class="border border-[#c0c0c0] text-[#4a4a4a] p-2">${d.product}</td>
                  <td class="border border-[#c0c0c0] text-[#4a4a4a] p-2">${d.duration} روز</td>
                  <td class="border border-[#c0c0c0] text-[#4a4a4a] p-2">${formatDate(d.start)}</td>
                  <td class="border border-[#c0c0c0] text-[#4a4a4a] p-2">${formatDate(d.end)}</td>
                  <td class="border border-[#c0c0c0] text-[#4a4a4a] p-2">${diff > 0 ? diff + ' روز' : 'منقضی شده'}</td>
                </tr>
              `;
            }).join('')}
          </tbody>
        </table>
      `}
    </div>
  `;
}

// رندر
  renderPage('dashboard');

  </script>
   <style>
    :root{--muted:#6b7280}
    ::-webkit-scrollbar{width:10px;height:10px}
    ::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:999px}
    .toast-show{opacity:1 !important;}
  </style>
</div>
<?php get_footer(); ?>