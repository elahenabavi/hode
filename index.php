
<?php 
session_start();
$_SESSION["pay"]="no";
get_header();
?>

  <div id="page" class="site">
    <?php
    $terms=get_term([
      'taxonomy'=>'product_category',
      'hide_empty'=>false

    ]);
    
    
    ?>
    <main id="main" class="">

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

  
  
  

