<div class="section woo-blog">
    <div class="container">
        <div class="row">
            <?php foreach($posts as $post):?>
            <div class="col-lg-<?php echo esc_attr($post_column); ?>">
                <div class="card mb-4 box-shadow">
                    <?php if(has_post_thumbnail($post) ): ?>
                    <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url( $post, 'thumbnail' ); ?>" alt="Card image cap">
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="<?php echo get_the_permalink($post); ?>">
                                <?php echo get_the_title($post); ?>
                            </a>
                        </h4>
                        <p class="card-text">
                            <?php echo get_the_excerpt($post); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>