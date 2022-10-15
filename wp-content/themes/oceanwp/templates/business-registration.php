<?php
/* Template Name: BusinessRegistration */

get_header();
$uploadsDir = wp_upload_dir()['baseurl'] . "/";
?>

<div class="wrapper">
    <div class="hero">
        <img src="<?php echo $uploadsDir . 'businessreg-header-goes-w_-business-registration-form.jpg'?>" alt="s4yt" class="hero-img">
    </div>
    <section class="partner-types">
        <div class="left">
            <div class="left-wrapper">
                <div>
                    <h2 class="partners-title">WAYS TO PARTNER WITH US: <br /> SELECT 1, 2, or all 3 <br /> MIX &amp; MATCH</h2>
                </div>
                <ul class="rewards">
                    <li class="reward-category">
                        <span class="category-title"></span>
                        <ul class="category-rewards">
                            <li class="reward">Logo Presence</li>
                        </ul>
                    </li>
                    <li class="reward-category">
                        <span class="category-title">Event Specific Perks:</span>
                        <ul class="category-rewards">
                            <li class="reward">B2B Communication</li>
                            <li class="reward">Student Q&A session</li>
                        </ul>
                    </li>
                    <li class="reward-category">
                        <span class="category-title">Get Featured In:</span>
                        <ul class="category-rewards">
                            <li class="reward">Email Campaigns</li>
                            <li class="reward">Social Media</li>
                        </ul>
                    </li>
                    <li class="reward-category">
                        <span class="category-title">Opportunity for:</span>
                        <ul class="category-rewards">
                            <li class="reward">Team Naming</li>
                            <li class="reward">Project Sponsorship</li>
                        </ul>
                    </li>
                    <li class="rewards-end">
                        Your support
                    </li>
                </ul>
            </div>
        </div>
        <div class="right">
            <table class="partners-table">
                <tbody>
                <tr class="partner-icons">
                    <!-- SPONSORING -->
                    <th class="partner-icon">
                        <div class="icon-toggle">
                            <div class="toggle-holder" id="sponsor-toggle-holder">
                                <input type="checkbox" class="toggle-partner" id="sponsor-toggle">
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                            <img src="<?php echo $uploadsDir . 'purposepeacock.svg'?>" alt="sponsor-partner-icon">
                        </div>
                        <div class="partner-name">
                            <p>sponsoring partners</p>
                        </div>
                    </th>
                    <!-- EVENT -->
                    <th class="partner-icon">
                        <div class="icon-toggle">
                            <div class="toggle-holder" id="event-toggle-holder">
                                <input type="checkbox" class="toggle-partner" id="event-toggle">
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                            <img src="<?php echo $uploadsDir . 'purposebeaver.svg'?>" alt="sponsor-partner-icon">
                        </div>
                        <div class="partner-name">
                            <p>event partners</p>
                        </div>
                    </th>
                    <!-- EVENT -->
                    <th class="partner-icon">
                        <div class="icon-toggle">
                            <div class="toggle-holder" id="raffle-toggle-holder">
                                <input type="checkbox" class="toggle-partner" id="raffle-toggle">
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                            <img src="<?php echo $uploadsDir . 'purposedog.svg'?>" alt="sponsor-partner-icon">
                        </div>
                        <div class="partner-name">
                            <p>raffle partners</p>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell event-check"></td>
                    <td class="partner-cell raffle-check"></td>
                </tr>
                <tr class="has-title">
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell event-check"></td>
                    <td class="partner-cell raffle-check"></td>
                </tr>
                <tr>
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell event-check"></td>
                    <td class="partner-cell"></td>
                </tr>
                <tr class="has-title">
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell event-check"></td>
                    <td class="partner-cell"></td>
                </tr>
                <tr>
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell event-check"></td>
                    <td class="partner-cell"></td>
                </tr>
                <tr class="has-title">
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell"></td>
                    <td class="partner-cell"></td>
                </tr>
                <tr>
                    <td class="partner-cell sponsor-check"></td>
                    <td class="partner-cell"></td>
                    <td class="partner-cell"></td>
                </tr>
                <tr class="table-last-row">
                    <td class="sponsor-icon">
                        <img src="<?php echo $uploadsDir . 'dollar.svg'?>" alt="dollar sign">
                    </td>
                    <td class="event-icon">
                        <span>Your <br /> Time</span>
                        <img src="<?php echo $uploadsDir . 'circle_.svg'?>" alt="circle sign">
                    </td>
                    <td class="raffle-icon">
                        <span>Random <br> Stuff</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
    <section class="form">
        <form class="business-form" id="business-form" data-stripe-publishable-key="<?php echo BUILDING_U_STRIPE_KEY_PUBLIC; ?>" action="<?php echo admin_url('admin-ajax.php'); ?>">
            <input name="action" type="hidden" value="business-registration" />
            <!-- SPONSOR SECTION -->
            <div class="sponsor-form" id="sponsor-form">
                <hr class="sponsor-line">
                <div class="partner-header">
                    <h2 class="form-title">Sponsoring partner</h2>
                    <!-- SPONSOR DETAILS -->
                    <div class="sponsor-details">
                        <div class="logo">
                            <img src="<?php echo $uploadsDir . 'purposepeacock.svg'?>" alt="sponsor icon">
                        </div>
                        <div class="details">
                            <p><span class="font-bold">These are</span> our financial partners that provide the funding and
                                operational service support that make all of our programming and growth at builing-U possible.</p>
                            <p><span class="font-bold">As a SPONSORING PARTNER you get</span> your LOGO featured in our Footer and
                                Hyperlinked to your page for a timeframe of your choosing...<span class="font-bold">plus a lot of
                    other stuff
                    possibly!</span></p>
                            <ul class="sponsor-plans">
                                <li class="font-bold">1 <span class="font-normal">mth</span>/$500</li>
                                <li class="font-bold">3 <span class="font-normal">mth</span>/$1400</li>
                                <li class="font-bold">6 <span class="font-normal">mth</span>/$2700</li>
                                <li class="font-bold">12 <span class="font-normal">mth</span>/$5000</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- CHECKBOXES -->
                <div class="form-group checkboxes">
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="sponsor-plan" value="5000">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>3 social media posts + 24 email campaigns footers + $4YT sponsor island + Logo in website footer</span>
                  <span>12 mth</span>
                </span>
                        </label>
                    </div>
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="sponsor-plan" value="2700">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>2 social media posts + 6 email campaigns footers + Logo in website footer . . . . . . . . . . . . . . . . . . . . . . .</span>
                  <span>6 mth</span>
                </span>
                        </label>
                    </div>
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="sponsor-plan" value="1400">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>1 social media posts + Logo in website footer . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .</span>
                  <span>3 mth</span>
                </span>
                        </label>
                    </div>
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="sponsor-plan" value="500">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>Logo in website footer . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .</span>
                  <span>1 mth</span>
                </span>
                        </label>
                    </div>
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="sponsor-plan" id="stripe-skip" value="0">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>Contact us to create a custom option to fit your company!</span>
                </span>
                        </label>
                    </div>
                </div>
                <div class="note">
                    <p>Although sponsoring partnerships start at $500., we are appreciative of all levels of support and invite
                        you to check out our contribute page</p>
                </div>
                <div id="stripe-holder">
                    <div class="note note-inverse">
                        <p>Please fill your card details info:</p>
                    </div>
                    <input name="secret" type="hidden" value="" />
                    <div id="stripe-form"></div>
                    <p class="powered-by">Powered By <i class="fab fa-cc-stripe"></i></p>
                </div>
                <div class="note note-error" id="sponsor-error-holder">
                    <p id="sponsor-error"></p>
                </div>
                <hr class="sponsor-line">
            </div>
            <!-- EVENT SECTION -->
            <div class="event-form" id="event-form">
                <hr class="event-line">
                <div class="partner-header">
                    <h2 class="form-title">Event partner</h2>
                    <!-- EVENT DETAILS -->
                    <div class="event-details">
                        <div class="logo">
                            <img src="<?php echo $uploadsDir . 'purposebeaver.svg'?>" alt="sponsor icon">
                        </div>
                        <div class="details">
                            <p><span class="font-bold">These are</span> people who have been invited to represent their business or
                                what they do at our event $4YT</p>
                            <p><span class="font-bold">As a SPONSORING PARTNER you get</span> your LOGO featured in the Partner
                                portion of the $4YT page...leading up to and during the event...<span class="font-bold">plus some
                    other
                    stuff</span></p>
                            <p><span class="font-bold">In exchange, you give</span> a bit of you time to create questions, interact
                                with students, evaluate submissions and select prize winners!</p>
                        </div>
                    </div>
                </div>
                <!-- CHECKBOXES -->
                <div class="form-group checkboxes">
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="event-invited" value="1">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>I was already invited. I'm just filling out my information</span>
                </span>
                        </label>
                    </div>
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="event-invited" value="0">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>I have not been invited quite yet but I would love to learn more about becoming an event partner</span>
                </span>
                        </label>
                    </div>
                </div>
                <div class="note note-error" id="event-error-holder">
                    <p id="event-error"></p>
                </div>
                <hr class="event-line">
            </div>
            <!-- RAFFLE SECTION -->
            <div class="raffle-form" id="raffle-form">
                <hr class="raffle-line">
                <div class="partner-header">
                    <h2 class="form-title">Raffle partner</h2>
                    <!-- EVENT DETAILS -->
                    <div class="raffle-details">
                        <div class="logo">
                            <img src="<?php echo $uploadsDir . 'purposedog.svg'?>" alt="sponsor icon">
                        </div>
                        <div class="details">
                            <p><span class="font-bold">These are</span> organizations who have offer to donate some company swag to
                                our Raffle Rally at $4YT</p>
                            <p><span class="font-bold">As a RAFFLE PARTNER you get</span> your LOGO featured on the Raffle page
                                during
                                the weekend of $4YT...<span class="font-bold">plus some other stuff</span></p>
                        </div>
                    </div>
                </div>
                <!-- CHECKBOXES -->
                <div class="form-group checkboxes">
                    <div class="form-input checkbox col-12">
                        <label class="checkbox-container">
                            <input type="radio" name="raffle-check">
                            <span class="checkmark"></span>
                            <span class="label">
                  <span>We'd love to contribute our cool swag to $4YT!</span>
                </span>
                        </label>
                    </div>
                </div>
                <div class="note note-error" id="raffle-error-holder">
                    <p id="raffle-error"></p>
                </div>
                <hr class="raffle-line">
            </div>
            <hr class="base-line">
            <div class="form-row">
                <!-- FIRST NAME -->
                <div class="form-input col-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" name="firstName " id="firstName" class="form-control" autocomplete="off">
                    <div id="firstNameError" class="input-text input-error"></div>
                </div>
                <!-- LAST NAME -->
                <div class="form-input col-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" name="lastName " id="lastName" class="form-control" autocomplete="off">
                    <div id="lastNameError" class="input-text input-error"></div>
                </div>
            </div>
            <div class="form-row">
                <!-- BUSINESS NAME -->
                <div class="form-input col-8">
                    <label for="businessName" class="form-label">Business Name</label>
                    <input type="text" name="businessName " id="businessName" class="form-control" autocomplete="off">
                    <div id="businessNameError" class="input-text input-error"></div>
                </div>
                <!-- COUNTRY -->
                <div class="form-input col-4">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" name="country " id="country" class="form-control" autocomplete="off">
                    <div id="countryError" class="input-text input-error"></div>
                </div>
            </div>
            <div class="form-row">
                <!-- EMAIL -->
                <div class="form-input col-8">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email " id="email" class="form-control" autocomplete="off">
                    <div id="emailError" class="input-text input-error"></div>
                </div>
                <!-- PHONE -->
                <div class="form-input col-4">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone " id="phone" class="form-control" autocomplete="off">
                    <div id="phoneError" class="input-text input-error"></div>
                </div>
            </div>
            <hr class="base-line">
            <div class="h-captcha" data-sitekey="4d71e4ba-6832-41c4-a837-eceb9bac93dd"></div>
            <div class="form-input submit">
                <button id="btn-submit" data-stripe="false">
                    <span id="submit-main">Submit</span>
                    <span id="submit-process" hidden>
                        <span id="process-text">Processing payment</span>
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                </button>
            </div>
            <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
        </form>
    </section>
</div>
<script src="https://js.stripe.com/v3/"></script>

<?php get_footer(); ?>
