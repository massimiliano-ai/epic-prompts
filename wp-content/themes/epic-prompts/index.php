<?php get_header(); ?>

<div class="container" style="padding: 3rem 0;">
    <div class="homepage-hero" style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 1rem;">
            Discover Amazing <span style="color: #6366F1;">AI Prompts</span>
        </h1>
        <p style="font-size: 1.25rem; color: #6B7280; margin-bottom: 2rem;">
            Share, discover, and get rewarded for the best AI prompts. Join the gamified community!
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="<?php echo esc_url(home_url('/prompts')); ?>" class="btn btn-primary">Browse Prompts</a>
            <a href="<?php echo esc_url(home_url('/submit')); ?>" class="btn btn-secondary">Submit Your Prompt</a>
        </div>
    </div>

    <div class="featured-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="stat-card" style="background: white; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="font-size: 2.5rem; font-weight: 700; color: #6366F1;">
                <?php echo wp_count_posts('ai_prompt')->publish; ?>
            </div>
            <div style="color: #6B7280; margin-top: 0.5rem;">Prompts Shared</div>
        </div>
        <div class="stat-card" style="background: white; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="font-size: 2.5rem; font-weight: 700; color: #EC4899;">
                <?php echo count_users()['total_users']; ?>
            </div>
            <div style="color: #6B7280; margin-top: 0.5rem;">Community Members</div>
        </div>
        <div class="stat-card" style="background: white; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="font-size: 2.5rem; font-weight: 700; color: #10B981;">
                <?php echo wp_count_posts('prompt_vote')->publish; ?>
            </div>
            <div style="color: #6B7280; margin-top: 0.5rem;">Votes Cast</div>
        </div>
    </div>

    <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem;">🔥 Trending Prompts</h2>

    <?php
    // Get trending prompts (high reactions in last 7 days)
    $trending_prompts = new WP_Query(array(
        'post_type' => 'ai_prompt',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ));

    if ($trending_prompts->have_posts()) :
    ?>
        <div class="prompts-grid">
            <?php while ($trending_prompts->have_posts()) : $trending_prompts->the_post(); ?>
                <?php get_template_part('template-parts/prompt-card'); ?>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p>No prompts yet. Be the first to submit one!</p>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 3rem;">
        <a href="<?php echo esc_url(home_url('/prompts')); ?>" class="btn btn-outline">View All Prompts</a>
    </div>
</div>

<?php get_footer(); ?>
