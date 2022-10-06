jQuery(document).ready(($) => {

    // const values
    const errors = $(".note-error");
    const sponsorForm = $("#sponsor-form");
    const eventForm = $("#event-form");
    const raffleForm = $("#raffle-form");
    const btnSubmit = $("#btn-submit");
    const toggleSponsor = $("#sponsor-toggle");
    const toggleEvent = $("#event-toggle");
    const toggleRaffle = $("#raffle-toggle");
    let stripeHolder = $("#stripe-holder");
    let stripe = null;
    let cardElement = null;
    let submitMain = $("#submit-main");
    let submitProcess = $("#submit-process");
    let processText = $("#process-text");

    // let global values
    let sponsorToggle = false;
    let eventToggle = false;
    let raffleToggle = false;

    // init config
    errors.hide();
    sponsorForm.hide();
    eventForm.hide();
    raffleForm.hide();
    stripeHolder.hide();
    submitProcess.hide();
    btnSubmit.prop("disabled", true);

    const initStripe = () => {
        stripe = Stripe($("#business-form").data("stripe-publishable-key"));
        cardElement = (stripe.elements()).create('card');
        let styles = {
            base: {
                backgroundColor: '#CCC',
                iconColor: '#c4f0ff',
                color: '#fff',
                fontWeight: '500',
                fontFamily: 'Raleway, sans-serif',
                fontSize: '18px',
                fontSmoothing: 'antialiased',
                ':-webkit-autofill': {
                    color: '#fce883',
                },
                '::placeholder': {
                    color: '#87BBFD',
                },
            },
            invalid: {
                iconColor: '#FFC7EE',
                color: '#FFC7EE',
            },
        };
        cardElement.mount('#stripe-form',{style:styles});
    }
    initStripe();

    $("#sponsor-toggle-holder").on('click', () => {
        sponsorToggle = toggleSponsor.prop('checked');
        sponsorForm.toggle();
        checkSubmitButton();
        cleanForm();
    });

    $("#event-toggle-holder").on('click', () => {
        eventToggle = toggleEvent.prop('checked');
        eventForm.toggle();
        checkSubmitButton();
        cleanForm();
    });

    $("#raffle-toggle-holder").on('click', () => {
        raffleToggle = toggleRaffle.prop('checked');
        raffleForm.toggle();
        checkSubmitButton();
        cleanForm();
    });

    $('input[name="sponsor-plan"]').change(() => {
        let stripeSkip = $("#stripe-skip");
        let sponsorContact = stripeSkip.prop('checked');
        $("#btn-submit").attr('data-stripe', !sponsorContact);
        !sponsorContact ? stripeHolder.show() : stripeHolder.hide();
        if (sponsorContact) {
            cardElement.clear();
            $("#sponsor-error").text("");
            errors.hide();
        }
    });

    const checkSubmitButton = () => {
        btnSubmit.prop("disabled", !(sponsorToggle || eventToggle || raffleToggle));
    }

    const cleanForm = () => {
        let btnSubmit = $("#btn-submit");
        if(!sponsorToggle && !eventToggle && !raffleToggle) {
            $('.form-control.error').removeClass("error");
            $('.input-error').text("");
        }

        if(!sponsorToggle) {
            $('input[name="sponsor-plan"]').prop("checked", false);
            $("#sponsor-error").text("");
            $("#sponsor-error-holder").hide();
            stripeHolder.hide();
            btnSubmit.attr('data-stripe', 'false');
        }

        if(!eventToggle) {
            $('input[name="event-invited"]').prop("checked", false);
            $("#event-error").text("");
            $("#event-error-holder").hide();
        }

        if(!raffleToggle) {
            $('input[name="raffle-check"]').prop("checked", false);
            $("#raffle-error").text("");
            $("#raffle-error-holder").hide();
        }
    }

    btnSubmit.on('click', (e) => {
        e.preventDefault();
        btnSubmit.prop("disabled", true);
        // validate form
        let validForm = validateForm();
        if (!validForm[0]) {
            if(!validForm[1]) {
                $("#sponsor-error-holder").show();
            }
            if(!validForm[2]) {
                $("#event-error-holder").show();
            }
            if(!validForm[3]) {
                $("#raffle-error-holder").show();
            }
            btnSubmit.prop("disabled", false);
        } else {
            let dataStripe = $("#btn-submit").attr('data-stripe') === "true";
            // process payment and save data
            if(dataStripe) {
                getStripePaymentIntent();
                processStripePayment();
            } else {
                saveBusinessForm();
            }
        }
    });

    const getStripePaymentIntent = () => {
        processText.text("Connecting to stripe...");
        submitMain.hide()
        submitProcess.show();

        let payload = {
            'action': 'stripe_payment_intent',
            'stripe_amount': parseInt($('input[name="sponsor-plan"]:checked').val(),10)
        };

        $.ajax({
            type: "POST",
            async: false,
            url: $("#business-form").attr('action'),
            data: payload,
            success: function(response) {
                $("#stripe-form").attr("data-secret", response.secret);
            },
            dataType: 'json'
        });
    }

    const processStripePayment = () => {
        processText.text("Sending contribution...");
        let stripeSecret = $("#stripe-form").data('secret');

        stripe.handleCardPayment(
            stripeSecret,
            cardElement,
            {
                payment_method_data: {
                    billing_details: {
                        name: $("#firstName").val(),
                        email: $("#email").val()
                    }
                }
            }
        ).then( (response) => {
            if(response.error) {
                $("#sponsor-error").text(response.error.message ?? 'There was an error. Please e-mail us to connect@building-u.com');
                errors.show();
                submitProcess.hide();
                processText.text("");
                submitMain.show();
                btnSubmit.prop("disabled", false);
            }

            if(response.paymentIntent) {

                processText.text("Confirming transaction...");
                let payload = {
                    'action': 'business_registration_payment',
                    'business_name': $("#businessName").val(),
                    'payment_intent': response.paymentIntent.id
                };

                $.ajax({
                    type: "POST",
                    async: false,
                    url: $("#business-form").attr('action'),
                    data: payload,
                    success: function(response) {
                       if(response.success) {
                           saveBusinessForm();
                       } else {
                           $("#sponsor-error").text(response.error.message ?? 'There was an error. Please e-mail us to connect@building-u.com');
                           errors.show();
                           submitProcess.hide();
                           processText.text("");
                           submitMain.show();
                           btnSubmit.prop("disabled", false);
                       }
                    },
                    dataType: 'json'
                });
            }
        });
    }

    const saveBusinessForm = () => {
        console.log("TEST");
        processText.text("Double-checking...");
        submitMain.hide();
        submitProcess.show();
        let payload = {
            'action': 'business_form_save',
            'first_name': $("#firstName").val(),
            'last_name':  $("#lastName").val(),
            'business_name': $("#businessName").val(),
            'country': $("#country").val(),
            'email': $("#email").val(),
            'phone': $("#phone").val(),
            'sponsor_partner': sponsorToggle,
            'sponsor_plan': $('input[name="sponsor-plan"]:checked').val(),
            'event_partner': eventToggle,
            'event_invited': $('input[name="event-invited"]:checked').val(),
            'raffle_partner': raffleToggle,
            'status': "Submitted"
        };

        $.post($("#business-form").attr('action'), payload, function(response) {
            console.log(response);
            submitProcess.hide();
            processText.text("");
            submitMain.text("Thanks!");
            submitMain.show();
            btnSubmit.prop("disabled", false);
        }, 'json');
    }

    /*
    * Method validates business registration form
    */
    const validateForm = () => {

        let validForm = true;

        // base form
        const firstName = $("#firstName");
        const firstNameError = $("#firstNameError");
        const lastName = $("#lastName");
        const lastNameError = $("#lastNameError");
        const businessName = $("#businessName");
        const businessNameError = $("#businessNameError");
        const country = $("#country");
        const countryError = $("#countryError");
        const email = $("#email");
        const emailError = $("#emailError");
        const phone = $("#phone");
        const phoneError = $("#phoneError");

        let emailRegex = new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, "gm");

        if ((firstName.val()).length === 0) {
            validForm = false;
            firstName.addClass("error");
            firstNameError.text("Enter your first name");
        }

        if ((lastName.val()).length === 0) {
            validForm = false;
            lastName.addClass("error");
            lastNameError.text("Enter your last name");
        }

        if ((businessName.val()).length === 0) {
            validForm = false;
            businessName.addClass("error");
            businessNameError.text("Enter the business name");
        }

        if ((country.val()).length === 0) {
            validForm = false;
            country.addClass("error");
            countryError.text("Enter the business country");
        }

        if ((email.val()).length === 0) {
            validForm = false;
            email.addClass("error");
            emailError.text("Enter the business email");
        } else {
            if (!emailRegex.test(email.val())) {
                validForm = false;
                email.addClass("error");
                emailError.text("Enter a valid business email");
            }
        }

        if ((phone.val()).length === 0) {
            validForm = false;
            phone.addClass("error");
            phoneError.text("Enter the business phone");
        }

        // sponsor form
        let sponsorRadio = $('input[name="sponsor-plan"]:checked');
        let sponsorError = $("#sponsor-error");
        let sponsorFlag = true;
        if(sponsorToggle) {
            if(sponsorRadio.length === 0) {
                validForm = false;
                sponsorFlag = false;
                sponsorError.text("Select one option or uncheck from top table");
            }
        }

        // event form
        let eventRadio = $('input[name="event-invited"]:checked');
        let eventError = $("#event-error");
        let eventFlag = true;
        if(eventToggle) {
            if(eventRadio.length === 0) {
                console.log("test2");
                validForm = false;
                eventFlag = false;
                eventError.text("Select one option or uncheck from top table");
            }
        }

        // raffle form
        let raffleRadio = $('input[name="raffle-check"]:checked');
        let raffleError = $("#raffle-error");
        let raffleFlag = true;
        if(raffleToggle) {
            if(raffleRadio.length === 0) {
                validForm = false;
                raffleFlag = false;
                raffleError.text("Confirm or uncheck from top table");
            }
        }

        return [validForm, sponsorFlag, eventFlag, raffleFlag];
    }
});