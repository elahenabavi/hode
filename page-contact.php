<?php
session_start();
$_SESSION["pay"]="no";
/*
Template Name: ارتباط با ما
*/
get_header();
    $facebook  = get_theme_mod('hodcode_facebook');
    $twitter   = get_theme_mod('hodcode_twitter');
    $linkedin = get_theme_mod('hodcode_linkedin');
    $telegram = get_theme_mod('hodcode_telegram');
    $instagram = get_theme_mod('hodcode_instagram');
  
?>
<div class="max-w-[80%] mx-auto  ">
<div class="flex mt-15">
    <hr class="w-10 border border-2 border-[#c9a6df] my-auto rounded ">
    <p class="text-[#4a4a4a] font-semibold mr-3">تماس با ما</p>
</div>
<p class="mt-5 text-lg text-[#4a4a4a] font-semibold">همواره در کنار شما هستیم!</p>
<p class="text-[#4a4a4a] mt-6 mb-10 text-base opacity-75 "> در صورت بروز مشکل و اختلال در سایت، همکاری و یا حتی راجع به ارسال سفارشی محصولات میتوانید از طریق فرم تماس با ما در ارتباط باشید. در اسرع وقت همکاران ما جهت برطرف کردن مشکل با شما تماس خواهند گرفت. </p>
<div class="grid lg:grid-cols-2 grid-cols-1 gap-x-10 gap-6">

<div class="">
    <p class="font-semibold text-2xl pt-8 text-[#c9a6df] ">اطلاعات تماس</p>
    <p class="text-[#4a4a4a] opacity-75 text-base mt-4 mb-8">        همچنین شما میتوانید برای سوالات تخصصی تر از طریق راه های ارتباطی دیگر ما را در جریان بزارید و انتقادات و پیشنهادات خودتون رو راجع به ارتقای کیفیت مجموعه به ما برسونید:) </p>
    <span class="flex">
        <a href="" class="p-2 bg-[#c9a6df] rounded-full items-center flex justify-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="#fafafa"  width="20" height="20" class="">
                <path d="M32,0C18.746,0,8,10.746,8,24c0,5.219,1.711,10.008,4.555,13.93c0.051,0.094,0.059,0.199,0.117,0.289l16,24 
                C29.414,63.332,30.664,64,32,64s2.586-0.668,3.328-1.781l16-24c0.059-0.09,0.066-0.195,0.117-0.289C54.289,34.008,56,29.219,56,24 
                C56,10.746,45.254,0,32,0z M32,32c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S36.418,32,32,32z"/>
            </svg>
        </a>
         <p class="self-center  font-semibold md:text-lg text-base text-[#4a4a4a] pr-3">آدرس:</p>
        <p class="self-center md:text-lg text-sm text-[#4a4a4a] px-1 ">مشهد،احمدآباد43،پلاک 67</p>
    </span>
    <span class="flex my-6">
        <a href="" class="p-2 bg-[#c9a6df] rounded-full items-center flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fafafa"  width="20" height="20" class="">
                <path d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9509C16.2985 13.7904 16.0777 13.7101 15.8683 13.7237C15.6836 13.7357 15.5059 13.7988 15.3549 13.9058C15.1837 14.0271 15.0629 14.2285 14.8212 14.6314L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.36863 9.17882C9.77145 8.93713 9.97286 8.81628 10.0942 8.64506C10.2012 8.49408 10.2643 8.31637 10.2763 8.1317C10.2899 7.92227 10.2096 7.70153 10.0491 7.26005L8.88299 4.05321C8.745 3.67376 8.67601 3.48403 8.55442 3.3441C8.44701 3.22049 8.31089 3.12515 8.15802 3.06645C7.98496 3 7.78308 3 7.37932 3H4.56201C4.08188 3 3.84181 3 3.63598 3.09925C3.4655 3.18146 3.29814 3.33701 3.2037 3.50103C3.08968 3.69907 3.07375 3.91662 3.04189 4.35173C3.01413 4.73086 3 5.11378 3 5.5Z" 
                stroke="#fafafa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        </a>
        <p class="self-center  font-semibold md:text-lg text-base text-[#4a4a4a] pr-3">  تلفن:</p>
        <p class="self-center md:text-lg text-sm text-[#4a4a4a] px-1">989335954178+</p>
    </span>
    <span class="flex ">
        <a href="" class="  p-2 bg-[#c9a6df] rounded-full items-center flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="#fafafa" width="20" height="20" class="">
                <path d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z"/>
            </svg>
        </a>
        <p class="self-center  font-semibold md:text-lg text-base text-[#4a4a4a] pr-3"> ایمیل:</p>
        <p class="self-center md:text-lg text-sm text-[#4a4a4a] px-1">LusteraShop@gmail.com</p>
    </span>
    <span class="flex my-6">
        <a href="" class="  p-1.5 bg-[#c9a6df] rounded-full items-center flex justify-center">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fafafa" width="25" height="25">
                <path d="M14.982 19.61c.454-.7.909-1.6 1.236-2.755.755.29 1.273.636 1.591.909a8.182 8.182 0 0 1-2.864 1.845h.037v.001zm-8.8-1.855c.336-.273.845-.61 1.6-.91.336 1.164.773 2.064 1.236 2.764A8.2 8.2 0 0 1 6.2 17.755h-.018zm10.636-6.664c-.028-.81-.11-1.619-.245-2.418 1-.364 1.727-.8 2.236-1.2a8.136 8.136 0 0 1 1.282 3.618h-3.273zm-8.973-4.2a5.936 5.936 0 0 1-1.481-.8 8.2 8.2 0 0 1 2.654-1.7c-.427.636-.845 1.454-1.182 2.5h.01-.001zm7.137-2.5a8.145 8.145 0 0 1 2.654 1.7 6.01 6.01 0 0 1-1.481.8 9.58 9.58 0 0 0-1.182-2.5h.009zM14.8 9.118c.09.6.182 1.246.2 1.973H9c.027-.727.09-1.382.182-1.973 1.855.334 3.754.334 5.609 0h.009zM12 7.545c-.91 0-1.71-.072-2.39-.181.726-2.237 1.854-3.137 2.39-3.455.518.318 1.655 1.227 2.382 3.455A15.04 15.04 0 0 1 12 7.545zm-6.818-.072a8.03 8.03 0 0 0 2.245 1.2 18.368 18.368 0 0 0-.245 2.418h-3.31a8.13 8.13 0 0 1 1.319-3.618h-.01.001zm-1.3 5.436h3.3c.036.782.09 1.5.2 2.155a7.682 7.682 0 0 0-2.31 1.272 8.11 8.11 0 0 1-1.2-3.427h.01zM12 14.364c-1.09 0-2.027.09-2.845.236A16.91 16.91 0 0 1 9 12.91h6c-.027.608-.073 1.18-.145 1.69A15.388 15.388 0 0 0 12 14.355v.009zm0 5.727c-.545-.327-1.745-1.3-2.473-3.727A14.095 14.095 0 0 1 12 16.182c.955 0 1.773.063 2.482.182-.727 2.454-1.927 3.4-2.473 3.727H12zm6.927-3.764a7.634 7.634 0 0 0-2.309-1.272 17.95 17.95 0 0 0 .2-2.146h3.31a8.11 8.11 0 0 1-1.2 3.418h-.001zM12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z"/>
            </svg>
        </a>
        <p class="self-center  font-semibold md:text-lg text-base text-[#4a4a4a] pr-3">وبسایت:</p>
        <a href="www.partschool.ir" class="self-center md:text-lg text-sm text-[#4a4a4a] px-1">Partschool.ir</a>
    </span>


    

</div>

<div class="">
    
        <form action="" class=" rounded-lg bg-[#fafafa] shadowbox3 flex flex-col p-8 border border-[#c0c0c0]">
            <p class="pb-5 text-2xl text-[#c9a6df] font-semibold">تماس با ما</p>
            <label for="name-contact" class=" text-[#4a4a4a]">نام</label>
            <input type="text" name="name-contact" placeholder="نام خود را وارد نمایید."
             class="mt-2 mb-5
      focus:outline focus:outline-[#c9a6df] disabled:border-[#c0c0c0]
      disabled:text-[#c0c0c0] disabled:shadow-none text-xs focus:text-sm 
      border border-[#c0c0c0] border-1.5 focus:py-2.5
       py-3 rounded-lg px-2">
            <label for="email-contact" class=" text-[#4a4a4a]">ایمیل</label>
            <input type="email" name="email-contact"  placeholder="ایمیل خود را وارد نمایید."
            class="peer focus:outline focus:outline-[#c9a6df] disabled:border-[#c0c0c0]
                    disabled:text-[#c0c0c0] disabled:shadow-none text-xs focus:text-sm 
                           border border-[#c0c0c0] border-1.5  focus:py-2.5
                           py-3 rounded-lg px-2
                            mt-2 mb-5
                           invalid:border-rose-400 invalid:text-rose-400
                           focus:invalid:border-rose-400 focus:invalid:outline-rose-400
                            text-sm">
            <label for="text-contact " class=" text-[#4a4a4a]">متن پیام</label>
            <textarea name="text-contact" id="" placeholder="متن مورد نظر را وارد نمایید."
            class=" mt-2
      focus:outline focus:outline-[#c9a6df] disabled:border-[#c0c0c0] 
      disabled:text-[#c0c0c0] disabled:shadow-none text-xs focus:text-sm 
      border border-[#c0c0c0] border-1.5 focus:py-2.5
      py-3 pr-2 rounded-lg h-25 resize-none"></textarea>
            <button class="mt-8  py-2.5 hover:bg-[#c0c0c0] bg-[#c9a6df]  text-[#fafafa] rounded-lg text-sm ">ارسال پیام</button>
</form>
 
</div>

</div>

<div class="flex justify-center md:space-x-8  space-x-4 mt-20">
 <span class=" ">
    <?php if ($instagram): ?>
        <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="aspect-square 
        w-14 h-14 bg-[#c0c0c0] items-center flex justify-center rounded-md 
        transition lg:hover:scale-110 hover:bg-[#c9a6df] p-3 md:p-0 md:w-16 md:h-16">                
 
  <svg width="32" height="32" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#fafafa" aria-hidden="true">
      <path transform="translate(-284 -7279)" d="M289.869652,7279.12273 C288.241769,7279.19618 286.830805,7279.5942 285.691486,7280.72871 C284.548187,7281.86918 284.155147,7283.28558 284.081514,7284.89653 C284.035742,7285.90201 283.768077,7293.49818 284.544207,7295.49028 C285.067597,7296.83422 286.098457,7297.86749 287.454694,7298.39256 C288.087538,7298.63872 288.809936,7298.80547 289.869652,7298.85411 C298.730467,7299.25511 302.015089,7299.03674 303.400182,7295.49028 C303.645956,7294.859 303.815113,7294.1374 303.86188,7293.08031 C304.26686,7284.19677 303.796207,7282.27117 302.251908,7280.72871 C301.027016,7279.50685 299.5862,7278.67508 289.869652,7279.12273 M289.951245,7297.06748 C288.981083,7297.0238 288.454707,7296.86201 288.103459,7296.72603 C287.219865,7296.3826 286.556174,7295.72155 286.214876,7294.84312 C285.623823,7293.32944 285.819846,7286.14023 285.872583,7284.97693 C285.924325,7283.83745 286.155174,7282.79624 286.959165,7281.99226 C287.954203,7280.99968 289.239792,7280.51332 297.993144,7280.90837 C299.135448,7280.95998 300.179243,7281.19026 300.985224,7281.99226 C301.980262,7282.98483 302.473801,7284.28014 302.071806,7292.99991 C302.028024,7293.96767 301.865833,7294.49274 301.729513,7294.84312 C300.829003,7297.15085 298.757333,7297.47145 289.951245,7297.06748 M298.089663,7283.68956 C298.089663,7284.34665 298.623998,7284.88065 299.283709,7284.88065 C299.943419,7284.88065 300.47875,7284.34665 300.47875,7283.68956 C300.47875,7283.03248 299.943419,7282.49847 299.283709,7282.49847 C298.623998,7282.49847 298.089663,7283.03248 298.089663,7283.68956 M288.862673,7288.98792 C288.862673,7291.80286 291.150266,7294.08479 293.972194,7294.08479 C296.794123,7294.08479 299.081716,7291.80286 299.081716,7288.98792 C299.081716,7286.17298 296.794123,7283.89205 293.972194,7283.89205 C291.150266,7283.89205 288.862673,7286.17298 288.862673,7288.98792 M290.655732,7288.98792 C290.655732,7287.16159 292.140329,7285.67967 293.972194,7285.67967 C295.80406,7285.67967 297.288657,7287.16159 297.288657,7288.98792 C297.288657,7290.81525 295.80406,7292.29716 293.972194,7292.29716 C292.140329,7292.29716 290.655732,7290.81525 290.655732,7288.98792"/>
    </svg>
        </a>
    <?php endif; ?>

 </span>
<span class="">
    <?php if ($facebook): ?>
        <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="aspect-square 
        w-14 h-14 bg-[#c0c0c0]  items-center flex justify-center rounded-md transition 
        lg:hover:scale-110 hover:bg-[#c9a6df] p-3 md:p-0 md:w-16 md:h-16">
            <svg width="32" height="32" viewBox="0 0 7 16" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" fill="#fafafa" clip-rule="evenodd" d="M1.55073 15.5V7.99941H0V5.41457H1.55073V3.86264C1.55073 1.75393 2.42638 0.5 4.91418 0.5H6.98534V3.08514H5.69072C4.72228 3.08514 4.65821 3.44637 4.65821 4.12054L4.65469 5.41428H7L6.72556 7.99912H4.65469V15.5H1.55073Z" fill="#0A142F" />
            </svg>
        </a>
        <?php endif; ?>
</span>
<span class=" ">
    <?php if ($twitter): ?>
        <a href="<?php echo esc_url($twitter); ?>" target="_blank" class="aspect-square
         w-14 h-14 bg-[#c0c0c0] items-center flex justify-center rounded-md 
         transition lg:hover:scale-110 hover:bg-[#c9a6df] p-3 md:p-0 md:w-16 md:h-16">
            <svg width="32" height="32" viewBox="0 0 13 12" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" fill="#fafafa" clip-rule="evenodd" d="M6.31224 3.42617L6.34042 3.90195L5.87076 3.84369C4.16119 3.62037 2.66767 2.863 1.39959 1.59102L0.779637 0.959879L0.619952 1.42595C0.281797 2.4649 0.497841 3.56211 1.20233 4.30006C1.57806 4.70787 1.49352 4.76613 0.84539 4.52338C0.619952 4.4457 0.422695 4.38744 0.403908 4.41657C0.338156 4.48454 0.563593 5.36814 0.742064 5.71769C0.986288 6.20318 1.48413 6.67896 2.02893 6.96055L2.4892 7.18387L1.9444 7.19358C1.41838 7.19358 1.39959 7.20329 1.45595 7.4072C1.64381 8.03834 2.38588 8.70831 3.21248 8.99961L3.79486 9.20351L3.28763 9.51423C2.53617 9.96088 1.65321 10.2133 0.770244 10.2328C0.347549 10.2425 0 10.2813 0 10.3104C0 10.4075 1.14597 10.9513 1.81289 11.1649C3.81365 11.796 6.19013 11.5242 7.97484 10.4464C9.24293 9.67929 10.511 8.15485 11.1028 6.67896C11.4222 5.89247 11.7415 4.45541 11.7415 3.76602C11.7415 3.31936 11.7697 3.2611 12.2957 2.72707C12.6057 2.41635 12.8969 2.07651 12.9532 1.97941C13.0472 1.79492 13.0378 1.79492 12.5587 1.95999C11.7603 2.25128 11.6476 2.21245 12.0421 1.7755C12.3333 1.46479 12.6808 0.90162 12.6808 0.736553C12.6808 0.707424 12.5399 0.755973 12.3803 0.843361C12.2112 0.940459 11.8355 1.08611 11.5537 1.17349L11.0464 1.33856L10.5862 1.01814C10.3325 0.843361 9.9756 0.649165 9.78773 0.590906C9.30868 0.454968 8.57601 0.474388 8.14392 0.629745C6.96977 1.06669 6.2277 2.19303 6.31224 3.42617Z" fill="#0A142F" />
            </svg>
        </a>
    <?php endif; ?>
</span>
<span class=" ">
    <?php if ($linkedin): ?>
        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="aspect-square
         w-14 h-14 bg-[#c0c0c0] items-center flex  justify-center rounded-md transition 
         lg:hover:scale-110 hover:bg-[#c9a6df] p-3 md:p-0 md:w-16 md:h-16">
            <svg width="32" height="32" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 14.5H0V5.5H3V14.5Z" fill="#fafafa" />
                <path fill-rule="evenodd" clip-rule="evenodd" fill="#fafafa" d="M1.49108 3.5H1.47404C0.578773 3.5 0 2.83303 0 1.99948C0 1.14831 0.5964 0.5 1.50865 0.5C2.42091 0.5 2.98269 1.14831 3 1.99948C3 2.83303 2.42091 3.5 1.49108 3.5Z" fill="#0A142F" />
                <path fill-rule="evenodd" clip-rule="evenodd" fill="#fafafa" d="M13.9999 14.4998H11.0519V9.79535C11.0519 8.61371 10.6253 7.80738 9.55814 7.80738C8.74368 7.80738 8.25855 8.35096 8.04549 8.87598C7.96754 9.06414 7.94841 9.3263 7.94841 9.58911V14.5H5C5 14.5 5.03886 6.53183 5 5.70672H7.94841V6.95221C8.33968 6.35348 9.04046 5.5 10.6057 5.5C12.5456 5.5 14 6.75705 14 9.45797L13.9999 14.4998Z" fill="#0A142F" />
            </svg>
        </a>
    <?php endif; ?>
</span>
<span class=" ">
      <?php if ($telegram): ?>
            <a href="<?php echo esc_url($telegram); ?>" target="_blank" class="aspect-square
             w-14 h-14 bg-[#c0c0c0] items-center flex justify-center rounded-md transition 
             lg:hover:scale-110 hover:bg-[#c9a6df] p-3 md:p-0 md:w-16 md:h-16">
                <svg viewBox="0 0 24 24" width="32" height="32" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                    <path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l.002.001-.314 4.692c.46 0 .663-.211.921-.46l2.211-2.15 4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.434z"/>
                </svg>
            </a>
      <?php endif; ?>
</span>
</div>

</div>

<div class="w-full md:mt-25 mt-19">
  <h2 class="text-2xl font-bold text-center mb-4 text-[#4a4a4a] opacity-75">
    موقعیت فروشگاه لاسترا
  </h2>
  <div class="relative w-full h-96 rounded-lg overflow-hidden shadow-lg">
    <!-- نقشه گوگل -->
    <iframe 
      class="w-full h-full"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3238.689010062091!2d59.56782511525952!3d36.31088798005095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f6c91b5c3b7d70d%3A0x5d9dbbb3b27a4f6c!2sMashhad%2C%20Ahmadabad%2043!5e0!3m2!1sen!2sir!4v1695138240000!5m2!1sen!2sir" 
      allowfullscreen="" 
      loading="lazy" 
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
</div>

<?php


get_footer();














