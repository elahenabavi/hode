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

/* فیلتر محصولات */


/* سرچ محصولات */
 document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSearch");
    const searchForm = document.getElementById("searchForm");

    toggleBtn.addEventListener("click", function (e) {
      e.preventDefault();
      searchForm.classList.toggle("hidden");
    });
  });