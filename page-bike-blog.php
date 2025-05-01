<?php
/**
 * Template Name: Blog Page
 *
 * @package Bike_Theme
 */

get_header();
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main id="primary" class="site-main">
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php echo esc_url($featured_image); ?>);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php the_title(); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="container-xxl pb-0">
            <div class="row">
                <div class="col-md-12">
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="py-0">
                <?php 
                    $posts = get_posts(array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ));
                    foreach ($posts as $post) {
                        setup_postdata($post);
                ?>
                <div class="w-50 mx-auto">
                    <div class="card shadow rounded">
                        <a class="text-dark" href="<?php the_permalink(); ?>">
                        <div class="card-body row justify-content-between">
                            <div class="card-image col-md-4">
                                <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                            </div>
                            <div class="card-content col-md-8">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                            </div>
                        </div>
                        </a>
                    </div>
                <?php
                    }
                ?>
                <!-- Pagination -->
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <?php
                                $big = 12; // Need an unlikely integer
                                $count_posts = wp_count_posts();
                                 echo paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $count_posts->publish,
                                'prev_text' => '<i class="fa fa-angle-left"></i>',
                                'next_text' => '<i class="fa fa-angle-right"></i>',
                                'type' => 'list',
                                'end_size' => 3,
                                'mid_size' => 3
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
?> 