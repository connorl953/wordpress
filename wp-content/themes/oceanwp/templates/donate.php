<?php 

/* Template Name: Donate */

get_header();

$attachment = wp_get_attachment_image_src(get_post_thumbnail_id($post -> ID),1200);
	
while(have_posts()):
    the_post(); 

    $bottomContent = get_post_meta($post -> ID,'_bottom_content',true);
?>
<!-- New Contribute Page -->
<div class="container-fluid">
      <div class="container">
        <!-- HEADER -->
        <header class="custom-card col-lg-12 mt-3 py-1">
          <div class="custom-card-wrapper">
            <div class="header-main">
              <h2 class="header-title">Contribute to</h2>
              <div
                class="polaroid polaroid-one polaroid-clockwise polaroid-first-row"
              ></div>
              <div
                class="polaroid polaroid-two polaroid-counter-clockwise polaroid-first-row"
              ></div>
              <div
                class="polaroid polaroid-three polaroid-counter-clockwise polaroid-second-row"
              ></div>
              <div
                class="polaroid polaroid-four polaroid-clockwise polaroid-second-row"
              ></div>
              <div
                class="polaroid polaroid-five polaroid-counter-clockwise polaroid-second-row"
              ></div>
              <div
                class="polaroid polaroid-six polaroid-clockwise polaroid-second-row"
              ></div>
              <div
                class="polaroid polaroid-seven polaroid-counter-clockwise polaroid-second-row"
              ></div>
              <div
                class="polaroid polaroid-eigth polaroid-clockwise polaroid-second-row"
              ></div>
            </div>
            <div class="header-overlay">
              <h2 class="header-title header-overlay-title col-lg-12">
                <a href="https://building-u.com/u-shop">Explore the U-Shop</a>
              </h2>
            </div>
          </div>
        </header>
        <!-- /HEADER -->
        <!-- SECTION -->
        <section class="row mt-3 mb-3">
          <!-- STEPS -->
          <div class="card" id="steps-section">
            <div class="card-wrapper">
              <div class="row">
                <h2 class="title">U-steps</h2>
                <h3>To redeem your rewards at the U-SHOP</h3>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <ul class="step-list">
                    <li class="step-item">
                      <div class="row">
                        <div class="step-number">
                          <span class="step-number-content">1</span>
                        </div>
                        <div class="icon col-lg-2"></div>
                        <div class="step col-lg-6">
                          <p class="instructions">
                            Tell us who to thank and select an amount of
                            support.
                          </p>
                        </div>
                      </div>
                    </li>
                    <li class="step-item" style="margin-top: 55px">
                      <div class="row">
                        <div class="step-number">
                          <span class="step-number-content">2</span>
                        </div>
                        <div class="icon col-lg-2"></div>
                        <div class="step col-lg-6">
                          <p class="instructions">
                            Choose what U would like to support.
                          </p>
                        </div>
                      </div>
                    </li>
                    <li class="step-item" style="margin-top: 50px">
                      <div class="row">
                        <div class="step-number">
                          <span class="step-number-content">3</span>
                        </div>
                        <div class="icon col-lg-2"></div>
                        <div class="step col-lg-6">
                          <p class="instructions">Enter your card details!</p>
                        </div>
                      </div>
                    </li>
                    <li class="step-item" style="margin-top: 50px">
                      <div class="row">
                        <div class="step-number">
                          <span class="step-number-content">4</span>
                        </div>
                        <div class="icon col-lg-2"></div>
                        <div class="step col-lg-6">
                          <p class="instructions">
                            Select if you would like to give your ThankUpointz
                            to someone.
                          </p>
                        </div>
                      </div>
                    </li>
                    <li class="step-item" style="margin-top: 50px">
                      <div style="align-content: center">
                        <p
                          class="instructions"
                          style="margin-left: 30px; width: 80%"
                        >
                          After submitting, you or your recipient will recieve
                          Thank-U pointz and you will be allowed to use these in
                          the U-Shop
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- /STEPS -->
          <!-- FORM -->
          <div class="form-section">
            <div class="card border-dark shadow bg-body rounded-3">
              <div class="card-body">
                <form
                  action="<?php echo admin_url('admin-ajax.php'); ?>"
                  method="POST"
                  onsubmit="return submitDonateForm(this)"
                  novalidate
                >
                  <!-- STEP-ONE -->
                  <div class="form-step row">
                    <div class="form-step-header">
                      <div class="form-step-counter">
                        <span>1</span>
                      </div>
                      <p class="form-step-title">Tell us who you are</p>
                    </div>
                    <div class="form-step-fields">
                      <!-- NAME -->
                      <div class="form-input d-flex flex-column">
                        <label for="name" class="form-label">Name</label>
                        <input
                          type="text"
                          name="name"
                          id="name"
                          class="form-control"
                          autocomplete="off"
                        />
                        <div id="nameError" class="input-text input-error">
                          name error
                        </div>
                      </div>
                      <!-- EMAIL -->
                      <div class="form-input d-flex flex-column">
                        <label for="email" class="form-label">Email</label>
                        <input
                          type="text"
                          name="email"
                          id="email"
                          class="form-control"
                          autocomplete="off"
                        />
                        <div id="mailError" class="input-text input-error">
                          email error
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /STEP-ONE -->
                  <hr class="hr" />
                  <!-- STEP-TWO -->
                  <div class="form-step row">
                    <div class="form-step-header">
                      <div class="form-step-counter">
                        <span>2</span>
                      </div>
                      <p class="form-step-title">
                        Choose an ammount of support
                      </p>
                    </div>
                    <div class="form-step-fields">
                      <div
                        class="preset-amounts"
                        role="group"
                        aria-label="preset ammounts"
                      >
                        <button
                          type="button"
                          data-amount="10"
                          class="btn preset-amount btn-outline-primary"
                        >
                          US$10
                        </button>
                        <button
                          type="button"
                          data-amount="20"
                          class="btn preset-amount btn-outline-primary"
                        >
                          US$20
                        </button>
                        <button
                          type="button"
                          data-amount="40"
                          class="btn preset-amount btn-outline-primary"
                        >
                          US$40
                        </button>
                        <button
                          type="button"
                          data-amount="60"
                          class="btn preset-amount btn-outline-primary"
                        >
                          US$60
                        </button>
                        <button
                          type="button"
                          data-amount="80"
                          class="btn preset-amount btn-outline-primary"
                        >
                          US$80
                        </button>
                        <button
                          type="button"
                          data-amount="100"
                          class="btn preset-amount btn-outline-primary"
                        >
                          US$100
                        </button>
                      </div>
                      <!-- AMOUNT -->
                      <div class="form-input d-flex flex-column">
                        <label for="amount" class="form-label"
                          >Your support</label
                        >
                        <input
                          type="text"
                          name="amount "
                          id="amount"
                          class="form-control"
                          autocomplete="off"
                        />
                        <div id="amountError" class="input-text input-error">
                          amount error
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /STEP-TWO -->
                  <hr class="hr" />
                  <!-- STEP-THREE-->
                  <div class="form-step row">
                    <div class="form-step-header">
                      <div class="form-step-counter">
                        <span>3</span>
                      </div>
                      <p class="form-step-title">
                        Choose what U would like to support
                      </p>
                    </div>
                    <div class="form-step-fields">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="initiative1"
                          name="initiative1"
                        />
                        <label class="form-check-label" for="initiative1">
                          Initiative 1
                        </label>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="initiative2"
                          name="initiative2"
                        />
                        <label class="form-check-label" for="initiative2">
                          Initiative 2
                        </label>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value=""
                          id="initiative3"
                          name="initiative3"
                        />
                        <label class="form-check-label" for="initiative3">
                          Initiative 3
                        </label>
                      </div>
                      <div id="amountError" class="input-text input-info">
                        If you are not sure leave blank
                      </div>
                    </div>
                  </div>
                  <!-- /STEP-THREE-->
                  <hr class="hr" />
                  <!-- STEP-FOUR-->
                  <div class="form-step row">
                    <div class="form-step-header">
                      <div class="form-step-counter">
                        <span>4</span>
                      </div>
                      <p class="form-step-title">Enter your card details</p>
                    </div>
                    <div class="form-step-fields">
                      <!-- CARD NAME -->
                      <div class="form-input d-flex flex-column">
                        <label for="cardName" class="form-label"
                          >Card name</label
                        >
                        <input
                          type="text"
                          name="cardName"
                          id="cardName"
                          class="form-control"
                          autocomplete="off"
                        />
                        <div id="cardNameError" class="input-text input-error">
                          cardName error
                        </div>
                      </div>
                      <!-- CARD NUMBER -->
                      <div class="form-input d-flex flex-column">
                        <label for="cardNumber" class="form-label"
                          >Card number</label
                        >
                        <input
                          type="text"
                          name="cardNumber"
                          id="cardNumber"
                          class="form-control"
                          autocomplete="off"
                        />
                        <div
                          id="cardNumberError"
                          class="input-text input-error"
                        >
                          cardNumber error
                        </div>
                      </div>
                      <div class="row d-flex justify-content-center">
                        <!-- CVC -->
                        <div class="form-input d-flex flex-column col-6">
                          <label for="cvc" class="form-label">CVC</label>
                          <input
                            type="text"
                            name="cvc"
                            id="cvc"
                            class="form-control"
                            autocomplete="off"
                          />
                          <div
                            id="cardNumberError"
                            class="input-text input-error"
                          >
                            cvc error
                          </div>
                        </div>
                        <!-- EXPIRE -->
                        <div class="form-input d-flex flex-column col-6">
                          <label for="expire" class="form-label"
                            >Expires at</label
                          >
                          <input
                            type="text"
                            name="expire"
                            id="expire"
                            class="form-control"
                            autocomplete="off"
                            placeholder="MM/YY"
                          />
                          <div id="expireError" class="input-text input-error">
                            expire error
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /STEP-FOUR-->
                  <!-- SUBMIT -->
                  <div class="form-input d-flex mt-3">
                    <button
                      class="btn btn-primary col-10 offset-1"
                      id="btn_submit"
                    >
                      Donate
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /FORM -->
        </section>
        <!-- /SECTION -->
      </div>
</div>

<!-- NEW SCRIPTS -->
<script
      crossorigin="anonymous"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      src="https://code.jquery.com/jquery-3.6.0.min.js"
    >
  </script>
  <script
      crossorigin="anonymous"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    >
  </script>
  <script
      crossorigin="anonymous"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    >
  </script>
  /* Linking the contribute.js file to the html file. */
  <script src="../assets/js/contribute.js"></script>

<!-- NEW SCRIPTS -->

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
	var stripe = Stripe('<?php echo BUILDING_U_STRIPE_KEY_PUBLIC; ?>');
	var elements = stripe.elements();
	var cardElement = elements.create('card');
	var styles = {base:{'::placeholder':{color:'#F00'}}};

	cardElement.mount('#stripe-form',{style:styles});
</script>


<?php 

endwhile;

get_footer();

?>
