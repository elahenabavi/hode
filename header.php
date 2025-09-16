<?php
session_start();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class("bg-wh2"); ?>>
    <header class="py-10 lg:py-16 border-b border-gray-200 header-pic relative flex justify-center">
     <div class=" lg:max-w-[80%]  w-[90%] flex gap-4 items-center absolute bg-wh1
      lg:top-8 lg:py-6 lg:px-5 py-2 top-9 px-3  rounded-md shadowbox2">
     <!-- دکمه همبرگری (فقط موبایل/تبلت) -->
<button id="menu-btn" class=" w-8 h-8 lg:hidden z-50">
 <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
  <path d="M5 7H19" stroke="#4a4a4a" stroke-width="2" stroke-linecap="round"/>
  <path d="M5 12H19" stroke="#4a4a4a" stroke-width="2" stroke-linecap="round"/>
  <path d="M5 17H19" stroke="#4a4a4a" stroke-width="2" stroke-linecap="round"/>
</svg>
</button>
<!-- بک‌دراپ -->
<div id="overlay" class="hidden fixed inset-0 bg-si opacity-75 z-40"></div>
<!-- منوی کشویی -->
<div id="menu" class="fixed top-0 right-0 h-screen w-3/4 max-w-sm bg-white shadow-lg 
            transform translate-x-full transition-transform duration-300 ease-in-out z-50 lg:hidden">
  <div class="p-4 border-b border-[#c0c0c0] flex justify-between items-center">
    <h2 class="text-lg font-bold text-[#c9a6df]">فروشگاه لاسترا</h2>
    <!-- دکمه بستن (با اسپن) -->
    <button id="close-btn" class="relative w-8 h-8 flex items-center justify-center">
      <span class="absolute w-8 h-0.5 bg-[#4a4a4a] transform rotate-45"></span>
      <span class="absolute w-8 h-0.5 bg-[#4a4a4a] transform -rotate-45"></span>
    </button>
  </div>
  <ul class="p-4 space-y-3 text-right text-[#4a4a4a]">
    <li><a href="<?php echo home_url(); ?>" class="block px-4 py-2 rounded hover:bg-gray-100">خانه</a></li>
    <li><a href="<?php echo get_post_type_archive_link('product'); ?>" class="block px-4 py-2 rounded hover:bg-gray-100"> محصولات</a></li>
    <li><a href="accsessory/" class="block px-4 py-2 rounded hover:bg-gray-100"> دست دوم</a></li>
    <li><a href="contact/" class="block px-4 py-2 rounded hover:bg-gray-100">ارتباط با ما</a></li>
    <li><a href="about/" class="block px-4 py-2 rounded hover:bg-gray-100">درباره ما</a></li>
    <li><a href="<?php echo get_permalink( get_option('page_for_posts') ); ?>" class="block px-4 py-2 rounded hover:bg-gray-100"> بلاگ</a></li>
    <li><a href="form/" class="block px-4 py-2 rounded hover:bg-gray-100"> ورود/ثبت نام</a></li>
    <li><a href="wear/" class="block px-4 py-2 rounded hover:bg-gray-100">چی بخرم؟</a></li>
  </ul>
</div>


            <?php if (function_exists("the_custom_logo")) {
                the_custom_logo();
            } ?>
            <?php wp_nav_menu([
                "theme_location" => 'Header',
                "menu_class" => "main-nav flex grow gap-3 txt-gr1 hidden lg:flex  ",
                "container" => false
            ]);
            ?>
            <div class="mr-auto   ">
        <div class="relative inline-flex items-center">
        <!-- آیکن جستجو -->
        <button id="toggleSearch" type="button" class="inline-flex items-center">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 stroke-current text-gray-700">
                <path d="M20 20L15.8033 15.8033M18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 6.35786 18 10.5 18C14.6421 18 18 14.6421 18 10.5Z"
                      stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
  <!-- فرم جستجو -->
        <form id="searchForm" action="<?php echo esc_url(home_url('/shop')); ?>" method="get"
              class="absolute top-9 lg:h-15 h-13 left-0 lg:w-80 w-60 flex gap-3 bg-white p-2 rounded-lg shadowbox1 hidden z-50">
        <input type="text" name="s" placeholder="جستجوی محصول..." class="lg:w-60 w-40 border border-[#c0c0c0] rounded-md 
        p-2 focus:outline-none focus:ring-2 lg:text-base text-sm focus:ring-purple-500" />
        <input type="hidden" name="post_type" value="product" />
        <button type="submit" class="lg:w-20 w-14 bg-[#c9a6df] text-[#fafafa] text-sm rounded-md py-0 hover:bg-[#c0c0c0] transition">
              جستجو
        </button>
    </form>
</div>
                <?php
                $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
                ?>
                <a href="<?php echo wc_get_cart_url(); ?>" class="relative inline-flex items-center px-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 3L2.26491 3.0883C3.58495 3.52832 4.24497 3.74832 4.62248 4.2721C5 4.79587 5 5.49159 5 6.88304V9.5C5 12.3284 5 13.7426 5.87868 14.6213C6.75736 15.5 8.17157 15.5 11 15.5H19" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" stroke="#4a4a4a" stroke-width="1.5" />
                        <path d="M16.5 18C17.3284 18 18 18.6715 18 19.5C18 20.3284 17.3284 21 16.5 21C15.6716 21 15 20.3284 15 19.5C15 18.6715 15.6716 18 16.5 18Z" stroke="#4a4a4a" stroke-width="1.5" />
                        <path d="M5 6H16.4504C18.5054 6 19.5328 6 19.9775 6.67426C20.4221 7.34853 20.0173 8.29294 19.2078 10.1818L18.7792 11.1818C18.4013 12.0636 18.2123 12.5045 17.8366 12.7523C17.4609 13 16.9812 13 16.0218 13H5" stroke="#4a4a4a" stroke-width="1.5" />
                    </svg>
                  <?php   
                  if($_SESSION["pay"]!="yes"){  
                  ?>
                    <!-- Badge -->
                    <?php if ($count > 0): ?>
                        <span class="absolute -top-2.5 left-5 inline-flex items-center justify-center 
                     py-[3px] px-[5px]  text-xs leading-none text-white 
                     bg-red-600 rounded-full aspect-square">
                            <?php echo esc_html($count); ?>
                        </span>
                    <?php endif; 
                    }
                    ?>
                  
                </a>
                <a href="profile/" class="inline-flex items-center">
               <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800">
              <path d="M12.1992 12C14.9606 12 17.1992 9.76142 17.1992 7C17.1992 4.23858 14.9606 2 12.1992 2C9.43779 2 7.19922 4.23858 7.19922 7C7.19922 9.76142 9.43779 12 12.1992 12Z" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 22C3.57038 20.0332 4.74796 18.2971 6.3644 17.0399C7.98083 15.7827 9.95335 15.0687 12 15C16.12 15 19.63 17.91 21 22" stroke="#4a4a4a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>


                  </a>
            </div>
        </div>
    </header>
