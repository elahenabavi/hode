 <?php wp_footer();
    $facebook  = get_theme_mod('hodcode_facebook');
    $twitter   = get_theme_mod('hodcode_twitter');
    $linkedin = get_theme_mod('hodcode_linkedin');
    $telegram=get_theme_mod('hodcode_telegram')
    ?>
<footer class="bg-pr1 w-full  py-5 px-10 relative">
 <div class="w-20 filter invert brightness-0 mb-5 mx-auto md:mx-0  ">
        <?php if (function_exists("the_custom_logo")) {
            the_custom_logo();
        } ?>
        </div>
<div class="grid lg:grid-cols-5 grid-cols-1 md:grid-cols-3">
    <!-- ستون لینک‌های فروشگاه -->
    <div class="flex flex-col space-y-1 text-[#4a4a4a] col-span-2 lg:col-span-1 md:col-span-1 ">
      <!-- دکمه فقط در حالت موبایل -->
      <button 
        class="w-full flex items-center justify-between font-bold text-lg mb-1 md:mb-0 md:cursor-default md:hidden"
        onclick="toggleFooterMenu(this)"
      >
        فروشگاه
        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
      </button>

      <!-- در تبلیت و لپ تاپ نشون داده میشه-->
      <div class="hidden md:block font-bold text-xl">
        فروشگاه
      </div>

      <!-- لیست لینک‌ها -->
      <ul class="overflow-hidden transition-all duration-500 max-h-0 md:max-h-full md:overflow-visible md:space-y-1.5 space-y-2 text-[#4a4a4a] mt-2 md:mt-4">
        <li><a href="#" class="">پرفروش ترین ها </a></li>
        <li><a href="#" class="">جدیدترین ها</a></li>
        <li><a href="#" class="">نیم ست ها</a></li>
        <li><a href="#" class="">گردنبند</a></li>
        <li><a href="#" class="">دستبند</a></li>
        <li><a href="#" class="">پابند</a></li>
        
      </ul>
    </div>
  



    <!-- ستون لینک‌های مفید -->
    <div class="flex flex-col space-y-1 text-[#4a4a4a] col-span-2 lg:col-span-1 md:col-span-1 mt-2">
   <!-- دکمه فقط در حالت موبایل -->
      <button 
        class="w-full flex items-center justify-between font-bold text-lg md:mb-0 md:cursor-default md:hidden mt-1"
        onclick="toggleFooterMenu(this)"
      >
        لینک های مفید
        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
      </button>

     <!-- در تبلیت و لپ تاپ نشون داده میشه-->
      <div class="hidden md:block font-bold text-xl">
        لینک های مفید
      </div>

      <!-- لیست لینک‌ها -->
      <ul class="overflow-hidden transition-all duration-500 max-h-0 md:max-h-full md:overflow-visible md:space-y-1.5 space-y-2 text-[#4a4a4a] mt-2 md:mt-4">
        <li><a href="#" class="">صفحه اصلی</a></li>
        <li><a href="#" class=""> محصولات</a></li>
        <li><a href="#" class=""> بلاگ </a></li>
      </ul>
    </div>
  


 <!-- ستون لینک‌های ارتباط با ما -->
    <div class="flex flex-col space-y-1 text-[#4a4a4a] col-span-2 md:col-span-1 lg:col-span-2 mt-2">
     <!-- دکمه فقط در حالت موبایل -->
      <button 
        class="w-full flex items-center justify-between font-bold  text-lg mb-1  md:mb-0 md:cursor-default md:hidden mt-1"
        onclick="toggleFooterMenu(this)"
      >
        ارتباط با ما
        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
      </button>

     <!-- در تبلیت و لپ تاپ نشون داده میشه-->
      <div class="hidden md:block font-bold text-xl">
       ارتباط با ما
      </div>

      <!-- لیست لینک‌ها -->
      <ul class="overflow-hidden transition-all duration-500 max-h-0 md:max-h-full md:overflow-visible lg:space-y-1.5 space-y-2 text-[#4a4a4a] mt-2 md:mt-4">
        <li class="flex"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="#fafafa"  width="20" height="20" class="ml-2">
                <path d="M32,0C18.746,0,8,10.746,8,24c0,5.219,1.711,10.008,4.555,13.93c0.051,0.094,0.059,0.199,0.117,0.289l16,24 
                C29.414,63.332,30.664,64,32,64s2.586-0.668,3.328-1.781l16-24c0.059-0.09,0.066-0.195,0.117-0.289C54.289,34.008,56,29.219,56,24 
                C56,10.746,45.254,0,32,0z M32,32c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S36.418,32,32,32z"/>
            </svg>
            <a href="#" class="">خراسان رضوی،مشهد،احمد آباد 43 پلاک 67</a></li>
        <li class="flex"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="#fafafa" width="20" height="20" class="ml-2">
                <path d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z"/>
            </svg>
            <a href="#" class="">LusteraShop@gmail.com</a></li>
        <li class="flex"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fafafa"  width="20" height="20" class="ml-2">
                <path d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9509C16.2985 13.7904 16.0777 13.7101 15.8683 13.7237C15.6836 13.7357 15.5059 13.7988 15.3549 13.9058C15.1837 14.0271 15.0629 14.2285 14.8212 14.6314L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.36863 9.17882C9.77145 8.93713 9.97286 8.81628 10.0942 8.64506C10.2012 8.49408 10.2643 8.31637 10.2763 8.1317C10.2899 7.92227 10.2096 7.70153 10.0491 7.26005L8.88299 4.05321C8.745 3.67376 8.67601 3.48403 8.55442 3.3441C8.44701 3.22049 8.31089 3.12515 8.15802 3.06645C7.98496 3 7.78308 3 7.37932 3H4.56201C4.08188 3 3.84181 3 3.63598 3.09925C3.4655 3.18146 3.29814 3.33701 3.2037 3.50103C3.08968 3.69907 3.07375 3.91662 3.04189 4.35173C3.01413 4.73086 3 5.11378 3 5.5Z" 
                stroke="#fafafa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <a href="#" class=""> 989335954178+ </a></li>
      </ul>
    </div>


          
    
        <div class="col-span-1 mt-3 lg:mt-0 md:col-span-3 md:mt-5 lg:col-span-1  ">
           
            <div>
                    <p class="font-semibold md:text-base text-sm text-[#4a4a4a]">همراه ما باشید!</p>
               <div class="flex flex-wrap gap-3 content-center mt-3">
                    <?php if ($facebook): ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="aspect-square  items-center flex justify-center">
                            <svg width="25" height="25" viewBox="0 0 7 16" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" fill="#fafafa" clip-rule="evenodd" d="M1.55073 15.5V7.99941H0V5.41457H1.55073V3.86264C1.55073 1.75393 2.42638 0.5 4.91418 0.5H6.98534V3.08514H5.69072C4.72228 3.08514 4.65821 3.44637 4.65821 4.12054L4.65469 5.41428H7L6.72556 7.99912H4.65469V15.5H1.55073Z" fill="#0A142F" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ($twitter): ?>
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" class="aspect-square w-10 items-center flex justify-center">
                            <svg width="25" height="25" viewBox="0 0 13 12" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" fill="#fafafa" clip-rule="evenodd" d="M6.31224 3.42617L6.34042 3.90195L5.87076 3.84369C4.16119 3.62037 2.66767 2.863 1.39959 1.59102L0.779637 0.959879L0.619952 1.42595C0.281797 2.4649 0.497841 3.56211 1.20233 4.30006C1.57806 4.70787 1.49352 4.76613 0.84539 4.52338C0.619952 4.4457 0.422695 4.38744 0.403908 4.41657C0.338156 4.48454 0.563593 5.36814 0.742064 5.71769C0.986288 6.20318 1.48413 6.67896 2.02893 6.96055L2.4892 7.18387L1.9444 7.19358C1.41838 7.19358 1.39959 7.20329 1.45595 7.4072C1.64381 8.03834 2.38588 8.70831 3.21248 8.99961L3.79486 9.20351L3.28763 9.51423C2.53617 9.96088 1.65321 10.2133 0.770244 10.2328C0.347549 10.2425 0 10.2813 0 10.3104C0 10.4075 1.14597 10.9513 1.81289 11.1649C3.81365 11.796 6.19013 11.5242 7.97484 10.4464C9.24293 9.67929 10.511 8.15485 11.1028 6.67896C11.4222 5.89247 11.7415 4.45541 11.7415 3.76602C11.7415 3.31936 11.7697 3.2611 12.2957 2.72707C12.6057 2.41635 12.8969 2.07651 12.9532 1.97941C13.0472 1.79492 13.0378 1.79492 12.5587 1.95999C11.7603 2.25128 11.6476 2.21245 12.0421 1.7755C12.3333 1.46479 12.6808 0.90162 12.6808 0.736553C12.6808 0.707424 12.5399 0.755973 12.3803 0.843361C12.2112 0.940459 11.8355 1.08611 11.5537 1.17349L11.0464 1.33856L10.5862 1.01814C10.3325 0.843361 9.9756 0.649165 9.78773 0.590906C9.30868 0.454968 8.57601 0.474388 8.14392 0.629745C6.96977 1.06669 6.2277 2.19303 6.31224 3.42617Z" fill="#0A142F" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ($linkedin): ?>
                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="aspect-square w-10 items-center flex  justify-center">
                            <svg width="25" height="25" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 14.5H0V5.5H3V14.5Z" fill="#fafafa" />
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#fafafa" d="M1.49108 3.5H1.47404C0.578773 3.5 0 2.83303 0 1.99948C0 1.14831 0.5964 0.5 1.50865 0.5C2.42091 0.5 2.98269 1.14831 3 1.99948C3 2.83303 2.42091 3.5 1.49108 3.5Z" fill="#0A142F" />
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#fafafa" d="M13.9999 14.4998H11.0519V9.79535C11.0519 8.61371 10.6253 7.80738 9.55814 7.80738C8.74368 7.80738 8.25855 8.35096 8.04549 8.87598C7.96754 9.06414 7.94841 9.3263 7.94841 9.58911V14.5H5C5 14.5 5.03886 6.53183 5 5.70672H7.94841V6.95221C8.33968 6.35348 9.04046 5.5 10.6057 5.5C12.5456 5.5 14 6.75705 14 9.45797L13.9999 14.4998Z" fill="#0A142F" />
                             </svg>
                        </a>
                    <?php endif; ?>
                    <?php if ($telegram): ?>
                        <a href="<?php echo esc_url($telegram); ?>" target="_blank" class="aspect-square w-10 items-center flex justify-center">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                                <path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l.002.001-.314 4.692c.46 0 .663-.211.921-.46l2.211-2.15 4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.434z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
                </div>
            <div class="text-[#4a4a4a]">
                <p class="font-bold md:text-2xl text-xl my-3">  20 % تخفیف بیشتر </p>
                <p class="md:font-semibold text-sm mb-3">با خرید اشتراک ویژه ما به خانواده بزرگ لاسترا بپیوندید</p>
            <div class="flex flex-col gap-1 md:w-100 lg:w-full w-full ">
                <input
                    type="email"
                    placeholder="ایمیل خود را وارد کنید."
                    required
                    class="peer border rounded-lg p-2 border-gray-400
                           placeholder-shown:border-gray-400
                           placeholder-shown:text-gray-600
                           focus:border-sky-500 focus:outline focus:outline-sky-500
                           invalid:border-rose-400 invalid:text-rose-400
                           focus:invalid:border-rose-400 focus:invalid:outline-rose-400
                           invalid:placeholder-shown:border-gray-400
                           invalid:placeholder-shown:text-gray-600 text-sm"/>
                 <p class="hidden peer-focus:peer-invalid:not-placeholder-shown:block text-xs text-red-400 mb-2">
                    ایمیل را درست وارد کنید.
                </p>

                <button
                 class="bg-[#c0c0c0] peer-valid:bg-[#fafafa] peer-valid:text-[#4a4a4a] 
                        peer-valid:hover:bg-[#4a4a4a] peer-valid:hover:text-[#fafafa] 
                        text-[#fafafa] rounded-lg p-2 transition-colors mt-1"> ثبت
                </button>
            </div>
            </div>
       
        </div>
 </div>
 <hr class="border-[#fafafa] w-[90%] mx-auto mt-12 opacity-50 ">
 <p class="text-[#fafafa] text-sm mt-10 text-center">کلیه حقوق این وبسایت متعلق به فروشگاه لاسترا میباشد.©</p>
  
</footer>


















<script>
  function toggleFooterMenu(btn) {
    // فقط در موبایل اجرا بشه
    if (window.innerWidth >= 768) return;

    const ul = btn.nextElementSibling.nextElementSibling; // چون یه div تیتر دسکتاپ هم داریم
    const icon = btn.querySelector("svg");

    if (ul.classList.contains("max-h-40")) {
      ul.classList.remove("max-h-40", "py-2");
      ul.classList.add("max-h-0");
      icon.classList.remove("rotate-180");
    } else {
      ul.classList.remove("max-h-0");
      ul.classList.add("max-h-40", "py-2");
      icon.classList.add("rotate-180");
    }
  }
</script>



 </body>

 </html>