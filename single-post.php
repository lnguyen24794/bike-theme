<?php
/**
 * The template for displaying single bike posts
 *
 * @package Bike_Theme
 */

get_header();

?>

<main id="primary" class="site-main">
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown"><?php the_title(); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page"><?php esc_html_e('Blog', 'bike-theme'); ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div class="container pb-0">
    <div class="row">
        <div class="col-md-12 wp-editor-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>

    
</main>

<?php
get_footer();
