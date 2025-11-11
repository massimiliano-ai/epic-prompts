# VIBECODING PROMPT: Prompts Exchanger MVP

## Project Overview
Build "Prompts Exchanger" - a gamified WordPress platform for sharing and discovering AI image generation prompts (Midjourney, DALL-E, Stable Diffusion). Think "GitHub meets Duolingo for AI Prompts" with community voting, XP/levels, badges, and leaderboards.

---

## PHASE 1: Core MVP Features

### 1. Custom Post Types & Taxonomies

Create the following WordPress structures:

**Custom Post Type: 'ai_prompt'**
```
- Supports: title, editor, thumbnail, author, comments
- Labels: "Prompts" (plural), "Prompt" (singular)
- Public: true
- Has archive: true
- Menu icon: dashicons-lightbulb

Custom Fields (using ACF or CMB2):
- prompt_text (textarea) - The actual prompt text
- result_image (image upload) - Example result image
- views_count (number, default 0)
- saves_count (number, default 0)
- verified_count (number, default 0)
- rating_avg (number, default 0, decimal)
- reactions (serialized array) - {fire: 0, gem: 0, creative: 0, rocket: 0, mindblown: 0}
```

**Taxonomy: 'ai_platform'**
```
- Hierarchical: false (like tags)
- Default terms:
  - Midjourney v5
  - Midjourney v6
  - DALL-E 2
  - DALL-E 3
  - Stable Diffusion XL
  - Leonardo.ai
```

**Taxonomy: 'prompt_category'**
```
- Hierarchical: true (like categories)
- Default terms:
  - Character Design
  - Landscapes
  - Product Photography
  - Logo & Branding
  - Fantasy Art
  - Portraits
  - Architecture
  - Abstract Art
```

### 2. User Profile Extensions

Extend WordPress user meta with these fields:

```php
User Meta Fields:
- xp_total (int, default 0)
- level (int, default 1)
- reputation (int, default 0)
- coins (int, default 0)
- voting_power (float, default 1.0)
- streak_days (int, default 0)
- last_active_date (date)
- prompts_submitted (int, default 0)
- votes_cast (int, default 0)
```

### 3. Frontend Submission Form

Create a frontend form for users to submit prompts:

**Location:** Page template or shortcode [submit_prompt]

**Form Fields:**
- Prompt Title (required)
- Prompt Text (required, textarea)
- AI Platform (required, dropdown from taxonomy)
- Category (required, dropdown from taxonomy)
- Tags (optional, comma-separated)
- Result Image (required, image upload)
- Description (optional, WYSIWYG editor)

**Validation:**
- All required fields must be filled
- Image max size: 5MB
- Accepted formats: JPG, PNG, WebP

**On Submit:**
1. Create new 'ai_prompt' post with status 'pending'
2. Assign taxonomies
3. Upload image to media library
4. Award submitter +10 XP
5. Increment user's 'prompts_submitted' counter
6. Redirect to "Thank you" page with message

### 4. Browse/Grid View

Create a page template showing all prompts in a responsive grid:

**Layout:**
- Masonry/Grid layout (3 columns desktop, 2 tablet, 1 mobile)
- Each card shows:
  - Result image (featured image)
  - Prompt title
  - Author avatar + username
  - AI platform badge
  - Rating (⭐ 4.8/5)
  - Reactions count (🔥 89)
  - Views count (👁️ 1.2k)
  - "✓ Verified" badge if verified_count > 5

**Filters (AJAX):**
- By AI Platform (checkboxes)
- By Category (checkboxes)
- Sort by: Newest, Top Rated, Most Views, Most Verified

**Search:**
- Search bar at top
- Search in title and prompt_text

**Pagination:**
- Load More button (AJAX)
- 12 prompts per page

### 5. Single Prompt Page

Template for viewing individual prompt:

**Layout Sections:**

**Hero Section:**
- Large result image (lightbox on click)
- Prompt title (H1)
- Author info: Avatar, username, level badge
- Timestamp (posted X days ago)
- Stats row: ⭐ rating (X reviews) | 🔥 reactions | 👁️ views | 🔖 saves

**Prompt Details:**
- AI Platform badge
- Category badge
- Tags (clickable to filter)

**The Prompt:**
- Prompt text in styled box
- [Copy Prompt] button (copies to clipboard, shows "Copied!" feedback)
- [Save] button (bookmark for later)
- [Share] button (social share menu)

**Reactions Section:**
- 5 emoji buttons: 🔥 Fire | 💎 Gem | 🎨 Creative | 🚀 Rocket | 💡 Mindblown
- Click to react (only 1 reaction per user)
- Show count for each reaction type
- Highlight user's reaction if already voted

**Rating Section (for logged-in users):**
- "Rate this prompt" heading
- Quick vote buttons: 😍 (5★) | 😊 (4★) | 😐 (3★) | 😕 (2★) | 😞 (1★)
- OR
- [Leave Detailed Review] button → opens modal

**Verification Section:**
- "✓ Verified by X users" if verified_count > 0
- [Test & Verify] button
- Opens modal to upload user's own result image
- On submit: increment verified_count, award +10 XP to verifier

**Comments:**
- Standard WordPress comments
- Threaded replies
- Author badge for prompt creator

### 6. Voting System (Reactions)

**AJAX Implementation:**

When user clicks reaction button (🔥, 💎, 🎨, 🚀, 💡):

**Frontend (JavaScript):**
```javascript
// On emoji click:
1. Check if user is logged in (PHP localized var)
2. If not logged in: redirect to login
3. If logged in: AJAX call to custom endpoint

jQuery.post(ajaxurl, {
    action: 'add_reaction',
    prompt_id: <?php echo $post_id; ?>,
    reaction_type: 'fire', // or gem, creative, etc
    nonce: '<?php echo wp_create_nonce('reaction_nonce'); ?>'
}, function(response) {
    if(response.success) {
        // Update count display
        // Show animation (confetti or +5 XP notification)
        // Update user XP in header
    }
});
```

**Backend (PHP wp-ajax hook):**
```php
function handle_add_reaction() {
    // Verify nonce
    // Check if user already reacted to this prompt
    // If yes: remove old reaction, add new one
    // If no: add new reaction
    
    // Update post meta 'reactions' array
    // Award +2 XP to voter
    // Award +5 XP to prompt creator
    
    // Return JSON response
}
add_action('wp_ajax_add_reaction', 'handle_add_reaction');
```

**Database Storage:**
- Reactions stored in post_meta as serialized array
- Format: array('fire' => 45, 'gem' => 23, 'creative' => 67, ...)

### 7. Basic XP System

**XP Awards:**
- Submit prompt: +10 XP
- Vote/React: +2 XP
- Comment on prompt: +5 XP
- Someone reacts to your prompt: +5 XP
- Daily login: +5 XP (check last_active_date)

**Level Calculation:**
```php
function calculate_user_level($xp_total) {
    // Simple formula: Level = floor(XP / 100) + 1
    // Level 1: 0-99 XP
    // Level 2: 100-199 XP
    // Level 3: 200-299 XP
    // etc.
    
    return floor($xp_total / 100) + 1;
}
```

**Display:**
- Show XP and Level in user profile
- Show Level badge next to username everywhere
- Header widget showing current user: "Level 5 | 450 XP"

### 8. Simple Leaderboard

Create a page showing top contributors:

**Query Top 20 Users by XP:**
```php
$args = array(
    'number' => 20,
    'meta_key' => 'xp_total',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
);
$top_users = get_users($args);
```

**Display:**
```
┌────────────────────────────────────┐
│  🏆 TOP PROMPTERS                  │
├────────────────────────────────────┤
│  #1  @alexAI        Lv 18  1,850 XP│
│  #2  @maria_d       Lv 15  1,520 XP│
│  #3  @prompt_king   Lv 14  1,405 XP│
│  ...                                │
└────────────────────────────────────┘
```

### 9. User Profile Page

Template showing user's activity:

**Sections:**
- Avatar, username, bio
- Level + XP progress bar
- Stats: X prompts submitted | Y votes cast | Z followers
- Badge showcase (placeholder for now, just show level)

**Tabs:**
- "Prompts" - Grid of user's submitted prompts
- "Saved" - Prompts user bookmarked
- "Activity" - Recent actions (placeholder)

### 10. Authentication & Registration

**Registration:**
- Standard WordPress registration
- Add custom fields during registration
- Initialize: xp_total = 0, level = 1, coins = 50 (welcome bonus)
- Send welcome email

**Login:**
- Standard WordPress login
- Redirect to dashboard after login
- Update last_active_date on login

**Social Login (Optional for MVP):**
- Google OAuth (use Nextend Social Login plugin)

---

## DESIGN GUIDELINES

### Color Palette
```
Primary: #6366F1 (Indigo)
Secondary: #EC4899 (Pink)
Accent: #10B981 (Green)
Background: #F9FAFB (Light gray)
Text: #111827 (Dark gray)
```

### Typography
- Headings: Inter or Poppins (Google Fonts)
- Body: System fonts stack for performance

### UI Components Needed
- Buttons: Primary (filled), Secondary (outline), Icon buttons
- Cards: Prompt cards with hover effects
- Badges: Platform badges, Category badges, Level badges
- Modals: For detailed review, verification upload
- Toast notifications: For XP awards, success messages

### Animations
- Hover effects on cards (subtle scale up)
- Confetti animation on level up (use canvas-confetti library)
- Smooth transitions (CSS transitions 0.2s ease)

---

## TECHNICAL REQUIREMENTS

### WordPress Version
- 6.0+ required

### PHP Version
- 7.4+ (8.0+ recommended)

### Required Plugins
1. **Advanced Custom Fields (ACF)** - For custom fields
2. **WP User Avatar** - Custom avatars
3. **Ajax Load More** - Infinite scroll
4. **Wordfence** - Security

### Optional Plugins (MVP can work without)
- GamiPress (if we want ready gamification, but may be overkill)
- BuddyPress (if we want advanced profiles, defer to Phase 2)

### JavaScript Libraries
- jQuery (included in WordPress)
- canvas-confetti (for level up animation)
- clipboard.js (for copy prompt button)

### Performance
- Optimize images with Imagify or ShortPixel
- Enable WordPress caching (W3 Total Cache or WP Rocket)
- Use CDN (Cloudflare free tier)
- Lazy load images

---

## DATABASE STRUCTURE

### Post Types
```
wp_posts
- ai_prompt posts (custom post type)

wp_postmeta
- prompt_text
- result_image
- views_count
- saves_count
- verified_count
- rating_avg
- reactions
```

### Taxonomies
```
wp_terms / wp_term_taxonomy
- ai_platform terms
- prompt_category terms
- post_tag (for prompt_tag)
```

### User Meta
```
wp_usermeta
- xp_total
- level
- reputation
- coins
- voting_power
- streak_days
- last_active_date
- prompts_submitted
- votes_cast
```

### Custom Tables (Future, not MVP)
```
wp_prompt_votes (for detailed reviews)
wp_prompt_verifications (for verification uploads)
wp_leaderboards (for cached leaderboard data)
```

For MVP, we can use post_meta and user_meta. Optimize later if performance issues.

---

## SECURITY CONSIDERATIONS

1. **Nonce Verification:** All AJAX requests must verify nonce
2. **Capability Checks:** Check user capabilities before actions
3. **Input Sanitization:** Sanitize all user inputs
4. **File Upload Security:** 
   - Validate file types (only jpg, png, webp)
   - Check file size limits
   - Rename uploaded files
5. **SQL Injection Prevention:** Use $wpdb->prepare() for custom queries
6. **XSS Prevention:** Escape output with esc_html(), esc_url(), etc

---

## MVP PRIORITIES (In Order)

**Week 1-2 (Foundation):**
1. ✅ Setup WordPress + theme
2. ✅ Custom Post Type + Taxonomies
3. ✅ User meta extensions
4. ✅ Basic ACF fields

**Week 3 (Core Features):**
5. ✅ Frontend submission form
6. ✅ Browse/grid page
7. ✅ Single prompt page
8. ✅ Basic XP system

**Week 4 (Engagement):**
9. ✅ Reaction system (AJAX)
10. ✅ Leaderboard
11. ✅ User profile page
12. ✅ Registration/Login polish

**Post-MVP (Week 5+):**
- Badge system
- Detailed rating (5 criteria)
- Verification system
- Collections
- Following
- Notifications

---

## SAMPLE CODE SNIPPETS

### Register Custom Post Type
```php
function register_ai_prompt_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Prompts',
            'singular_name' => 'Prompt'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments'),
        'menu_icon' => 'dashicons-lightbulb',
        'rewrite' => array('slug' => 'prompts'),
        'show_in_rest' => true // for Gutenberg
    );
    register_post_type('ai_prompt', $args);
}
add_action('init', 'register_ai_prompt_cpt');
```

### Award XP Function
```php
function award_xp($user_id, $xp_amount, $reason = '') {
    // Get current XP
    $current_xp = get_user_meta($user_id, 'xp_total', true);
    if(empty($current_xp)) $current_xp = 0;
    
    // Add XP
    $new_xp = $current_xp + $xp_amount;
    update_user_meta($user_id, 'xp_total', $new_xp);
    
    // Calculate new level
    $old_level = calculate_user_level($current_xp);
    $new_level = calculate_user_level($new_xp);
    update_user_meta($user_id, 'level', $new_level);
    
    // Check if leveled up
    if($new_level > $old_level) {
        // Trigger level up notification
        do_action('user_level_up', $user_id, $new_level);
    }
    
    return $new_xp;
}
```

### AJAX Reaction Handler
```php
function handle_add_reaction() {
    // Security check
    check_ajax_referer('reaction_nonce', 'nonce');
    
    // Get data
    $prompt_id = intval($_POST['prompt_id']);
    $reaction_type = sanitize_text_field($_POST['reaction_type']);
    $user_id = get_current_user_id();
    
    if(!$user_id) {
        wp_send_json_error('Not logged in');
    }
    
    // Valid reaction types
    $valid_reactions = array('fire', 'gem', 'creative', 'rocket', 'mindblown');
    if(!in_array($reaction_type, $valid_reactions)) {
        wp_send_json_error('Invalid reaction');
    }
    
    // Get current reactions
    $reactions = get_post_meta($prompt_id, 'reactions', true);
    if(empty($reactions)) {
        $reactions = array(
            'fire' => 0,
            'gem' => 0,
            'creative' => 0,
            'rocket' => 0,
            'mindblown' => 0
        );
    }
    
    // Check if user already reacted (store in transient for simplicity in MVP)
    $user_reaction_key = 'user_reaction_' . $user_id . '_' . $prompt_id;
    $previous_reaction = get_transient($user_reaction_key);
    
    if($previous_reaction) {
        // Remove previous reaction
        $reactions[$previous_reaction]--;
    }
    
    // Add new reaction
    $reactions[$reaction_type]++;
    update_post_meta($prompt_id, 'reactions', $reactions);
    
    // Store user's current reaction
    set_transient($user_reaction_key, $reaction_type, YEAR_IN_SECONDS);
    
    // Award XP
    if(!$previous_reaction) {
        // First time reacting to this prompt
        award_xp($user_id, 2, 'Reacted to prompt');
        
        // Award prompt creator
        $prompt_author = get_post_field('post_author', $prompt_id);
        award_xp($prompt_author, 5, 'Received reaction');
    }
    
    // Return success
    wp_send_json_success(array(
        'reactions' => $reactions,
        'xp_awarded' => !$previous_reaction ? 2 : 0
    ));
}
add_action('wp_ajax_add_reaction', 'handle_add_reaction');
```

---

## SUCCESS CRITERIA FOR MVP

MVP is successful when:

✅ User can register and login
✅ User can submit a prompt with image
✅ Prompts display in responsive grid
✅ User can filter and search prompts
✅ Single prompt page shows all details
✅ User can react (🔥💎🎨🚀💡) to prompts
✅ XP is awarded for actions
✅ User level is calculated and displayed
✅ Leaderboard shows top 20 users
✅ User profile shows their prompts
✅ Copy prompt button works
✅ Mobile-responsive design
✅ No major bugs or errors

---

## NOTES FOR VIBECODING

- Focus on FUNCTIONALITY over perfection
- Use WordPress best practices (hooks, filters, sanitization)
- Modular code (functions, not monolithic)
- Comment complex logic
- Error handling (try/catch where appropriate)
- Testing: Test as you build on local environment
- Performance: Don't optimize prematurely, but be mindful
- Accessibility: Use semantic HTML, alt texts on images

---

## FILE STRUCTURE

Recommended theme/plugin structure:

```
wp-content/
├── themes/
│   └── prompts-exchanger/
│       ├── style.css
│       ├── functions.php
│       ├── header.php
│       ├── footer.php
│       ├── index.php
│       ├── single-ai_prompt.php (single prompt template)
│       ├── archive-ai_prompt.php (browse grid)
│       ├── page-submit.php (submission form)
│       ├── page-leaderboard.php
│       ├── author.php (user profile)
│       ├── js/
│       │   └── main.js (AJAX reactions, etc)
│       └── css/
│           └── custom.css
│
└── plugins/
    └── prompts-exchanger-core/
        ├── prompts-exchanger-core.php (main plugin file)
        ├── includes/
        │   ├── post-types.php
        │   ├── taxonomies.php
        │   ├── user-functions.php
        │   ├── xp-system.php
        │   ├── ajax-handlers.php
        │   └── widgets.php
        └── assets/
            ├── js/
            └── css/
```

---

## VIBECODING START PROMPT

**Use this exact prompt to begin coding:**

"Create a WordPress theme called 'Prompts Exchanger' with the following features:

1. Custom Post Type 'ai_prompt' with fields: prompt_text, result_image, views_count, saves_count, verified_count, rating_avg, reactions (array with fire, gem, creative, rocket, mindblown counts)

2. Taxonomies: 'ai_platform' and 'prompt_category' with the terms listed in the spec

3. User meta fields: xp_total, level, reputation, coins, voting_power, streak_days, last_active_date, prompts_submitted, votes_cast

4. Frontend submission form (page template) with validation and AJAX submit that creates pending prompts and awards XP

5. Browse page (archive template) with filterable grid, AJAX load more, showing prompt cards with image, title, author, rating, reactions

6. Single prompt page with: large image, prompt text, copy button, reactions (🔥💎🎨🚀💡), rating display, comments

7. AJAX reaction system that updates counts and awards XP (+2 voter, +5 creator)

8. XP system with award_xp() function that calculates levels (floor(XP/100)+1) and triggers level up notifications

9. Leaderboard page showing top 20 users by XP with rank, username, level, and XP

10. User profile page (author.php) with user info, level, stats, and grid of their prompts

Use modern, clean design with Tailwind-like utility classes. Make it mobile-responsive. Include proper WordPress security (nonces, capability checks, sanitization). Use jQuery for AJAX. Add confetti animation on level up using canvas-confetti library.

Start with the core plugin file that registers post types and taxonomies, then create the theme with all templates."

---

**NOW: START CODING! 🚀**

Copy the VIBECODING START PROMPT above and paste into Vibecoding to begin development.

Remember:
- Code in small, testable chunks
- Test each feature before moving to next
- Use browser console to debug AJAX
- Check error logs for PHP issues
- Mobile test early and often

Good luck! You've got this! 💪
