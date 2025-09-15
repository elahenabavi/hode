document.addEventListener("DOMContentLoaded", () => {
  const menuBtn = document.getElementById("menu-btn");
  const closeBtn = document.getElementById("close-btn");
  const menu = document.getElementById("menu");
  const overlay = document.getElementById("overlay");

  // باز کردن منو
  menuBtn.addEventListener("click", () => {
    menuBtn.classList.toggle("open");
    menu.classList.toggle("translate-x-full");
    overlay.classList.toggle("hidden");
  });

  // بستن با دکمه ✕
  closeBtn.addEventListener("click", () => {
    menuBtn.classList.remove("open");
    menu.classList.add("translate-x-full");
    overlay.classList.add("hidden");
  });

  // بستن با کلیک روی بک‌دراپ
  overlay.addEventListener("click", () => {
    menuBtn.classList.remove("open");
    menu.classList.add("translate-x-full");
    overlay.classList.add("hidden");
  });
});


//slider
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".myBestSellerSlider").forEach(function (slider) {
        new Swiper(slider, {
            slidesPerView: 2,   // حالت پیش‌فرض (موبایل → ۲ تا)
            spaceBetween: 20,
            navigation: {
                nextEl: slider.parentElement.querySelector(".swiper-button-prev"),
                prevEl: slider.parentElement.querySelector(".swiper-button-next"),
            },
            loop: true,
            loopFillGroupWithBlank: true,
            breakpoints: {
                768: {   // تبلت (≥768px)
                    slidesPerView: 3,
                },
                1024: {  // لپ‌تاپ و بالاتر (≥1024px)
                    slidesPerView: 4,
                }
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function(){
  const cards = document.querySelectorAll('.post-card');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(ent => {
      if (ent.isIntersecting) {
        ent.target.classList.add('in-view');
        io.unobserve(ent.target);
      }
    });
  }, {threshold: 0.12});
  cards.forEach(c => io.observe(c));

  // like button + AJAX
  document.querySelectorAll('.like-btn').forEach(btn=>{
    btn.addEventListener('click', e=>{
      e.preventDefault();
      const postID = btn.dataset.post;
      const pressed = btn.getAttribute('aria-pressed') === 'true';
      const actionType = pressed ? 'unlike' : 'like';

      fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `action=hod_like_post&post_id=${postID}&action_type=${actionType}`
      })
      .then(res => res.json())
      .then(data => {
        if(data.success){
          btn.setAttribute('aria-pressed', (!pressed).toString());
          btn.querySelector('.like-count').textContent = data.data.likes;
        }
      });
    });
  });
});


jQuery(function($){
  $('.quantity').each(function(){
    var $qty = $(this).find('input.qty');

    if(!$(this).find('.qty-minus').length)
      $('<button type="button" class="qty-button qty-minus mt-10">-</button>').insertBefore($qty);

    if(!$(this).find('.qty-plus').length)
      $('<button type="button" class="qty-button qty-plus mt-10">+</button>').insertAfter($qty);

    if(!$(this).find('.qty-display').length)
      $('<span class="qty-display mt-10"></span>').insertAfter($qty).text($qty.val());
  });

  // بهتره کلیک رو روی دکمه ها داخل کانتینر quantity محدود کنیم تا دقیقتر باشه
  $(document).on('click', '.qty-plus', function(){
    var $container = $(this).closest('.quantity');
    var $input = $container.find('input.qty');
    var $display = $container.find('.qty-display');
    var val = parseInt($input.val()) || 1;
    val++;
    $input.val(val).trigger('change');
    $display.text(val);
  });

  $(document).on('click', '.qty-minus', function(){
    var $container = $(this).closest('.quantity');
    var $input = $container.find('input.qty');
    var $display = $container.find('.qty-display');
    var val = parseInt($input.val()) || 1;
    if(val > 1){
      val--;
      $input.val(val).trigger('change');
      $display.text(val);
    }
  });
});




jQuery(document).ready(function($){
  $('.woocommerce-message, .woocommerce-error, .woocommerce-info').each(function(){
    var msg = $(this);

    // اضافه کردن دکمه بستن
    var btn = $('<button class="button-close">×</button>');
    msg.append(btn);

    btn.on('click', function(){
      msg.addClass('fadeout');
      setTimeout(function(){ msg.hide(); }, 500);
    });

    // مخفی شدن خودکار بعد 5 ثانیه
    setTimeout(function(){
      msg.addClass('fadeout');
      setTimeout(function(){ msg.hide(); }, 500);
    }, 5000);
  });
});


/* ========================================== */
 jQuery(document).ready(function($){
  var $select = $('select[name="attribute_pa_color"]');
  if(!$select.length) return;

  // ساخت container برای دایره‌ها
  var $container = $('<div class="custom-color-swatches "></div>');
  $select.after($container);

  // ایجاد دایره‌ها از روی optionها
  $select.find('option').each(function(){
    var slug = $(this).val(); // اینجا دیگه اسلاگ رو گرفتیم (red, purple, ...)
    var label = $(this).text().trim(); // اسم فارسی فقط برای title

    if(!slug || label === 'صاف') return; // پرش از خالی و "صاف"

    // مپ رنگ‌ها بر اساس اسلاگ
    var colors = {
      red: "#e74c3c",
      blue: "#3498db",
      green: "#27ae60",
      black: "#000000",
      white: "#ffffff",
      purple: "#8e44ad",
      yellow: "#f1c40f",
      orange: "#e67e22",
      pink: "#fd79a8",
      gray: "#95a5a6"
    };

    var colorHex = colors[slug.toLowerCase()] || "#ccc";

    var $swatch = $('<div></div>').addClass('color-swatch').css({
      backgroundColor: colorHex
    }).attr('data-value', slug).attr('title', label);

    $swatch.on('click', function(){
      $select.val(slug).trigger('change');
      $container.find('.color-swatch').removeClass('active');
      $(this).addClass('active');
    });

    $container.append($swatch);
  });

  // انتخاب اولیه
  var selectedVal = $select.val();
  if(selectedVal){
    $container.find('.color-swatch[data-value="'+selectedVal+'"]').addClass('active');
  }



  $('.reset_variations').hide();
  $('form.variations_form').on('woocommerce_variation_has_changed', function(){
    $('.reset_variations').hide();
  });

}); 

jQuery(document).ready(function($){
  var $select = $('select[name="attribute_pa_size"]'); 
  if(!$select.length) return;

  // ساخت container برای دکمه‌های سایز
  var $container = $('<div class="custom-size-buttons " style="display:flex; gap:10px; margin-bottom:100px; flex-direction: column;"></div>');
  $select.after($container);

  // اضافه کردن متن بالا
  var $label = $('<p style="margin: 0 0 2px 0; font-weight: 600; color: #4a4a4a;font-size:14px;">انتخاب سایز</p>');
  $container.append($label);

  // ساخت دکمه‌ها
  var $buttonsWrapper = $('<div style="display:flex; gap:10px;"></div>');
  $container.append($buttonsWrapper);

  $select.find('option').each(function(){
    var sizeName = $(this).text().trim();
    var val = $(this).val();
    if(!val) return; // skip گزینه پیشفرض خالی

    var $btn = $('<button type="button"></button>').text(sizeName).attr('data-value', val).addClass('size-btn').css({
      padding: '8px 15px',
      cursor: 'pointer',
      border: '1px solid #c0c0c0',
      backgroundColor: '#f8f8f8',
      borderRadius: '4px',
      userSelect: 'none'
    });

    $btn.on('click', function(){
      $select.val(val).trigger('change');
      $buttonsWrapper.find('button').css({'backgroundColor':'#fafafa', 'borderColor': '#c0c0c0', 'color':'#4a4a4a'});
      $(this).css({'backgroundColor':'#c9a6df', 'borderColor':'#c0c0c0', 'color':'#fafafa'});
    });

    $buttonsWrapper.append($btn);
  });

  var selectedVal = $select.val();
  if(selectedVal) {
    $buttonsWrapper.find('button[data-value="'+selectedVal+'"]').css({'backgroundColor':'#c9a6df', 'borderColor':'#c0c0c0', 'color':'#fafafa'});
  }
});


jQuery(document).ready(function($){
  var $select = $('select[name="attribute_pa_material"]');
  if(!$select.length) return;

  // اضافه کردن متن بالای سلکت
  var $label = $('<label style="display:block; margin: 0 0 2px 0; font-weight: 600; color: #4a4a4a;margin-top:30px !important; font-size:14px; padding-bottom:3px;">انتخاب جنس محصول</label>');
  $select.before($label);

  // (کد CSS سلکت خودت رو داشته باش)
  // مثلا همین کد CSS:
  $select.css({
    appearance: 'none',
    padding: '8px 36px 8px 13px',
    border: '1.6px solid #c0c0c0',
    borderRadius: '8px',
    fontSize: '13px',
    fontWeight: '600',
    color: '#4a4a4a',
    cursor: 'pointer',
    width: '180px',
    backgroundImage: 'url("data:image/svg+xml;utf8,<svg fill=\'gray\' height=\'14\' viewBox=\'0 0 24 24\' width=\'14\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>")',
    backgroundRepeat: 'no-repeat',
    backgroundPosition: 'right 12px center',
    backgroundSize: '14px 14px',
    transition: 'border-color 0.3s ease, box-shadow 0.3s ease'
  });

  $select.on('focus', function(){
    $(this).css({
      borderColor: '#2980b9',
      boxShadow: '0 4px 12px rgba(0, 0, 0, 0.08)',
      outline: 'none'
    });
  }).on('blur', function(){
    $(this).css({
      borderColor: '#c0c0c0',
      boxShadow: 'none'
    });
  });

  $select.on('change', function(){
    var val = $(this).val();
    console.log('جنس انتخاب شده:', val);
  });
});

/* پرسش های متداول */
/* فقط یک پرسش باز میمونه */
 document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".faq-toggle");

    toggles.forEach(toggle => {
      toggle.addEventListener("click", () => {
        const content = toggle.nextElementSibling;
        const icon = toggle.querySelector(".toggle-icon");

        // اگر بازه، ببندش
        if (content.style.maxHeight && content.style.maxHeight !== "0px") {
          content.style.maxHeight = "0px";
          icon.textContent = "+";
        } else {
          document.querySelectorAll(".faq-content").forEach(c => c.style.maxHeight = "0px");
          document.querySelectorAll(".toggle-icon").forEach(i => i.textContent = "+");

          //  فقط این یکی رو باز کنیم
          content.style.maxHeight = content.scrollHeight + "px";
          icon.textContent = "−";
        }
      });
    });
  });
  /* گالری محصولات */

document.addEventListener('DOMContentLoaded', function() {
  const mainImage = document.getElementById('mainImage');
  if (!mainImage) return;

  const thumbsContainer = document.querySelector('.gallery-thumbs');
  if (!thumbsContainer) return;

  // از delegation استفاده میکنیم تا پس از جایگزینی هم کار کنه
  thumbsContainer.addEventListener('click', function(e) {
    const clicked = e.target.closest('.thumb');
    if (!clicked) return;

    const clickedId = clicked.getAttribute('data-id');
    const clickedLarge = clicked.getAttribute('data-large');
    const clickedThumb = clicked.getAttribute('data-thumb');

    const prevId = mainImage.getAttribute('data-id');
    const prevLarge = mainImage.getAttribute('data-large');
    const prevThumb = mainImage.getAttribute('data-thumb');

    // اگر به هر دلیلی همان عکس فعلی را کلیک کردند (نباید در thumbs باشد) رد کن
    if (!clickedId || clickedId === prevId) return;

    // 1) آپدیت تصویر بزرگ به عکس کلیک‌شده
    mainImage.src = clickedLarge;
    mainImage.setAttribute('data-large', clickedLarge);
    mainImage.setAttribute('data-thumb', clickedThumb);
    mainImage.setAttribute('data-id', clickedId);

    // 2) ایجاد عنصر thumb جدید برای تصویر قبلی (که حالا باید جای clicked قرار بگیره)
    const newThumb = document.createElement('img');
    newThumb.className = 'thumb w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-purple-500 hover:scale-110 transition-all';
    newThumb.src = prevThumb;
    newThumb.setAttribute('data-large', prevLarge);
    newThumb.setAttribute('data-thumb', prevThumb);
    newThumb.setAttribute('data-id', prevId);
    newThumb.alt = document.title + ' thumbnail';

    // 3) جایگزینی clicked با newThumb => نتیجه: تصویر کلیک‌شده بزرگ میشه و قبلی جای آن می‌نشیند
    clicked.replaceWith(newThumb);

    // (اختیاری) میتونی کلاس انتخاب‌شده رو مدیریت کنی؛ الان نیازی نیست چون عکس بزرگ خارج از thumbs هست
  });
});




/* سرچ محصولات */
 document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSearch");
    const searchForm = document.getElementById("searchForm");

    toggleBtn.addEventListener("click", function (e) {
      e.preventDefault();
      searchForm.classList.toggle("hidden");
    });
  });

  const AJAX_URL = "<?php echo admin_url('admin-ajax.php'); ?>";


  /* پروفایل */

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

/* ثبت نام وورود */
const imageContainer = document.getElementById('imageContainer');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  function showRegister() {
    loginForm.classList.remove('visible-panel');
    loginForm.classList.add('hidden-panel');
    registerForm.classList.remove('hidden-panel');
    registerForm.classList.add('visible-panel');
    imageContainer.style.transform = 'translateX(100%)';
    localStorage.setItem('form_mode', 'register');
  }

  function showLogin() {
    registerForm.classList.remove('visible-panel');
    registerForm.classList.add('hidden-panel');
    loginForm.classList.remove('hidden-panel');
    loginForm.classList.add('visible-panel');
    imageContainer.style.transform = 'translateX(0%)';
    localStorage.setItem('form_mode', 'login');
  }
  // وقتی صفحه لود شد، حالت ذخیره‌شده رو اعمال کن
  window.addEventListener('load', () => {
    const savedMode = localStorage.getItem('form_mode');
    if (savedMode === 'register') {
      showRegister();
    } else {
      showLogin();
    }
  });
  function closeAlert() {
  const alertBox = document.getElementById('customAlert');
  if (alertBox) {
    alertBox.style.opacity = '0';
    alertBox.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    alertBox.style.transform = 'translateY(-10px)';
    setTimeout(() => alertBox.remove(), 500);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const alertBox = document.getElementById('customAlert');
  if (alertBox) {
    setTimeout(() => closeAlert(), 10000); // بعد از ۱۰ ثانیه محو می‌شه
  }
});

function togglePassword() {
    const input = document.getElementById("reg_password");
    input.type = input.type === "password" ? "text" : "password";
    
  }
function togglePassword2() {
    const input = document.getElementById("reg_repassword");
    input.type = input.type === "password" ? "text" : "password";
 
  }
function togglePassword3() {
    const input = document.getElementById("login_password");
    input.type = input.type === "password" ? "text" : "password";
 
  }

  /* سبد خرید */
   var membershipDiscountAmount = <?php echo $membership_discount_amount; ?>;
  var payableAmount = <?php echo $payable; ?>;
jQuery(function($){

  // URL ایجکس ووکامرس
  const ajaxUrl = (window.wc_cart_params && wc_cart_params.wc_ajax_url)
    ? wc_cart_params.wc_ajax_url.toString()
    : (window.wc_add_to_cart_params ? wc_add_to_cart_params.wc_ajax_url.toString() : '');

  function endpoint(name){
    return ajaxUrl ? ajaxUrl.replace('%%endpoint%%', name) : '';
  }

  // فرمت قیمت محلی (نمایشی)
  function formatPrice(price) {
    return new Intl.NumberFormat('fa-IR', { style: 'currency', currency: 'IRR' }).format(price);
  }
// حذف آیتم با نمایش پیام
$(document).on('click', '.remove-item', function(e){
  e.preventDefault();
  const url = $(this).attr('href');
  const $row = $(this).closest('.cart-item');
const productName = $row.data('name');

  $.get(url, function(){
    $row.remove();
    updateSummaryQuick();

    // نمایش پیام حذف
    $('#remove-alert-text').text(`«${productName}» از سبد خرید شما حذف شد.`);
    $('#remove-alert').removeClass('hidden');

    // تایم‌اوت برای بسته شدن خودکار بعد از 5 ثانیه
    setTimeout(function(){
      $('#remove-alert').addClass('hidden');
    }, 5000);
  });
});

// بستن دستی پیام
$(document).on('click', '#close-remove-alert', function(){
  $('#remove-alert').addClass('hidden');
});
  // آپدیت قیمت کل هر ردیف (نمایشی)
  function updateRowSubtotal(row) {
  const price = parseFloat(row.data('price')) || 0; // قیمت واقعی
  let qty = parseInt(row.find('.qty-input').val()) || 1;
  qty = Math.max(1, qty);
  row.find('.qty-input').val(qty);
  const subtotal = price * qty;
  row.find('.subtotal').text(formatPrice(subtotal));
}

function updateSummaryQuick() {
  let container = window.innerWidth < 1024 ? '#cart-items-mobile' : '#cart-items';
  let totalItems = 0;
  let subtotal   = 0;
  let totalDiscount = 0;

  $(`${container} .cart-item`).each(function(){
    const price    = parseFloat($(this).data('price')) || 0;
    const regular  = parseFloat($(this).data('regular')) || price;
    const qty      = Math.max(1, parseInt($(this).find('.qty-input').val()) || 1);

    totalItems   += qty;
    subtotal     += regular * qty;
    totalDiscount += (regular - price) * qty;
  });

  // محاسبه تخفیف اشتراک به صورت پویا
  let membershipDiscount = <?php echo $membership_discount; ?>;
  let membershipDiscountAmount = (subtotal - totalDiscount) * membershipDiscount;
  let payable = (subtotal - totalDiscount) - membershipDiscountAmount;

  $('#summary-count').text(totalItems);
  $('#summary-subtotal').html(`<span class="amount">${formatPrice(subtotal)}</span>`);
  $('#summary-discounts').html(`<span class="amount">${formatPrice(totalDiscount)}</span>`);
  $('#summary-membership-discount').html(`<span class="amount">${formatPrice(membershipDiscountAmount)}</span>`);
  $('#summary-total').html(`<span class="amount">${formatPrice(payable)}</span>`);
}

  // ارسال تغییرات تعداد به ووکامرس
  function commitCartQuantities(done){
    const $form = $('form.w-full');

    // اگر nonce ووکامرس داخل فرم نیست، از wc_cart_params استفاده کن
    if(!$form.find('input[name="woocommerce-cart-nonce"]').length && window.wc_cart_params && wc_cart_params.cart_nonce){
      $('<input>', {type:'hidden', name:'woocommerce-cart-nonce', value: wc_cart_params.cart_nonce}).appendTo($form);
    }

    // سیگنال آپدیت
    if(!$form.find('input[name="update_cart"]').length){
      $('<input>', {type:'hidden', name:'update_cart', value:'1'}).appendTo($form);
    }

    $.post($form.attr('action'), $form.serialize())
      .always(function(){
        updateSummaryQuick();
        if(typeof done === 'function') done();
      });
  }

  // دکمه‌های + و - (فقط آپدیت محلی)
  $(document).on('click', '.qty-btn', function(){
    const $wrap = $(this).closest('.cart-item');
    const $input  = $wrap.find('.qty-input');
    const action = $(this).data('action');

    let val = parseInt($input.val()) || 1;
    if(action === 'plus') val++;
    if(action === 'minus') val = Math.max(1, val - 1);

    $input.val(val);
    updateRowSubtotal($wrap);
    updateSummaryQuick(); // فقط محلی
  });

  // تغییر مستقیم input
  $(document).on('input', '.qty-input', function(){
    const $row = $(this).closest('.cart-item');
    updateRowSubtotal($row);
    updateSummaryQuick();
  });

  // حذف آیتم
  $(document).on('click', '.remove-item', function(e){
    e.preventDefault();
    const url = $(this).attr('href');
    const $row = $(this).closest('.cart-item');

    $.get(url, function(){
      $row.remove();
      updateSummaryQuick();
    });
  });

  // دکمه به‌روزرسانی سبد
  $(document).on('click', '#update_cart_btn', function(e){
    e.preventDefault();
    commitCartQuantities(function(){
      location.reload(); // برای اینکه مطمئن بشیم همه چیز (تخفیف کوپن، موجودی و...) درست اعمال شده
    });
  });

  // کوپن
  $('#apply_coupon').on('click', function(){
    const $form = $('form.w-full');

    if(!$form.find('[name="coupon_code"]').length){
      $('<input>', {type:'hidden', name:'coupon_code', value: $('#coupon_code').val()}).appendTo($form);
    } else {
      $form.find('[name="coupon_code"]').val($('#coupon_code').val());
    }

    if(!$form.find('[name="apply_coupon"]').length){
      $('<input>', {type:'hidden', name:'apply_coupon', value:'1'}).appendTo($form);
    }

    if(!$form.find('input[name="woocommerce-cart-nonce"]').length && window.wc_cart_params && wc_cart_params.cart_nonce){
      $('<input>', {type:'hidden', name:'woocommerce-cart-nonce', value: wc_cart_params.cart_nonce}).appendTo($form);
    }

    $.post($form.attr('action'), $form.serialize(), function(){
      location.reload();
    });
  });

  // شروع اولیه
  updateSummaryQuick();});
/* صفحه خونه */
let currentIndex = 1;
displaySlide(currentIndex);

function displaySlide(n) {
  let slides = document.getElementsByClassName("slide");
  let dots = document.getElementsByClassName("dot");
  let slno = document.getElementById("slide-no");

  if (n > slides.length) currentIndex = 1;
  if (n < 1) currentIndex = slides.length;

  for (let i = 0; i < slides.length; i++) slides[i].style.display = "none";
  for (let i = 0; i < dots.length; i++) dots[i].classList.remove("active");

  slides[currentIndex - 1].style.display = "block";
  dots[currentIndex - 1].classList.add("active");
  slno.innerHTML = currentIndex + " / " + slides.length;
}

function changeSlide(n) {
  displaySlide(currentIndex += n);
}

function currentSlide(n) {
  displaySlide(currentIndex = n); 
}
// تغییر خودکار هر 5 ثانیه
let autoSlide = setInterval(() => {
  changeSlide(1);
}, 5000);
//ریست تایمر با کلیک
function resetAutoSlide() {
  clearInterval(autoSlide);
  autoSlide = setInterval(() => {
    changeSlide(1);
  }, 3000); }