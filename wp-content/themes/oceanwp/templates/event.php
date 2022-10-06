<?php
/* Template Name: Event */

get_header(); 
$uploadsDir = wp_upload_dir()['baseurl'] . "/";
?>

<div class="event">
    <div class="wrapper">
        <header class="hero">
            <img src="<?php echo $uploadsDir . "header.png"; ?>" alt="s4yt" class="hero-img">
        </header>
        <!-- QUESTIONS -->
        <section class="question-section">
            <!-- What is $4YT about? -->
            <article class="question cog_right">
                <div class="initial" id="answer1">
                    <h2 class="question-title">What is $4YT about?</h2>
                    <ul class="answer-points">
                        <li class="answer_point" data-id="1">It’s for High School Students from all around the world to:</li>
                        <li class="answer_point hidden" data-id="1">explore fun questions posed by businesses to win $$$</li>
                        <li class="answer_point hidden" data-id="1">earn Dubl-U-nes to win prizes</li>
                        <li class="answer_point hidden" data-id="1">sign-up for post event meet-ups to learn more about businesses</li>
                        <li class="answer_point hidden" data-id="1">Join our <span class="bubble-discord"><img src="<?php echo $uploadsDir . "Discord.png"; ?>" alt="discord"></span> to learn more and stay updated!</li>
                    </ul>
                </div>
                <button class="learn_more learn_more_left dog bubble_right" data-bubble-position="right" data-id="1">
                    <span id="button_text_1">learn more</span>       
                    <div class="learn_more_wave_right feather_left"></div>
                </button>
            </article>
            <!-- Am I eligible? -->
            <article class="question instagram_right">
                <div class="initial" id="answer2">
                    <h2 class="question-title">Am I eligible?</h2>
                    <ul class="answer-points">
                        <li class="answer_point"  data-id="2">High school students (9-12) from ANYWHERE can attend for FREE!</li>
                        <li class="answer_point hidden" data-id="2">Yes, if you are in grades 9-12 at the time of the contest!</li>
                        <li class="answer_point hidden" data-id="2">Students Register for FREE and are assigned an ID# to play</li>
                        <li class="answer_point hidden" data-id="2">Join our <span class="bubble-discord"><img src="<?php echo $uploadsDir . "Discord.png"; ?>" alt="discord"></span> to learn more and stay updated!</li>
                    </ul>
                </div>
                <button class="learn_more learn_more_right beaver bubble_left" data-bubble-position="left" data-id="2">
                    <span id="button_text_2">learn more</span>       
                    <div class="learn_more_wave_left feather_right"></div>
                </button>
            </article>
            <!-- When can I attend? -->
            <article class="question island_left">
                <div class="initial" id="answer3">
                    <h2 class="question-title">When can I attend?</h2>
                    <ul class="answer-points">
                        <li class="answer_point"  data-id="3">The event takes place in Febraury 2023 but registration starts in 
September 2022!</li>
                        <li class="answer_point hidden" data-id="3">It starts on Fri, Feb 3rd at midnight and goes till Sun, Nov 
5th</li>
                        <li class="answer_point hidden" data-id="3">Students can drop in and out at any time over the 48 hour event period</li>
                        <li class="answer_point hidden" data-id="3">Join our <span class="bubble-discord"><img src="<?php echo $uploadsDir . "Discord.png"; ?>" alt="discord"></span> to learn more and stay updated!</li>
                    </ul>
                </div>
                <button class="learn_more learn_more_left peacock bubble_right" data-bubble-position="right" data-id="3">
                    <span id="button_text_3">learn more</span>       
                    <div class="learn_more_wave_right feather_left"></div>
                </button>
            </article>
            <!-- How Do I Win $$? -->
            <article class="question whale_right">
                <div class="initial" id="answer4">
                    <h2 class="question-title">How Do I Win $$?</h2>
                    <ul class="answer-points">
                        <li class="answer_point"  data-id="4">All Students identity info and submissions remain anonymous until prizes are determined</li>
                        <li class="answer_point hidden" data-id="4">Students may submit 1 (and only 1) answer to each business question, but may win multiple $$$ awards</li>
                        <li class="answer_point hidden" data-id="4">All Student identity info and submissions remain anonymous until prizes are awarded</li>
                        <li class="answer_point hidden" data-id="4">Students have 4 years to use $$(FUN-ding) on anything specific that will help foster success in the future</li>
                        <li class="answer_point hidden" data-id="4">Join our <span class="bubble-discord"><img src="<?php echo $uploadsDir . "Discord.png"; ?>" alt="discord"></span> to learn more and stay updated!</li>
                    </ul>
                </div>
                <button class="learn_more learn_more_right hippo bubble_left" data-bubble-position="left" data-id="4">
                    <span id="button_text_4">learn more</span>
                    <div class="learn_more_wave_left feather_right"></div>
                </button>
            </article>
            <!-- What are Dubl-U-nes? -->
            <article class="question ship_left">
                <div class="initial" id="answer5">
                    <h2 class="question-title">What are Dubl-U-nes?</h2>
                    <ul class="answer-points">
                        <li class="answer_point"  data-id="5">Dubl-U-nes can be used as tickets to enter raffle prizes!</li>
                        <li class="answer_point hidden"  data-id="5">Dubl-U-nes can be used to win prizes donated by our Raffle Partners</li>
                        <li class="answer_point hidden" data-id="5">All registered students receive 3 free Dubl-U-nes</li>
                        <li class="answer_point hidden" data-id="5">Students assign their Dubl-U-nes to selected raffle items over the course of the event</li>
                        <li class="answer_point hidden" data-id="5">Students can earn more Dubl-U-nes (once they register for the game) through a variety of social media interactions</li>
                        <li class="answer_point hidden" data-id="5">Join our <span class="bubble-discord"><img src="<?php echo $uploadsDir . "Discord.png"; ?>" alt="discord"></span> to learn more about earning Dubl-U-nes!</li>
                    </ul>
                </div>
                <button class="learn_more learn_more_left goat bubble_right" data-bubble-position="right" data-id="5">
                    <span id="button_text_5">learn more</span>
                    <div class="learn_more_wave_right feather_left"></div>
                </button>
            </article>
        </section>
        <!-- PARTNERS -->
        <section class="partners-section">
            <div class="partners-banner">
                <img src="<?php echo $uploadsDir . "bird_banner_fill.png"; ?>" alt="partners_banner">
                <p class="banner-text">Our partners</p>
            </div>
            <div class="partners-slider">
                <ul class="partners-list">
                    <li class="partner">
                        <img class="partner-logo" src="http://building-u.com/wp-content/uploads/KnowledgeFlow.png" alt="test">
                    </li>
                </ul>
            </div>
        </section>
        <!-- CTA -->
        <section class="cta-section">
            <button class="register-button">
              <a href="https://s4yt.building-u.com/register" target="_blank">
                <div class="inner-button">
                    <span class="btn-font">Register<br/>Now</span>
                </div>
              </a>
            </button>
            <div class="discord">
                <p>Join Our Discord!</p>
                <a href="https://discord.gg/rCSCTxDQhU" target="_blank">
                    <img src="<?php echo $uploadsDir . "Discord.png"; ?>" alt="discord">
                </a>
            </div>
        </section>
    </div>
</div>

<script>
    jQuery(document).ready(function($){
        // Learn more buttons
        $('.learn_more').on('click', function(){
            const bubblePosition = $(this).data('bubble-position');
            const id = $(this).data('id');
            const answer = $('#answer' + id);
            answer.toggleClass('bubble');
            answer.toggleClass( bubblePosition === 'right' ? 'bubble-bottom-right' : 'bubble-bottom-left')

            $('.answer_point').each(function(){
                if($(this).data('id') === id) {
                    $(this).toggleClass('hidden');
                }                    
            });
            // Toggle text
            const buttonText = $('#button_text_' + id).text();
            $('#button_text_' + id).text( buttonText === "learn more" ? "Ok!" : "learn more");
        });
    });
</script>

<?php get_footer(); ?>
