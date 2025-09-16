<?php
session_start();
$_SESSION["pay"]="no";
/* home.php - Blog index (custom fancy layout) */
get_header();
?>
<main class="bg-[#f8f8f8] min-h-screen py-12">
  <div class="container mx-auto px-4 lg:max-w-6xl max-w-[80%]">
    <header class="mb-8 text-center">
      <h1 class="lg:text-3xl text-2xl md:text-5xl font-semibold text-[#4a4a4a]">بلاگ لاسترا</h1>
      <p class="mt-3 text-[#4a4a4a] opacity-75 md:text-base text-sm">مطالب و ترندهای مد و اکسسوری — بررسی استایل، ایده‌ها و راهنمای انتخاب</p>
    </header>
    <!-- ساختار کلی -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="posts-grid">
      <?php if (have_posts()) : while (have_posts()) : the_post(); 
        $likes = get_post_meta(get_the_ID(), '_hod_like_count', true) ?: 0;
      ?>
        <article class="post-card bg-[#fafafa] rounded-xl shadowbox2 overflow-hidden transform transition duration-500 hover:scale-[1.02]  will-change-transform"
                 data-post-id="<?php the_ID(); ?>">
          <!-- عکس -->
          <div class="relative overflow-hidden h-64">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover transition-transform duration-700 ease-out post-img']); ?>
            <?php else: ?>
              <div class="w-full h-full bg-gradient-to-tr from-[#c0c0c0] to-gray-300 flex items-center justify-center">
                <span class="text-[#4a4a4a]">بدون تصویر</span>
              </div>
            <?php endif; ?>
          </div>
            <!-- دکمه برای ادامه مطالب -->
            <a href="<?php the_permalink(); ?>"
               class="continue-btn absolute left-4 top-58 w-12 h-12 rounded-full bg-[#fafafa] flex items-center justify-center transition-transform duration-300 group-hover:scale-[1.05] hover:rotate-10 "
               aria-label="<?php echo esc_attr('ادامه مطلب: '.get_the_title()); ?>">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" class="transform -rotate-45">
                <path d="M5 12h14M12 5l7 7-7 7" stroke="#c9a6df" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          <!-- محتوا -->
          <div class="p-6">
            <div class="meta flex items-center justify-between mb-3">
              <div class="author flex items-center gap-3">
                <?php if (get_avatar(get_the_author_meta('ID'), 40)): ?>
                  <div class="w-8 h-8 rounded-full overflow-hidden">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                  </div>
                <?php endif; ?>
                <div class="text-sm">
                  <p class="font-medium text-[#4a4a4a] opacity-75"><?php the_author(); ?></p>
                  <p class="text-xs text-[#4a4a4a] opacity-75"><?php echo get_the_date('j F Y'); ?></p>
                </div>
              </div>
              <div class="reading-time text-xs text-[#4a4a4a] opacity-75">
                <?php
                  $words = str_word_count(strip_tags(get_the_content()));
                  $mins = max(1, round($words / 200));?>
                <span><?php echo $mins; ?> دقیقه خواندن</span>
              </div>
            </div>
            <h2 class="post-title text-lg text-[#4a4a4a] font-semibold mb-3">
              <a class="hover:text-[#c9a6df]" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p class="post-excerpt text-[#4a4a4a] opacity-75 mb-4">
              <?php echo wp_trim_words(get_the_excerpt() ? get_the_excerpt() : get_the_content(), 28); ?>
            </p>
            <!-- دکمه لایک  -->
            <div class="flex items-center justify-between mt-3">
              <button class="like-btn flex items-center gap-2 text-lg opacity-75 text-[#4a4a4a] hover:text-[#e0170a] transition"
                      aria-pressed="<?php echo ($likes>0 ? 'true':'false'); ?>" data-post="<?php the_ID(); ?>">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="25" height="28" class="cursor-pointer">
                    <path d="M12 6C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6Z" stroke="#e0170a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="like-count text-sm"><?php echo $likes; ?></span>
              </button>
              <a href="<?php the_permalink(); ?>" class="hover:text-[#c9a6df] hover:underline text-[#4a4a4a]">ادامه مطلب</a>
            </div>
          </div>
        </article>
      <?php endwhile; else: ?>
        <p class="text-[#4a4a4a]">هنوز نوشته‌ای منتشر نشده است.</p>
      <?php endif; ?>
    </section>
    <!-- pagination -->
<?php
if ( function_exists( 'woocommerce_pagination' ) ) {
    woocommerce_pagination();
}
?>

  </div>
</main>
<script>
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
</script>
<?php get_footer(); ?>
