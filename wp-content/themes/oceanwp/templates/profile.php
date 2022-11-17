

    <header class="banner">
        <div class="banner-wrapper">
            <h1 class="title">My Faves</h1>
        </div>
    </header>
    <div class="welcome">
        <span class="welcome-message">Welcome, Nicholas!</span>
    </div>
    <div class="accordion">
        <!-- PROFILE BUTTON -->
        <button class="accordion-btn profile-btn" id="profile-btn">
            <div class="btn-left">
                <i class="fa-solid fa-plus icon plus" id="profile-btn"></i>
            </div>
            <div class="btn-right">
                <span>My profile</span>
                <i class="fa-solid fa-user-ninja icon icon-margin-top"></i>
            </div>
        </button>
        <!-- PROFILE SECTION -->
        <div class="profile hidden" id="profile-section">
            <form action="">
                <div class="form-input">
                    <input type="text" name="first_name" autocomplete="off" required>
                    <label for="first_name" class="form-input-label">
                        <span class="label">First Name</span>
                    </label>
                </div>
                <div class="form-input">
                    <input type="text" name="last_name" autocomplete="off" required>
                    <label for="last_name" class="form-input-label">
                        <span class="label">Last Name</span>
                    </label>
                </div>
                <div class="custom-select">
                    <select name="country" class="dropdown">
                        <option value="" class="dropdown-option">Country</option>
                        <option value="" class="dropdown-option">Test 2</option>
                        <option value="" class="dropdown-option">Test 3</option>
                        <option value="" class="dropdown-option">Test 4</option>
                    </select>
                    <span class="custom-arrow"></span>
                </div>
                <div class="custom-select">
                    <select name="state" class="dropdown">
                        <option value="">State</option>
                        <option value="">Test 2</option>
                        <option value="">Test 3</option>
                        <option value="">Test 4</option>
                    </select>
                    <span class="custom-arrow"></span>
                </div>
                <div class="custom-select">
                    <select name="city" class="dropdown">
                        <option value="">City</option>
                        <option value="">Test 2</option>
                        <option value="">Test 3</option>
                        <option value="">Test 4</option>
                    </select>
                    <span class="custom-arrow"></span>
                </div>
                <div class="custom-select">
                    <select name="education" class="dropdown">
                        <option value="">Education</option>
                        <option value="">Test 2</option>
                        <option value="">Test 3</option>
                        <option value="">Test 4</option>
                    </select>
                    <span class="custom-arrow"></span>
                </div>
                <div class="custom-select">
                    <select name="gender" class="dropdown">
                        <option value="">Gender</option>
                        <option value="">Test 2</option>
                        <option value="">Test 3</option>
                        <option value="">Test 4</option>
                    </select>
                    <span class="custom-arrow"></span>
                </div> 
                <div class="form-input">
                    <button class="submit-btn">
                        <span>Submit</span>
                    </button>
                </div> 
            </form>
        </div>
        <!-- U POINTS BUTTON -->
        <button class="accordion-btn mt-3" id="gift-card-btn">
            <div class="btn-left">
                <i class="fa-solid fa-plus icon" id="u-points-btn"></i>
            </div>
            <div class="btn-right">
                <span>Manage upoints</span>
                <i class="fa-solid fa-hand-holding-heart icon"></i>
            </div>
        </button>
        <!-- U POINTS SECTION -->
        <!-- <div class="gift-card hidden" id="gift-card-section">
            <table class="gift-card-table mt-3">
                <tr id = "gift-card-table-heading">
                    <th>Serial Number</th>
                    <th>Total</th>
                    <th>Remaining</th>
                </tr>

                <tr>
                    <td>QWERTY</td>
                    <td>12</td>
                    <td>6</td>
                </tr>

                <tr>
                    <td>QWERTY</td>
                    <td>12</td>
                    <td>6</td>
                </tr>

                <tr>
                    <td>QWERTY</td>
                        <td>12</td>
                        <td>6</td>
                    </tr>

                    <tr>
                        <td>QWERTY</td>
                            <td>12</td>
                            <td>6</td>
                        </tr>

                        <tr>
                            <td>QWERTY</td>
                                <td>12</td>
                                <td>6</td>
                            </tr>

                            <tr>
                                <td>QWERTY</td>
                                    <td>12</td>
                                    <td>6</td>
                                </tr>

              </table>
        </div>
    </div> -->

    <div>
        <div class = "balance-banner hidden" id="gift-card-section">

            <table class="UPoint-table">
                <tr>
                    <div>
                        <td>
                            <div class="user-balance">
                                <h1 class="number-of-balance">UPoints Balance: 15</h1>
                            </div>
                        </td>

                    </div>
                </tr>
                <tr>
                    <td>
                        <button class="accordion-btn mt-3" id="history-btn">
                            <div class="btn-left">
                                <i class="fa-solid fa-plus icon" id="u-points-btn"></i>
                            </div>
                            <div class="btn-right hidden">
                                <span>History</span>
                                <i class="fa-solid fa-magnifying-glass icon"></i>
                            </div>
                        </button> 

                    <table class= "history-table hidden" id = "table-of-history">
                        <tr class="gift-card-table-heading">
                            <th>Transaction</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>Recieved</td>
                            <td>04/05/2022</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Spent</td>
                            <td>07/12/2022</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>Gifted</td>
                            <td>12/07/2022</td>
                            <td>0.4</td>
                        </tr>
                    </table>
                </td>
                </tr>

                <tr>
                    <td>
                        <button class="accordion-btn mt-3" id="donation-btn">
                            <div class="btn-left">
                                <i class="fa-solid fa-plus icon" id="u-points-btn"></i>
                            </div>
                            <div class="btn-right hidden">
                                <span>Gift</span>
                                <i class="fa-solid fa-heart icon"></i>
                            </div>
                        </button> 

                        <div class = "donation-info hidden" id="donation-field" >

                            <div class="form-input" id="donation-recepient">
                                <input type="text" name="Recipient_Email" autocomplete="off" required>
                                <label for="Recipient_Email" class="form-input-label">
                                    <span class="label" id="recipient-donate-info">Recepient's Email</span>
                                </label>
                            </div>

                            <div class="form-input">
                                <input type="text" name="amount" autocomplete="off" required>
                                <label for="amount" class="form-input-label">
                                    <span class="label">Amount</span>
                                </label>

                            </div>
                        </div>

                    </td>
                </tr>
            </table>
            

        </div>

    </div>


    <!-- <script src="libs/jquery/jquery.js"></script> -->
<!-- Changed from local to cdn jquery -->
<script
      crossorigin="anonymous"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      src="https://code.jquery.com/jquery-3.6.0.min.js"
    >
</script>

<script>
        $( document ).ready(function() {
            $("#profile-btn").on('click', () => {
                $("#profile-section").toggleClass("hidden");
            });

            $("#u-points-btn").on('click', () => {
                $("#gift-card-section").toggleClass("hidden");
                
            });

            $("#donation-btn").on('click', () => {
                $("#donation-field").toggleClass("hidden");
            });

            $("#history-btn").on('click', () => {
                 $("#table-of-history").toggleClass("hidden");
             });
    });

    </script>