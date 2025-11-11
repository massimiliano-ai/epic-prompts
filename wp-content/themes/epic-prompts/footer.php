</main>

<footer class="site-footer" style="background-color: #111827; color: #9CA3AF; padding: 3rem 0; margin-top: 4rem;">
    <div class="container">
        <div class="footer-content" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="footer-section">
                <h3 style="color: #6366F1; margin-bottom: 1rem;">Epic<span style="color: #EC4899;">Prompts</span></h3>
                <p>The gamified platform for sharing and discovering AI prompts.</p>
            </div>

            <div class="footer-section">
                <h4 style="color: #F9FAFB; margin-bottom: 1rem;">Quick Links</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                    'fallback_cb' => false,
                ));
                ?>
                <?php if (!has_nav_menu('footer')) : ?>
                <ul style="list-style: none;">
                    <li><a href="<?php echo esc_url(home_url('/prompts')); ?>" style="color: #9CA3AF;">Browse Prompts</a></li>
                    <li><a href="<?php echo esc_url(home_url('/submit')); ?>" style="color: #9CA3AF;">Submit Prompt</a></li>
                    <li><a href="<?php echo esc_url(home_url('/leaderboard')); ?>" style="color: #9CA3AF;">Leaderboard</a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>" style="color: #9CA3AF;">About</a></li>
                </ul>
                <?php endif; ?>
            </div>

            <div class="footer-section">
                <h4 style="color: #F9FAFB; margin-bottom: 1rem;">Legal</h4>
                <ul style="list-style: none;">
                    <li><a href="<?php echo esc_url(home_url('/privacy')); ?>" style="color: #9CA3AF;">Privacy Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms')); ?>" style="color: #9CA3AF;">Terms of Service</a></li>
                    <li><a href="<?php echo esc_url(home_url('/guidelines')); ?>" style="color: #9CA3AF;">Community Guidelines</a></li>
                </ul>
            </div>

            <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="footer-section">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="footer-bottom" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #374151; text-align: center;">
            <p>&copy; <?php echo date('Y'); ?> Epic Prompts. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
