<?php
/**
 * Template Name: Submit Prompt
 */

// Redirect if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

get_header();
?>

<div class="container" style="padding: 3rem 0;">
    <div class="submit-header" style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">
            Submit Your Prompt
        </h1>
        <p style="color: #6B7280; font-size: 1.125rem;">
            Share your best AI prompts and earn XP! 🚀
        </p>
    </div>

    <div class="submit-form-container" style="max-width: 800px; margin: 0 auto;">
        <form id="submit-prompt-form" class="prompt-submit-form" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="prompt-title" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Prompt Title <span style="color: #EF4444;">*</span>
                </label>
                <input
                    type="text"
                    id="prompt-title"
                    name="title"
                    required
                    class="search-input"
                    placeholder="e.g., Stunning Cyberpunk Character Design"
                    style="width: 100%;"
                >
                <small style="color: #6B7280; font-size: 0.875rem;">
                    Make it descriptive and engaging
                </small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="prompt-text" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Prompt Text <span style="color: #EF4444;">*</span>
                </label>
                <textarea
                    id="prompt-text"
                    name="prompt_text"
                    required
                    rows="6"
                    class="search-input"
                    placeholder="Enter your AI prompt here..."
                    style="width: 100%; resize: vertical;"
                    data-maxlength="2000"
                ></textarea>
                <small style="color: #6B7280; font-size: 0.875rem;">
                    The actual prompt you use in your AI tool
                </small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="platform" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                        AI Platform <span style="color: #EF4444;">*</span>
                    </label>
                    <select id="platform" name="platform" required class="search-input" style="width: 100%;">
                        <option value="">Select platform...</option>
                        <?php
                        $platforms = get_terms(array(
                            'taxonomy' => 'ai_platform',
                            'hide_empty' => false,
                        ));
                        foreach ($platforms as $platform) {
                            echo '<option value="' . esc_attr($platform->term_id) . '">' . esc_html($platform->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                        Category <span style="color: #EF4444;">*</span>
                    </label>
                    <select id="category" name="category" required class="search-input" style="width: 100%;">
                        <option value="">Select category...</option>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'prompt_category',
                            'hide_empty' => false,
                        ));
                        foreach ($categories as $category) {
                            echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="tags" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Tags (optional)
                </label>
                <input
                    type="text"
                    id="tags"
                    name="tags"
                    class="search-input"
                    placeholder="e.g., cyberpunk, neon, character"
                    style="width: 100%;"
                >
                <small style="color: #6B7280; font-size: 0.875rem;">
                    Separate tags with commas
                </small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="result-image" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Result Image <span style="color: #EF4444;">*</span>
                </label>
                <div id="image-upload-area" style="border: 2px dashed #D1D5DB; border-radius: 0.5rem; padding: 2rem; text-align: center; cursor: pointer; transition: all 0.2s;">
                    <input
                        type="file"
                        id="result-image"
                        name="result_image"
                        accept="image/jpeg,image/png,image/webp"
                        style="display: none;"
                        required
                    >
                    <div id="upload-placeholder">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📸</div>
                        <p style="font-weight: 600; margin-bottom: 0.25rem;">Click to upload result image</p>
                        <small style="color: #6B7280;">JPG, PNG or WebP (max 5MB)</small>
                    </div>
                    <div id="image-preview" style="display: none;">
                        <img id="preview-img" src="" alt="Preview" style="max-width: 100%; max-height: 400px; border-radius: 0.5rem;">
                        <button type="button" id="remove-image" class="btn btn-outline" style="margin-top: 1rem;">
                            Change Image
                        </button>
                    </div>
                </div>
                <input type="hidden" id="result-image-id" name="result_image_id">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Description (optional)
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    class="search-input"
                    placeholder="Add any additional context, tips, or variations..."
                    style="width: 100%; resize: vertical;"
                ></textarea>
            </div>

            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn btn-outline" onclick="window.history.back();">
                    Cancel
                </button>
                <button type="submit" id="submit-btn" class="btn btn-primary">
                    Submit Prompt (+10 XP)
                </button>
            </div>

            <div id="submit-message" style="margin-top: 1.5rem; padding: 1rem; border-radius: 0.5rem; display: none;"></div>
        </form>

        <div class="submission-tips" style="margin-top: 2rem; background: #FEF3C7; padding: 1.5rem; border-radius: 0.75rem; border-left: 4px solid #F59E0B;">
            <h3 style="margin-bottom: 1rem; color: #92400E;">💡 Tips for Great Prompts</h3>
            <ul style="list-style: disc; padding-left: 1.5rem; color: #78350F;">
                <li>Be specific and detailed in your prompt text</li>
                <li>Upload a high-quality result image</li>
                <li>Choose the correct platform and category</li>
                <li>Add relevant tags to help others find your prompt</li>
                <li>Include any important settings or parameters in the description</li>
            </ul>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {

    // Image upload handling
    $('#image-upload-area').on('click', function() {
        $('#result-image').click();
    });

    $('#result-image').on('change', function(e) {
        var file = e.target.files[0];

        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }

            // Validate file type
            if (!file.type.match('image/(jpeg|png|webp)')) {
                alert('Only JPG, PNG, and WebP images are allowed');
                return;
            }

            // Show preview
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#upload-placeholder').hide();
                $('#image-preview').show();
            };
            reader.readAsDataURL(file);

            // Upload image via AJAX (WordPress Media Library)
            var formData = new FormData();
            formData.append('action', 'upload_prompt_image');
            formData.append('nonce', epicPromptsTheme.nonce);
            formData.append('image', file);

            $.ajax({
                url: epicPromptsTheme.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#result-image-id').val(response.data.attachment_id);
                    }
                }
            });
        }
    });

    $('#remove-image').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#result-image').val('');
        $('#result-image-id').val('');
        $('#upload-placeholder').show();
        $('#image-preview').hide();
    });

    // Form submission
    $('#submit-prompt-form').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $submitBtn = $('#submit-btn');
        var $message = $('#submit-message');

        // Validate
        if (!$('#result-image-id').val()) {
            $message.css('background', '#FEE2E2').css('color', '#991B1B').text('Please upload a result image').show();
            return;
        }

        // Prepare data
        var formData = {
            action: 'submit_prompt',
            nonce: epicPromptsTheme.nonce,
            title: $('#prompt-title').val(),
            prompt_text: $('#prompt-text').val(),
            platform: $('#platform').val(),
            category: $('#category').val(),
            tags: $('#tags').val(),
            description: $('#description').val(),
            result_image_id: $('#result-image-id').val()
        };

        // Submit
        $.ajax({
            url: epicPromptsTheme.ajaxurl,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Submitting...');
                $message.hide();
            },
            success: function(response) {
                if (response.success) {
                    $message.css('background', '#D1FAE5').css('color', '#065F46').text(response.data.message).show();

                    // Confetti!
                    if (typeof confetti !== 'undefined') {
                        confetti({
                            particleCount: 150,
                            spread: 80,
                            origin: { y: 0.6 }
                        });
                    }

                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = response.data.redirect;
                    }, 2000);
                } else {
                    $message.css('background', '#FEE2E2').css('color', '#991B1B').text(response.data.message || 'Error submitting prompt').show();
                    $submitBtn.prop('disabled', false).text('Submit Prompt (+10 XP)');
                }
            },
            error: function() {
                $message.css('background', '#FEE2E2').css('color', '#991B1B').text('Network error. Please try again.').show();
                $submitBtn.prop('disabled', false).text('Submit Prompt (+10 XP)');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
