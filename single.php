<?php
session_start();
$_SESSION["pay"]="no";
/* single.php - single post layout */
get_header();
?>

<main class="bg-[#f8f8f8] min-h-screen py-12">
  <div class="container mx-auto px-4 max-w-6xl">
    <article class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <aside class="order-1 lg:order-2 lg:col-span-1">
        <div class="sticky top-24 space-y-4">
          <div class="bg-[#fafafa] p-4 rounded-xl shadowbox2">
            <h3 class="text-sm font-semibold mb-3 text-[#c9a6df]">مطالب دیگر</h3>
            <?php
              $related = new WP_Query([
                'posts_per_page' => 5,
                'post__not_in' => [get_the_ID()],
                'orderby' => 'rand',
              ]);
              if ($related->have_posts()):
                while ($related->have_posts()): $related->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 transition">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('thumbnail', ['class'=>'w-14 h-10 object-cover rounded']); ?>
                  <?php endif; ?>
                  <div class="text-sm">
                    <p class="font-medium text-[#4a4a4a] leading-tight hover:text-[#c9a6df]"><?php the_title(); ?></p>
                    <p class="text-xs text-[#4a4a4a] opacity-75 mt-1"><?php the_time('j M Y'); ?></p>
                  </div>
                </a>
              <?php endwhile; wp_reset_postdata(); endif; ?>
          </div>

          <!-- share -->
          <div class="bg-[#fafafa] p-4 rounded-xl shadow">
            <h4 class="text-sm font-semibold mb-3 text-[#4a4a4a]">اشتراک‌گذاری</h4>
            <div class="flex justify-center gap-3">
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="p-2 rounded-full bg-[#c9a6df] hover:bg-[#c0c0c0] ">
                <svg width="25" height="25" viewBox="0 0 7 16" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" fill="#fafafa" clip-rule="evenodd" d="M1.55073 15.5V7.99941H0V5.41457H1.55073V3.86264C1.55073 1.75393 2.42638 0.5 4.91418 0.5H6.98534V3.08514H5.69072C4.72228 3.08514 4.65821 3.44637 4.65821 4.12054L4.65469 5.41428H7L6.72556 7.99912H4.65469V15.5H1.55073Z" fill="#0A142F" />
            </svg>
              </a>
              <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="p-2 rounded-full bg-[#c9a6df] hover:bg-[#c0c0c0]">
                <svg width="25" height="25" viewBox="0 0 13 12" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" fill="#fafafa" clip-rule="evenodd" d="M6.31224 3.42617L6.34042 3.90195L5.87076 3.84369C4.16119 3.62037 2.66767 2.863 1.39959 1.59102L0.779637 0.959879L0.619952 1.42595C0.281797 2.4649 0.497841 3.56211 1.20233 4.30006C1.57806 4.70787 1.49352 4.76613 0.84539 4.52338C0.619952 4.4457 0.422695 4.38744 0.403908 4.41657C0.338156 4.48454 0.563593 5.36814 0.742064 5.71769C0.986288 6.20318 1.48413 6.67896 2.02893 6.96055L2.4892 7.18387L1.9444 7.19358C1.41838 7.19358 1.39959 7.20329 1.45595 7.4072C1.64381 8.03834 2.38588 8.70831 3.21248 8.99961L3.79486 9.20351L3.28763 9.51423C2.53617 9.96088 1.65321 10.2133 0.770244 10.2328C0.347549 10.2425 0 10.2813 0 10.3104C0 10.4075 1.14597 10.9513 1.81289 11.1649C3.81365 11.796 6.19013 11.5242 7.97484 10.4464C9.24293 9.67929 10.511 8.15485 11.1028 6.67896C11.4222 5.89247 11.7415 4.45541 11.7415 3.76602C11.7415 3.31936 11.7697 3.2611 12.2957 2.72707C12.6057 2.41635 12.8969 2.07651 12.9532 1.97941C13.0472 1.79492 13.0378 1.79492 12.5587 1.95999C11.7603 2.25128 11.6476 2.21245 12.0421 1.7755C12.3333 1.46479 12.6808 0.90162 12.6808 0.736553C12.6808 0.707424 12.5399 0.755973 12.3803 0.843361C12.2112 0.940459 11.8355 1.08611 11.5537 1.17349L11.0464 1.33856L10.5862 1.01814C10.3325 0.843361 9.9756 0.649165 9.78773 0.590906C9.30868 0.454968 8.57601 0.474388 8.14392 0.629745C6.96977 1.06669 6.2277 2.19303 6.31224 3.42617Z" fill="#0A142F" />
            </svg>
              </a>
              <a href="https://t.me/share/url?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="p-2 rounded-full bg-[#c9a6df] hover:bg-[#c0c0c0] ">
                <svg viewBox="0 0 24 24" width="25" height="25" fill="#fafafa" xmlns="http://www.w3.org/2000/svg">
                    <path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l.002.001-.314 4.692c.46 0 .663-.211.921-.46l2.211-2.15 4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.434z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </aside>

      <!-- main column -->
      <div class="order-1 lg:order-1 lg:col-span-2 bg-[#fafafa] rounded-2xl shadow-md shadowbox2 p-8">
        <header class="mb-2">
          <h1 class="text-3xl font-semibold text-[#4a4a4a] mb-2"><?php the_title(); ?></h1>
          <div class="flex items-center gap-4 text-sm text-[#4a4a4a] opacity-75  mb-2 mt-5  justify-between">
            <div class="flex items-center gap-1 ">
                <p>  توسط:</p>
                <div class="w-8 h-8 rounded-full overflow-hidden">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                  </div>
              <div>
                <p class="font-medium">
                  <?php the_author(); ?></p>
              </div>
            </div>
            <div class="reading-time"><?php
              $words = str_word_count(strip_tags(get_the_content()));
              echo max(1, round($words/200)).' دقیقه خواندن';?>
              </div>
          </div>
        </header>

        <!-- big image on right on large screens: we show image first then content -->
        <?php if (has_post_thumbnail()): ?>
          <div class="w-full mb-6 rounded overflow-hidden">
            <?php the_post_thumbnail('large', ['class'=>'w-full h-auto object-cover rounded-lg']); ?>
          </div>
        <?php endif; ?>

        <div class="prose prose-lg max-w-none text-[#4a4a4a]">
          <?php the_content(); ?>
        </div>
        <!-- tags -->
        <div class="mt-8">
          <?php the_tags('<div class="text-sm text-gray-500 ">تگ‌ها: ',' • ','</div>'); ?>
        </div>

      </div>
    </article>

    <!-- comments -->
    <div class="mt-10">
      <?php
        if (comments_open() || get_comments_number()) {
          comments_template();
        }
      ?>
    </div>
  </div>
</main>



<?php get_footer(); ?>
