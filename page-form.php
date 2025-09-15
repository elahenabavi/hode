<?php
session_start();
$_SESSION["pay"]="no";
/*
Template Name: حساب کاربری
*/
ob_start();
get_header();
$message = '';
$message_type = ''; // success یا error
// ثبت‌نام
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_user'])) {
    $username = !empty($_POST['reg_username']) ? sanitize_text_field($_POST['reg_username']) : '';
    $email    = !empty($_POST['reg_email']) ? sanitize_email($_POST['reg_email']) : '';
    $password = !empty($_POST['reg_password']) ? $_POST['reg_password'] : '';
    $repassword  = !empty($_POST['reg_repassword']) ? $_POST['reg_repassword'] : '';
    $errors = [];
    if (username_exists($username)) $errors[] = 'نام کاربری قبلاً ثبت شده.';
    if (email_exists($email)) $errors[] = 'ایمیل قبلاً ثبت شده.';
    if (strlen($password) < 8) $errors[] = 'رمز عبور باید حداقل ۸ کاراکتر باشد.';
    if ($password !== $repassword) $errors[] = 'تکرار رمز عبور مطابقت ندارد.';
    if (empty($errors)) {
        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {
            // ورود خودکار
            $creds = [
                'user_login'    => $username,
                'user_password' => $password,
                'remember'      => true
            ];
            $user = wp_signon($creds, false);
            if (!is_wp_error($user)) {
                // ریدایرکت به همین صفحه برای لود نقش
                wp_safe_redirect(get_permalink());
                exit;
            } else {
                $message = '⚠️ خطا در ورود خودکار: ' . $user->get_error_message();
                $message_type = 'error';
            }
        } else {
            $message = '⚠️' . $user_id->get_error_message();
            $message_type = 'error';
        }
    } else {
        $message = '⚠️' . implode('<br>', $errors);
        $message_type = 'error';
    }
}
// ورود
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_user'])) {
    $creds = [
        'user_login'    => sanitize_text_field($_POST['login_username']),
        'user_password' => $_POST['login_password'],
        'remember'      => true
    ];
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        $message = '⚠️ ورود ناموفق: ' . $user->get_error_message();
        $message_type = 'error';
    } else {
        // ریدایرکت به همین صفحه برای لود نقش
        wp_safe_redirect(get_permalink());
        exit;
    }
}
$form_mode = 'login'; // پیش‌فرض فرم ورود
// اگر ثبت‌نام ارسال شده یا خطا داشتیم، فرم ثبت‌نام رو فعال کن
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_user'])) {
    $form_mode = 'register';
}
// اگر ورود ارسال شده، فرم ورود رو فعال کن
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_user'])) {
    $form_mode = 'login';
}
?>

<?php if (!empty($message)): ?>
  <div id="customAlert" class="fixed lg:top-[25%] lg:right-3 top-37 right-0 ml-6 md:top-[20%]  transform  
  mt-2 z-50 flex items-start gap-4 px-5 py-4 rounded-lg shadow-xl text-[#fafafa] text-sm leading-relaxed
    <?php echo ($message_type === 'success') ? 'bg-[#74c69d]' : 'bg-[#e35053]'; ?>">
    
    <div class="flex-1"><?php echo $message; ?></div>
    
    <button onclick="closeAlert()" class="text-[#fafafa] text-xl font-bold hover:text-gray-200">&times;</button>
  </div>
<?php endif; ?>
  <h1 class="text-center text-[#c9a6df] md:text-3xl text-2xl font-bold md:mt-22 mt-17">به لاسترا خوش اومدی:)</h1>
<div class="relative w-[90%] md:w-[70%] lg:w-[60%]  h-[580px] mx-auto mt-7 md:mb-22 mb-17 bg-white shadowbox rounded-xl overflow-hidden">
  <div id="imageContainer" class="absolute top-0 left-0 w-1/2 h-full z-10 slide-image hidden lg:block">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/form.jpg" alt="اکسسوری" class="w-full h-full object-cover rounded-l-xl" />
  </div>
  <!-- فرم‌ها -->
  <div class="w-full h-full flex relative">
    <!-- فرم ثبت‌نام -->
    <div id="registerForm" class="form-panel absolute left-0 lg:w-1/2 w-full h-full flex flex-col justify-center items-center
     px-10 bg-[#fafafa] <?php echo ($form_mode === 'register') ? 'visible-panel' : 'hidden-panel' ?> opacity-0 lg:opacity-100">
      <h2 class="text-3xl font-bold text-[#4a4a4a] mb-2">ثبت‌نام</h2>
      <form method="post" class=" w-full ">
        <label for="reg_username " class="text-[#4a4a4a] text-base text-end font-semibold ">نام کاربری</label>
        <input type="text" name="reg_username"  required class="w-full px-4 py-2 mt-1 mb-4 border border-[#c0c0c0] 
        rounded focus:outline focus:outline-[#c9a6df] border-1.5 focus:ring-[#c9a6df]"
        value="<?php echo isset($_POST['reg_username']) ? esc_attr($_POST['reg_username']) : ''; ?>">

        <label for="reg_email" class="text-[#4a4a4a] text-base text-end font-semibold ">ایمیل</label>  
        <input type="email" name="reg_email"
                    class="w-full px-4 py-2.5 mt-1 border border-[#c0c0c0] rounded mb-4
                           invalid:border-red-400 invalid:text-red-500 focus:border-sky-500
                           focus:outline focus:outline-[#c9a6df] focus:invalid:border-red-500
                           focus:invalid:outline-red-400 disabled:border-gray-200 disabled:bg-gray-50
                           disabled:text-gray-500 disabled:shadow-none text-sm"
                           value="<?php echo isset($_POST['reg_email']) ? esc_attr($_POST['reg_email']) : ''; ?>" />
                 <p class="hidden peer-focus:peer-invalid:not-placeholder-shown:block text-xs text-red-400 mb-2">
                    ایمیل را درست وارد کنید.
                </p>
        <label for="login_password" class="text-[#4a4a4a] text-base text-end font-semibold">رمز عبور</label>
        <input type="password" id="reg_password" name="reg_password" required
              class="w-full px-4 mt-1 py-1.5 border border-[#c0c0c0] rounded focus:outline focus:outline-[#c9a6df] border-1.5 focus:ring-[#c9a6df] ">
        <label class="flex items-center gap-2  text-xs text-[#4a4a4a] ml-auto mt-1 mb-4">
        <input type="checkbox" onclick="togglePassword()" class="cursor-pointer">
              نمایش رمز عبور
        </label>
        <label for="repassword" class="text-[#4a4a4a] text-base text-end font-semibold">تکرار رمز عبور</label>
        <input type="password" id="reg_repassword" name="reg_repassword" required
              class="w-full mt-1 px-4 py-2 border border-[#c0c0c0] rounded focus:outline focus:outline-[#c9a6df] border-1.5 focus:ring-[#c9a6df] ">
        <label class="flex items-center gap-2  text-xs text-[#4a4a4a] ml-auto mt-1">
        <input type="checkbox" onclick="togglePassword2()" class="cursor-pointer ">
              نمایش رمز عبور
        </label>
        <input type="submit" name="register_user" value="ثبت‌نام" class="w-full bg-[#c9a6df] 
        text-[#fafafa] py-2 rounded hover:bg-[#c0c0c0] transition mt-4">
      </form>
      <p class="mt-4 text-sm text-[#4a4a4a]">قبلاً ثبت‌نام کردید؟ 
        <button onclick="showLogin()" class="text-[#a889d9] hover:underline">وارد شوید</button>
      </p>
    </div>
    <!-- فرم ورود  c9a6df-->
    <div id="loginForm" class="form-panel absolute right-0 lg:w-1/2 w-full  h-full  items-center px-10
     bg-[#fafafa] <?php echo ($form_mode === 'login') ? 'visible-panel' : 'hidden-panel'; ?> flex flex-col justify-center">
      <h2 class="text-3xl font-bold text-[#4a4a4a] mb-2">ورود</h2>
      <p class="text-[#4a4a4a] opacity-50 text-sm mb-7">خوش آمدید!لطفا اطلاعات خود را وارد کنید.</p>
      <form method="post" class="space-y-5 w-full ">
        <label for="login_username " class="text-[#4a4a4a] text-base text-end font-semibold ">نام کاربری</label>
        <input type="text" name="login_username" required class="w-full px-4 py-2 mt-1 border 
        border-[#c0c0c0] rounded focus:outline focus:outline-[#c9a6df] border-1.5 focus:ring-[#c9a6df]"
        value="<?php echo isset($_POST['login_username']) ? esc_attr($_POST['login_username']) : ''; ?>">
        <label for="login_password" class="text-[#4a4a4a] text-base text-end font-semibold">رمز عبور</label>
        <input type="password" id="login_password" name="login_password" required
              class="w-full mt-1 px-4 py-2 border border-[#c0c0c0] rounded focus:outline focus:outline-[#c9a6df] border-1.5 focus:ring-[#c9a6df]">
        <!-- چک‌باکس برای نمایش رمز -->
            <label class="flex items-center gap-2  text-xs text-[#4a4a4a] ml-auto">
            <input type="checkbox" onclick="togglePassword3()" class="cursor-pointer">
              نمایش رمز عبور
            </label>
           
            <input type="submit" name="login_user" value="ورود" class="w-full bg-[#c9a6df] text-[#fafafa] py-2 rounded hover:bg-[#c0c0c0] transition mt-8">
        </form>
      <p class="mt-4 text-sm text-[#4a4a4a] ">ثبت‌نام نکردید؟ 
        <button onclick="showRegister()" class="text-[#a889d9] hover:underline">همین حالا ثبت‌نام کنید</button>
      </p>
    </div>

  </div>
</div>
<?php get_footer(); ob_end_flush(); ?>