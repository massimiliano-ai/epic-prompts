/**
 * Epic Prompts Core - Main JavaScript
 * Handles reactions, voting, and interactive features
 */

(function($) {
    'use strict';

    // Wait for DOM ready
    $(document).ready(function() {

        // Add Reaction Handler
        $('.reaction-btn').on('click', function(e) {
            e.preventDefault();

            if (!epicPromptsAjax.is_logged_in) {
                alert('Please login to react to prompts');
                return;
            }

            const $btn = $(this);
            const promptId = $btn.data('prompt-id');
            const reactionType = $btn.data('reaction-type');

            $.ajax({
                url: epicPromptsAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'add_reaction',
                    nonce: epicPromptsAjax.nonce,
                    prompt_id: promptId,
                    reaction_type: reactionType
                },
                beforeSend: function() {
                    $btn.prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        // Update reaction count
                        const $count = $btn.find('.reaction-count');
                        $count.text(response.data.count);

                        // Add active class
                        $btn.addClass('active');

                        // Show success animation
                        $btn.addClass('reaction-success');
                        setTimeout(function() {
                            $btn.removeClass('reaction-success');
                        }, 600);

                        // Show toast notification
                        showToast('Reaction added! +1 XP', 'success');
                    } else {
                        showToast(response.data.message || 'Error adding reaction', 'error');
                    }
                },
                error: function() {
                    showToast('Connection error. Please try again.', 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });

        // Copy Prompt to Clipboard
        $('.copy-prompt-btn').on('click', function(e) {
            e.preventDefault();
            const promptText = $(this).data('prompt-text');

            // Use Clipboard API if available
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(promptText).then(function() {
                    showToast('Prompt copied to clipboard!', 'success');
                }).catch(function() {
                    fallbackCopyToClipboard(promptText);
                });
            } else {
                fallbackCopyToClipboard(promptText);
            }
        });

        // Fallback copy function for older browsers
        function fallbackCopyToClipboard(text) {
            const $temp = $('<textarea>');
            $('body').append($temp);
            $temp.val(text).select();
            try {
                document.execCommand('copy');
                showToast('Prompt copied to clipboard!', 'success');
            } catch (err) {
                showToast('Failed to copy. Please copy manually.', 'error');
            }
            $temp.remove();
        }

        // Toast Notification System
        function showToast(message, type) {
            const toastClass = type === 'success' ? 'success' : type === 'error' ? 'error' : 'info';
            const $toast = $('<div class="toast-notification ' + toastClass + '">')
                .html(message)
                .appendTo('body');

            setTimeout(function() {
                $toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Smooth scroll to anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });

        // Image lazy loading
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy-image');
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img.lazy-image').forEach(function(img) {
                imageObserver.observe(img);
            });
        }

        // Infinite scroll for prompt archives (if enabled)
        let isLoading = false;
        let page = 1;

        $(window).on('scroll', function() {
            if (isLoading || !$('.prompts-grid').length) return;

            const scrollPosition = $(window).scrollTop() + $(window).height();
            const documentHeight = $(document).height();

            if (scrollPosition > documentHeight - 500) {
                loadMorePrompts();
            }
        });

        function loadMorePrompts() {
            isLoading = true;
            page++;

            // Show loading indicator
            const $loading = $('<div class="loading-more" style="text-align: center; padding: 2rem;">')
                .html('<div class="loading"></div> Loading more prompts...')
                .appendTo('.prompts-grid');

            // Note: This needs to be implemented based on your specific needs
            // For now, it's just a placeholder
            setTimeout(function() {
                $loading.remove();
                isLoading = false;
            }, 1000);
        }

        // Mobile menu toggle (if you add a mobile menu)
        $('.mobile-menu-toggle').on('click', function() {
            $('.mobile-menu').toggleClass('open');
            $(this).toggleClass('open');
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mobile-menu, .mobile-menu-toggle').length) {
                $('.mobile-menu').removeClass('open');
                $('.mobile-menu-toggle').removeClass('open');
            }
        });

        // Auto-hide header on scroll down, show on scroll up
        let lastScrollTop = 0;
        const $header = $('.site-header');

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                $header.addClass('header-hidden');
            } else {
                // Scrolling up
                $header.removeClass('header-hidden');
            }

            lastScrollTop = scrollTop;
        });

        // Add animation classes when elements come into view
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.prompt-card, .stat-card').forEach(function(el) {
                animationObserver.observe(el);
            });
        }

    });

})(jQuery);
