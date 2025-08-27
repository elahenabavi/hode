



<?php 

get_header();
?>

  <div id="page" class="site">
    <?php
    $terms=get_term([
      'taxonomy'=>'product_category',
      'hide_empty'=>false

    ]);
    
    
    ?><div class="flex justify-center my-3 mt-6">
      <p class="font-semibold text-gray-700 text-xl">ارتباط با ما</p>
      </div>
      <div class="flex justify-center my-3 mb-6">
      <p class="text-sm text-gray-500">درصورت داشتن سوال یا بروز مشکل در سایت از طریق فرم زیر با ما در ارتباط باشید.</p>
      </div>
    <main id="main" class="site-main mx-auto max-w-160 bg-white rounded-xl p-5">

      <?php
      if ( have_posts() ) {
        while ( have_posts() ) {
          the_post();
         /*  the_title( '<h2>', '</h2>' ); */
          the_post_thumbnail();
          the_excerpt(); 
          the_content(); 
        }
      } else {
        echo '<p>No content found.</p>';
      }
      ?>
    
    </main>
  </div>
  
<?php 
get_footer();
?>

  
  
  

