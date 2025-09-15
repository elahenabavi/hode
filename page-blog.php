<?php 
session_start();
$_SESSION["pay"]="no";
get_header();
?>

<div class="container mx-auto px-4 py-10">
  <h1 class="text-3xl font-bold mb-8">بلاگ ما</h1>

  <?php if (have_posts()) : ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while (have_posts()) : the_post(); ?>
        <article class="bg-white shadow rounded-xl overflow-hidden">
          <!-- تصویر شاخص -->
          <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover']); ?>
            </a>
          <?php endif; ?>

          <div class="p-4">
            <!-- عنوان -->
            <h2 class="text-xl font-semibold mb-2">
              <a href="<?php the_permalink(); ?>" class="hover:text-blue-600">
                <?php the_title(); ?>
              </a>
            </h2>

            <!-- خلاصه -->
            <p class="text-gray-600 mb-3">
              <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
            </p>

            <!-- دکمه ادامه مطلب -->
            <a href="<?php the_permalink(); ?>" class="text-sm text-blue-500 hover:underline">
              ادامه مطلب →
            </a>
          </div>
        </article>
      <?php endwhile; ?>
    </div>

    <!-- صفحه بندی -->
    <div class="mt-8">
      <?php the_posts_pagination([
        'prev_text' => '« قبلی',
        'next_text' => 'بعدی »',
      ]); ?>
    </div>

  <?php else : ?>
    <p>هنوز هیچ نوشته‌ای منتشر نشده است.</p>
  <?php endif; ?>
</div>
<?php


get_footer();
?>