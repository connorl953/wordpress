var modal = document.querySelector('.modal');
var bodyTag = document.querySelector('body');
var url = window.location.pathname;
var filterSelects = document.querySelectorAll('.archive-listing .container .row .col.filters ul li ul li input[type="checkbox"]');
var totalSelects = filterSelects.length;
var redirect = getCookie('redirect');

if(redirect){
	var date = new Date();
    date.setTime(date.getTime() - (1000*60*60*24));
    var expires = " expires=" + date.toGMTString() + ';';

    document.cookie = 'redirect=;'+expires+';path=/';
    document.location.href = redirect;
}

var videoPlayed = getCookie('video');

if(!videoPlayed){
	var validPage = document.querySelector('.page-id-1974, .post-type-archive-programs, .post-type-archive-funding, .post-type-archive-opportunities');
	
	if(validPage){
		setTimeout(function(){
			bodyTag.className = bodyTag.className.indexOf('display-modal') === -1 ? bodyTag.className + ' display-modal' : bodyTag.className.replace(' display-modal','');
			modal.className += ' video';
			modal.lastElementChild.lastElementChild.innerHTML = '<div class="video"><i class="fa fa-times" onClick=closeVideo()></i><video autoplay controls><source src="'+themeUrl+'/assets/videos/BU_fave-vid_final.mp4" type="video/mp4"></video></div>';
		},10000);
	}
}

if(totalSelects){
	for(var x=0;x<totalSelects;x++){
		filterSelects[x].addEventListener('change',function(){
			generateUrlParams();
		});
	}
}

var headerVideoLink = document.querySelector('ul li.video span');

if(headerVideoLink){
	headerVideoLink.addEventListener('click',function(e){
		e.preventDefault();

		bodyTag.className = bodyTag.className.indexOf('display-modal') === -1 ? bodyTag.className + ' display-modal' : bodyTag.className.replace(' display-modal','');
		modal.className += ' video';
		modal.lastElementChild.lastElementChild.innerHTML = '<div class="video"><i class="fa fa-times" onClick=closeVideo()></i><video autoplay controls><source src="'+themeUrl+'/assets/videos/BU_fave-vid_final.mp4" type="video/mp4"></video><div class="featured-programs"><img src="/wp-content/uploads/signup-to.png" alt="" class="featured-label"><div class="featured-program"><a href="/save-to-faves/"><span>Favourite</span></a></div><div class="featured-program"><a href="/event/"><span>S4Yt</span></a></div></div></div>';
	});
}

var headerLogout = document.querySelector('ul li.logout span');

if(headerLogout){
	headerLogout.addEventListener('click',function(e){
		e.preventDefault();

		headerLogout.innerText = '......';

		var formData = new FormData();
		var xhttp = new XMLHttpRequest();

		formData.append('action','process_logout');

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					location.reload();
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
										  
		xhttp.open('POST',ajaxurl,true);
		xhttp.send(formData);
	});
}

var headerDonate = document.querySelector('.dropdown-menu li .sub-menu li.donate, a.donate');

if(headerDonate){
	headerDonate.addEventListener('click',function(e){
		e.preventDefault();

		var payPalForm = document.querySelector('form.paypay_form');

		if(payPalForm){
			payPalForm.submit();
		}
	});
}

var donatePage = document.querySelector('.page-template-donate div.donate');

if(donatePage){
	var donateFeatures = donatePage.querySelectorAll('.container .row .col-12 .features .type-row .type .type-thumbs .thumb');
	var totalDonateFeatures = donateFeatures.length;
	
	if(totalDonateFeatures){
		for(var x=0;x<totalDonateFeatures;x++){
			donateFeatures[x].init = function(){
				var totalImages = this.children.length;

				if(totalImages){
					this.setAttribute('data-total',totalImages);
					this.setAttribute('data-position',0);
					this.style.background = 'url(\''+this.children[0].getAttribute('src')+'\') no-repeat center center/cover #f1f1f1';

					this.addEventListener('click',function(){
						var index = this.getAttribute('data-position');
						var link = this.children[index].getAttribute('data-link');
						
						if(link){
							document.location.href = link;
						}
					});

					if(totalImages > 1){
						var arrows = this.parentNode.querySelectorAll('.arrow');
						var totalArrows = arrows.length;

						if(totalArrows){
							for(var x=0;x<totalArrows;x++){
								arrows[x].addEventListener('click',function(){
									var thumbs = this.parentNode.firstElementChild;
									var position = parseInt(thumbs.getAttribute('data-position'));
									var total = parseInt(thumbs.getAttribute('data-total'));

									if(this.className === 'arrow right'){
										var newPosition = position + 1 < total ? position + 1 : 0;
									}else{
										var newPosition = position - 1 >= 0 ? position - 1 : total - 1;
									}

									thumbs.style.background = 'url(\''+thumbs.children[newPosition].getAttribute('src')+'\') no-repeat center center/cover #f1f1f1';

									thumbs.setAttribute('data-position',newPosition);
								});
							}
						}
					}
				}
			}

			donateFeatures[x].init();
		}
	}

	var donateForm = donatePage.querySelector('.form');
	var amountInput = donateForm.querySelector('form input[name="amount"]:checked');
}

var blogBtn = document.querySelector('.blog-archive .right-column .blog-pagination a.btn');

if(blogBtn){
	var blogHeader = document.querySelector('.page-header .page-header-inner');

	blogBtn.addEventListener('click',function(e){
		e.preventDefault();
		window.scrollTo(0,0);
	});
}

var perspectiveSlider = document.querySelectorAll('.perspectives .perspective-single');
var totalPerspectiveSlider = perspectiveSlider.length;

if(totalPerspectiveSlider){
	for(var x=0;x<totalPerspectiveSlider;x++){
		perspectiveSlider[x].initArrows = function(){
			var thisNode = this;
			var arrows = thisNode.querySelectorAll('.arrow');
			var totalArrows = arrows.length;

			if(totalArrows){
				for(var x=0;x<totalArrows;x++){
					arrows[x].addEventListener('click',function(){
						var slider = this.parentNode.children[1].firstElementChild;
						var position = this.parentNode.position;
						var total = this.parentNode.total;
						var display = this.parentNode.display;

						if(this.className.indexOf('left') !== -1){
							var newPosition = position - 1 >= 0 ? position - 1 : total - (display); 
						}else{
							var newPosition = position + 1 < total - (display - 1) ? position + 1  : 0; 
						}

						this.parentNode.position = newPosition;
						slider.style.marginLeft = '-' + ((newPosition) * (slider.firstElementChild.offsetWidth + 40)) + 'px';
					});
				}
			}
		};
		perspectiveSlider[x].init = function(){
			var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			var itemDisplay = screenWidth > 600 ? 3 : 2;
			var width = this.offsetWidth;
			var itemWidth = Math.ceil(width / itemDisplay) - 30;
			var slides = this.querySelectorAll('.perspective-items .perspective-container .perspective-item');
			var totalSlides = slides.length;

			if(totalSlides){	
				slides[0].parentNode.style.marginLeft = 0;
				slides[0].parentNode.style.width = ((itemWidth + 40) * totalSlides) + 'px';
				slides[0].parentNode.parentNode.className = totalSlides > itemDisplay ? 'perspective-items has-arrows' : 'perspective-items';

				for(var x=0;x<totalSlides;x++){
					slides[x].style.width = itemWidth + 'px';
				}
			}

			this.display = itemDisplay;
			this.total = totalSlides;
			this.position = 0;
		}
		perspectiveSlider[x].initArrows();
		perspectiveSlider[x].init();
	}
}

var addToFavourites = document.querySelector('.arm-details .container .row .col .add-btn a');

if(addToFavourites){
	addToFavourites.addEventListener('click',function(e){
		e.preventDefault();

		var thisNode = this;
		var isLogged = parseInt(thisNode.getAttribute('data-user'));
		var id = thisNode.getAttribute('data-id');
		var favourite = parseInt(thisNode.getAttribute('data-favourite'));		
		
		if(isLogged > 0){			
			if(favourite === 0) {
				showModalSpinner();
				addFavourite(id);
			}			
		}else{
			showModalSpinner();
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status === 200){
						var response = xhttp.response; 
						
						modal.className = modal.className.replace(' loading','') + ' login-form';
						modal.lastElementChild.lastElementChild.innerHTML = '<p>Please login to add to favourites</p>' + response;
					}else{
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
											  
			xhttp.open('GET',themeUrl + '/partials/login-form.php?addToFavourites='+id,true);
			xhttp.send();
		}
	});
}

var faqItems = document.querySelectorAll('.faq-list .faq .faq-title strong');
var totalFaqItems = faqItems.length;

if(totalFaqItems){
	for(var x=0;x<totalFaqItems;x++){
		faqItems[x].addEventListener('click',function(){
			this.parentNode.parentNode.className = this.parentNode.parentNode.className.indexOf('active') === -1 ? this.parentNode.parentNode.className + ' active' : this.parentNode.parentNode.className.replace(' active','');
		});
	}
}

var sliders = document.querySelectorAll('.slider');
var totalSliders = sliders.length;

if(totalSliders){
	for(var x=0;x<totalSliders;x++){
		sliders[x].autoSlide = null;
		sliders[x].arrowInit = false;
		sliders[x].changeSlide = function(_forward){
			var position = this.position;
			var total = this.totalSlides;
			
			if(_forward){
				var newPosition = position + 1 < total ? position + 1 : 0;;
			}else{
				var newPosition = position - 1 >= 0 ? position - 1 : total - 1;
			}

			this.position = newPosition;
			this.children[position].className = this.children[position].className.replace(' active','');
			this.children[newPosition].className += ' active';
		}
		sliders[x].init = function(){
			var thisNode = this;
			var slides = thisNode.querySelectorAll('.slide');
			var totalSlides = slides.length;
			var minHeight = 0;

			if(totalSlides){
				for(var x=0;x<totalSlides;x++){
					if(slides[x].offsetHeight > minHeight){
						minHeight = slides[x].offsetHeight;
					}
					if(x === 0){
						slides[x].className += ' active';
					}
				}

				thisNode.style.minHeight = minHeight + 'px';
				thisNode.position = 0;
				thisNode.totalSlides = totalSlides;
			}

			if(totalSlides > 1){
				if(thisNode.autoSlide){
					clearInterval(thisNode.autoSlide);
				}

				thisNode.autoSlide = setInterval(function(_node){
					_node.changeSlide(true);
				},4500,thisNode);
			}

			if(!thisNode.arrowInit){
				var arrows = thisNode.querySelectorAll('.arrow');
				var totalArrows = arrows.length;

				if(totalArrows){
					for(var x=0;x<totalArrows;x++){
						arrows[x].forward = x === 0 ? false : true;
						arrows[x].addEventListener('click',function(){
							var thisNode = this;

							thisNode.parentNode.changeSlide(thisNode.forward);

							clearInterval(thisNode.parentNode.autoSlide);

							thisNode.parentNode.autoSlide = setInterval(function(_node){
								_node.changeSlide(true);
							},4500,thisNode.parentNode);
						});
					}
				}
			}
		}
		sliders[x].init();
	}
}

var paymentModal = document.querySelector('.payment-modal');

if(paymentModal){
	var paymentBtn = paymentModal.parentNode.querySelector('.buy span');
	var paymentForm = paymentModal.querySelector('.row .content form');

	if(paymentBtn){
		paymentBtn.addEventListener('click',function(e){
			e.preventDefault();
			paymentModal.style.display = 'table';
		});
	}

	if(paymentForm){
		var hoursInput = paymentModal.querySelector('fieldset input[name="hours"]');
		var paymentIntent = paymentModal.querySelector('fieldset input[name="payment_intent"]');
		var clientSecret = paymentModal.querySelector('fieldset input[name="client_secret"]');

		paymentForm.addEventListener('submit',function(e){
			e.preventDefault();

			var validation = this.validateForm();

			if(validation){
				hoursInput.setAttribute('readonly',true);
				this.updatePaymentIntent(true);
				this.toggleButton();
			}

			return false;
		});

		paymentForm.validateForm = function(){
			var valid = hoursInput.value && hoursInput.value > 0 ? true : false;
			
			if(valid){
				hoursInput.parentNode.removeAttribute('class');
			}else{
				hoursInput.parentNode.className = 'invalid';
			}

			return valid;
		}

		paymentForm.updatePaymentIntent = function(_payment){
			var form = this;
			console.log("updatePaymentIntent", form);
			var validation = form.validateForm();

			if(validation){
				var formData = new FormData();
        		var xhttp = new XMLHttpRequest();

        		formData.append('action','process_payment_intent');
        		formData.append('hours',hoursInput.value);

        		if(paymentIntent.value){
        			formData.append('payment_intent',paymentIntent.value);
        		}

        		xhttp.onreadystatechange = function(){
		            if(xhttp.readyState == 4){
		                if(xhttp.status === 200){
		                    try{
		                        var response = JSON.parse(xhttp.response)
		                    }catch(e){
		                        var response = xhttp.response; 
		                    }
		                    
		                    if(response.success){
		                    	paymentIntent.value = response.intent;
		                    	clientSecret.value = response.secret;

		                    	if(_payment){
		                    		form.processPayment();
		                    	}
		                    }else{
		                    	alert('There was an error, please contact us! Code Error: 428');
		                    }
		                }else{
		                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
		                }
		            }
		        };

		        xhttp.open(form.getAttribute('method'),form.getAttribute('action'),true);
	        	xhttp.send(formData);
			}
		}

		paymentForm.processPayment = function(){
			var form = this;
			var cardholderName = form.querySelector('input[name="first_name"]').value;
			var cardholderSurName = form.querySelector('input[name="last_name"]').value;
			var cardholderEmail = form.querySelector('input[name="email"]').value;

			stripe.handleCardPayment(
			    clientSecret.value, cardElement, {
			      	payment_method_data: {
			        	billing_details: {
			        		name: cardholderName + ' ' + cardholderSurName,
			        		email: cardholderEmail
			        	}
			      	}
			    }
			).then(function(result){
			    if(result.paymentIntent){
			    	paymentIntent.value = result.paymentIntent.id;
			    	
			    	var formData = new FormData(form);
	        		var xhttp = new XMLHttpRequest();

	        		xhttp.onreadystatechange = function(){
			            if(xhttp.readyState == 4){
			                if(xhttp.status === 200){
			                    try{
			                        var response = JSON.parse(xhttp.response)
			                    }catch(e){
			                        var response = xhttp.response; 
			                    }
			                    
			                    var message = response.success ? 'You have successfully purchased ' + form.querySelector('input[name="hours"]').value + ' hours' : response.error;

			                    alert(message);

			                    if(response.success){
			                    	location.reload();
			                    }
			                }else{
			                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
			                }
			            }
			        };

			        xhttp.open(form.getAttribute('method'),form.getAttribute('action'),true);
		        	xhttp.send(formData);

			    }else{
			    	var error = result.error && result.error.message ? result.error.message : 'There was an error, please try again or contact us! Error Code: 490';
			    	
			    	setTimeout(function(){
		    			paymentForm.alertNotice(error);
		    		},250);

			    	form.toggleButton();
			    }
			});
		}

		paymentForm.toggleButton = function(){
			var formBtn = this.querySelector('button');
			var isDisabled = formBtn.getAttribute('disabled');

			if(!isDisabled){
				formBtn.setAttribute('disabled',true);
				formBtn.innerText = 'Please wait...';
			}else{
				formBtn.removeAttribute('disabled');
				formBtn.innerText = 'Buy';
			}
		}

		paymentForm.alertNotice = function(_message){
			if(_message){
				alert(_message);
			}
		}

		paymentForm.updatePaymentIntent();
	}
}

var sections = document.querySelectorAll('.page-template-account .section .section-title');
var totalSections = sections.length;

if(totalSections){
	for(var x=0;x<totalSections;x++){
		sections[x].addEventListener('click',function(){
			this.parentNode.className = this.parentNode.className.indexOf('open') === -1 ? this.parentNode.className + ' open' : this.parentNode.className.replace(' open','');
		});
	}
}

var accountPage = document.querySelector('.page-template-account');
if(accountPage){
	var negativehours = accountPage.querySelectorAll('#summary .section-content .summary-items ul li ul li.red');
	var totalNegativeHours = negativehours.length;
	
	if(totalNegativeHours){
		var start = totalNegativeHours - 1;
		
		for(var x=start;x>=0;x--){
			var negative = parseFloat(negativehours[x].innerText);
			var nextSection = negativehours[x].parentNode.parentNode.parentNode.previousElementSibling;

			if(nextSection){
				updateHours(nextSection,negative);
			}

		}
	}
}

function closeVideo(){
	bodyTag.className = bodyTag.className.replace(' display-modal','');
	modal.className = modal.className.replace('video','');
	modal.lastElementChild.lastElementChild.innerHTML = '';

	setCookie('video',1,365);
}

function updateHours(_node,_hours){
	var nextSectionTotal = _node.lastElementChild.lastElementChild.lastElementChild;
	var newTotal = parseFloat(nextSectionTotal.innerText) + _hours;

	nextSectionTotal.innerText = newTotal;

	if(newTotal < 0){
		nextSectionTotal.className = 'red';

		var nextSection = _node.previousElementSibling;

		if(nextSection){
			if(nextSection.localName === 'hr'){
				nextSection = nextSection.previousElementSibling;
			}

			updateHours(nextSection,newTotal)
		}
	}
}

function showModalSpinner(){
	bodyTag.className = bodyTag.className.indexOf('display-modal') === -1 ? bodyTag.className + ' display-modal' : bodyTag.className.replace(' display-modal','');
	var icon = document.createElement('i');		
	modal.className += ' loading';
	icon.className = 'fas fa-spinner fa-pulse';
	modal.lastElementChild.lastElementChild.appendChild(icon);
}


function addFavourite(_id){
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4){
			if(xhttp.status === 200){
				try{
			    	var response = JSON.parse(xhttp.response)
				}catch(e){
			   		var response = xhttp.response; 
			    }
			    
				location.reload();
			}else{
				throw 'invalid HTTP request: ' + xhttp.status + ' response';
			}
		}
	};
									  
	xhttp.open('POST',actionUrl,true);
	xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xhttp.send(encodeURI('action=process_add_to_favourites&id='+_id));
}

function clearModal(_modal){
	var bodyTag = document.querySelector('body');
	var modelContent = _modal.lastElementChild.lastElementChild;
		
	_modal.className = 'modal';
	bodyTag.className = bodyTag.className.replace(' display-modal','');

	while(modelContent.lastElementChild){
		modelContent.removeChild(modelContent.lastElementChild);
	}
}

function generateUrlParams(){
	var urlParams = [];
	var urlParamsString = null;
	var keys = [];

	if(totalSelects){
		for(var x=0;x<totalSelects;x++){
			if(filterSelects[x].checked){
				var name = filterSelects[x].getAttribute('name');

				if(!urlParams[name]){
					urlParams[name] = filterSelects[x].value;
					keys.push(name);
				}else{
					urlParams[name] += ',' + filterSelects[x].value;
				}
			}
		}
	}

	var totalKeys = keys.length;

	if(totalKeys){
		for(var x=0;x<totalKeys;x++){
			var key = keys[x];

			if(!urlParamsString){
				urlParamsString = key + '=' + urlParams[key];
			}else{
				urlParamsString += '&' + key + '=' + urlParams[key];
			}
		}
	}

	document.location.href = urlParamsString ? url + '?' + urlParamsString : url;
}

function logout(_form){	
	var formBtn = _form.querySelector('button');
	var formData = new FormData(_form);
	var xhttp = new XMLHttpRequest();

	formBtn.innerText = 'Please wait...';

	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4){
			if(xhttp.status === 200){
				try{
			    	var response = JSON.parse(xhttp.response)
				}catch(e){
			   		var response = xhttp.response; 
			    }

				location.reload();
			}else{
				throw 'invalid HTTP request: ' + xhttp.status + ' response';
			}
		}
	};
									  
	xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
	xhttp.send(formData);

	return false
}

function login_signup(_form,_id){
	var isSignup = _form.getAttribute('name') === 'signup' ? true : false;
	var formValidation = validateForm(_form);
	
	if(formValidation){
		var processForm = true;

		if(isSignup){
			var passwords = _form.querySelectorAll('input[type="password"]');
			var totalPasswords = passwords.length;

			if(totalPasswords == 2 && passwords[0].value !== passwords[1].value){
				processForm = false;
				alert('Passwords must match!');
			}
		}

		if(processForm){
			var formBtn = _form.querySelector('button');
			var btnText = formBtn.innerText;
			var formData = new FormData(_form);
			var xhttp = new XMLHttpRequest();

			formBtn.innerText = 'Please wait...';

			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status === 200){
						try{
					    	var response = JSON.parse(xhttp.response)
						}catch(e){
					   		var response = xhttp.response; 
					    }

						if(response.success){
							if(_id){
								addFavourite(_id);
							}else{
								location.reload();
							}
						}else{
							formBtn.innerText = btnText;
							alert(response.error);
						};	
					}else{
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
											  
			xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
			xhttp.send(formData);
		}
	}

	return false
}

function forgotPasswordModal(_this,_action){
	bodyTag.className = bodyTag.className.indexOf('display-modal') === -1 ? bodyTag.className + ' display-modal' : bodyTag.className.replace(' display-modal','');
	modal.className = modal.className.replace(' loading','') + ' forgot-form';
	modal.lastElementChild.lastElementChild.innerHTML = '<p>Please enter your email address and we will send you a temporary password</p><form action="'+_action+'" method="POST" onsubmit="return forgotPassword(this)" novalidate><fieldset><input name="email" type="email" placeholder="*Email Address" required /></fieldset><fieldset><button>Submit</button><input name="action" type="hidden" value="process_forgot_password" /></fieldset></form>';

	return false;
}

function forgotPassword(_form){
	var formValidation = validateForm(_form);
	
	if(formValidation){
		var formBtn = _form.querySelector('button');
		var btnText = formBtn.innerText;
		var formData = new FormData(_form);
		var xhttp = new XMLHttpRequest();

		formBtn.innerText = 'Please wait...';

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
				    	var response = JSON.parse(xhttp.response)
					}catch(e){
				   		var response = xhttp.response; 
				    }

				    var paragraph = document.createElement('p');

				    paragraph.innerText = 'If there as an account associated with the email address, you will be emailed a new reset password link.';
					formBtn.innerText = 'Thank you!';
					formBtn.disabled = true;
					formBtn.parentNode.insertBefore(paragraph,formBtn);
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
										  
		xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
		xhttp.send(formData);
	}

	return false;
}

function resetPassword(_form){
	var formValidation = validateForm(_form);
	
	if(formValidation){
		var passwordFields = _form.querySelectorAll('input[type="password"]');
		var totalPasswordFields = passwordFields.length;
		var postForm = true;

		if(totalPasswordFields === 2 && passwordFields[0].value !== passwordFields[1].value){
			postForm = false;
			alert('Password do not match, please try again!');
		}

		if(postForm){
			var formData = new FormData(_form);
			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status === 200){
						try{
					    	var response = JSON.parse(xhttp.response)
						}catch(e){
					   		var response = xhttp.response; 
					    }
					    
					    if(response.success){
					    	var btn = _form.querySelector('button');

					    	btn.innerText = 'Thank you!';
					    	btn.disabled = true;
					    	alert('Password has been reset!');
					    }else{
					    	var error = response.error ? response.error : 'There was an error, please contact us! Error Code: 824';
					    	alert(error);
					    }
					}else{
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
											  
			xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
			xhttp.send(formData);
		}
	}

	return false;
}

function setPrice(_node){
	var totalHours = parseInt(_node.value);
	var totalPrice = 0;

	if(!totalHours){
		totalHours = 0;
	}

	if(totalHours > 0){
		totalPrice += totalHours > 5 ? 90 * 5 : 90 * totalHours;
	}	
	
	if(totalHours > 5){
		totalPrice += totalHours > 10 ? 85 * 5 : 85 * (totalHours - 5);
	}
	
	if(totalHours > 10){
		totalPrice += 75 * (totalHours - 10);
	}
	
	var formattedPrice = totalPrice.toFixed(2);
	var response = totalHours ? {'hours':totalHours,'total':formattedPrice} : null;

	_node.parentNode.parentNode.lastElementChild.firstElementChild.firstElementChild.innerText = formattedPrice;
	_node.parentNode.parentNode.lastElementChild.lastElementChild.value = formattedPrice;

	return response;
}

function deleteFavourite(_id){
	bodyTag.className = bodyTag.className.indexOf('display-modal') === -1 ? bodyTag.className + ' display-modal' : bodyTag.className.replace(' display-modal','');

	var icon = document.createElement('i');
	
	modal.className += ' loading';
	icon.className = 'fas fa-spinner fa-pulse';
	modal.lastElementChild.lastElementChild.appendChild(icon);
	
	addFavourite(_id);
}

function submitIndividualForm(_form){
	var formValidate = validateForm(_form);

	if(formValidate){
		var contribution = _form.querySelector('input[name="contribution"]:checked');

		if(contribution){
			var contributionAmount = contribution.value == 0 ? _form.querySelector('input[name="donation_amount"]').value : contribution.value;
			var btn = _form.querySelector('button');

			btn.disabled = true;
			btn.innerText = 'Please wait...';

			if(contributionAmount){
				var creditCardPayment = _form.querySelector('select[name="donate_cc"]');

				if(creditCardPayment.value == 1){
					var cardholderName = _form.querySelector('input[name="cc_name"]').value;
					var cardholderEmail = _form.querySelector('input[name="email"]').value;
					var clientSecret = _form.querySelector('#stripe-form').getAttribute('data-secret');

					if(!cardholderName){
						cardholderName = _form.querySelector('input[name="contact_name"]').value;
					}

					stripe.handleCardPayment(
					    clientSecret, cardElement, {
					      	payment_method_data: {
					        	billing_details: {
					        		name: cardholderName,
					        		email: cardholderEmail
					        	}
					      	}
					    }
					).then(function(result){
					    if(result.paymentIntent){
					    	var paymentIntent = document.createElement('input');    	

			        		paymentIntent.setAttribute('name','payment_intent');
			        		paymentIntent.setAttribute('type','hidden');
			        		paymentIntent.value = result.paymentIntent.id;
			        		_form.appendChild(paymentIntent);

			        		var formData = new FormData(_form);
			        		var xhttp = new XMLHttpRequest();

			        		xhttp.onreadystatechange = function(){
					            if(xhttp.readyState == 4){
					                if(xhttp.status === 200){
					                    try{
					                        var response = JSON.parse(xhttp.response)
					                    }catch(e){
					                        var response = xhttp.response; 
					                    }
					                    
					                    if(response.success){
					                    	var btn = _form.querySelector('button');

					                    	btn.innerText = 'Thank you';
					                    	btn.disabled = true;
					                    }else{
					                    	var error = response.error ? response.error : 'There was an error, please contact us! Error Code: 943';

					                    	btn.innerText = 'Submit';
					                    	btn.removeAttribute('disabled');
					                    	alert(error);
					                    }
					                }else{
					                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
					                }
					            }
					        };

					        xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
				        	xhttp.send(formData);
					    }else{
					    	var error = result.error && result.error.message ? result.error.message : 'There was an error, please try again or contact us! Error Code: 959';

					    	btn.removeAttribute('disabled');
							btn.innerText = 'Submit';
					    	
					    	setTimeout(function(){
				    			alert(error);
				    		},250);
					    }
					});
				}else{
					var formData = new FormData(_form);
	        		var xhttp = new XMLHttpRequest();

	        		xhttp.onreadystatechange = function(){
			            if(xhttp.readyState == 4){
			                if(xhttp.status === 200){
			                    try{
			                        var response = JSON.parse(xhttp.response)
			                    }catch(e){
			                        var response = xhttp.response; 
			                    }
			                    
			                    if(response.success){
			                    	var btn = _form.querySelector('button');

			                    	btn.innerText = 'Thank you';
			                    	btn.disabled = true;
			                    }else{
			                    	var error = response.error ? response.error : 'There was an error, please contact us! Error Code: 988';

			                    	btn.innerText = 'Submit';
					                btn.removeAttribute('disabled');
			                    	alert(error);
			                    }
			                }else{
			                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
			                }
			            }
			        };

			        xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
		        	xhttp.send(formData);
				}
			}else{
				alert('Please enter a contribution amount!');
			}
		}else{
			alert('Please select a contribution amount!');
		}
	}

	return false;
}

function updateContribution(_node){
	var valid = _node.validity.valid;

	if(valid){
		var form = _node.parentNode.parentNode;
		var email = form.querySelector('input[name="email"]');
		var secret = form.querySelector('input[name="secret"]');
		var formData = new FormData();
		var xhttp = new XMLHttpRequest();

		formData.append('action','business_donation');
		formData.append('amount',_node.value);

		if(secret.value !== ''){
			formData.append('payment_intent',secret.value);
		}

		if(email.value){
			formData.append('email',email.value);
		}

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
				    	var response = JSON.parse(xhttp.response)
					}catch(e){
				   		var response = xhttp.response; 
				    }

				    if(response.success){
				    	secret.value = response.intent;
				    	secret.nextElementSibling.setAttribute('data-secret',response.secret);
				    }
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
										  
		xhttp.open(form.getAttribute('method'),form.getAttribute('action'),true);
		xhttp.send(formData);
	}else{

	}
}

function updateDonateAmount(_node){
	_node.parentNode.nextElementSibling.style.display = _node.checked && _node.getAttribute('id') === 'amount-7' ? 'block' : 'none';

	if(parseInt(_node.value) > 0){
		/*var form = _node.parentNode.parentNode;
		var formData = new FormData();
		var xhttp = new XMLHttpRequest();

		formData.append('action','business_donation');
		formData.append('amount',_node.value);

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
				    	var response = JSON.parse(xhttp.response)
					}catch(e){
				   		var response = xhttp.response; 
				    }
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
										  
		xhttp.open(form.getAttribute('method'),form.getAttribute('action'),true);
		xhttp.send(formData);*/
	}
}

function submitDonateForm(_form){
	var formValidate = validateForm(_form);

	if(formValidate){
		var donateType = _form.querySelector('input[name="type"]:checked');
		var donateAmount = _form.querySelector('input[name="amount"]:checked');
		var donateCustom = _form.querySelector('input[name="custom_amount"]');

		if(donateType && donateAmount && donateAmount.value != 0 || donateType && donateAmount && donateAmount.value == 0 && donateCustom.value){
			var submitBtn = _form.querySelector('button');

			if(submitBtn){
				submitBtn.innerText = 'Please wait...';
				submitBtn.disabled = true;
			}

			var cardholderName = _form.querySelector('input[name="name"]').value;
			var cardholderEmail = _form.querySelector('input[name="email"]').value;
			var clientSecret = _form.querySelector('#stripe-form').getAttribute('data-secret');

			if(clientSecret){
				stripe.handleCardPayment(
				    clientSecret, cardElement, {
				      	payment_method_data: {
				        	billing_details: {
				        		name: cardholderName,
				        		email: cardholderEmail
				        	}
				      	}
				    }
				).then(function(result){
				    if(result.paymentIntent){
				    	var paymentIntent = document.createElement('input');    	

		        		paymentIntent.setAttribute('name','payment_intent');
		        		paymentIntent.setAttribute('type','hidden');
		        		paymentIntent.value = result.paymentIntent.id;
		        		_form.appendChild(paymentIntent);

		        		var formData = new FormData(_form);
		        		var xhttp = new XMLHttpRequest();

		        		xhttp.onreadystatechange = function(){
				            if(xhttp.readyState == 4){
				                if(xhttp.status === 200){
				                    try{
				                        var response = JSON.parse(xhttp.response)
				                    }catch(e){
				                        var response = xhttp.response; 
				                    }
				                    
				                    if(response.success){
				                    	var btn = _form.querySelector('button');

				                    	btn.innerText = 'Thank you';
				                    	btn.disabled = true;
				                    }else{
				                    	var error = response.error ? response.error : 'There was an error, please contact us! Error Code: 1147';

				                    	btn.innerText = 'Submit';
				                    	btn.removeAttribute('disabled');
				                    	alert(error);
				                    }
				                }else{
				                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
				                }
				            }
				        };

				        xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
			        	xhttp.send(formData);
				    }else{
				    	var error = result.error && result.error.message ? result.error.message : 'There was an error, please try again or contact us! Error Code: 1163';
				    	
				    	setTimeout(function(){
			    			alert(error);
			    		},250);
				    }
				});
			}else{
				var amount = donateAmount.value != 0 ? parseInt(donateAmount.value) : parseInt(donateCustom.value);

				if(amount > 0){
					var formData = new FormData();
					var xhttp = new XMLHttpRequest();

					formData.append('action','business_donation');
					formData.append('amount',amount);

					xhttp.onreadystatechange = function(){
						if(xhttp.readyState == 4){
							if(xhttp.status === 200){
								try{
							    	var response = JSON.parse(xhttp.response)
								}catch(e){
							   		var response = xhttp.response; 
							    }
							    
							    if(response.success){
							    	_form.querySelector('#stripe-form').setAttribute('data-secret',response.secret);
							    	submitDonateForm(_form)
							    }
							}else{
								throw 'invalid HTTP request: ' + xhttp.status + ' response';
							}
						}
					};
													  
					xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
					xhttp.send(formData);
				}
			}
		}else{
			alert('Please enter custom amount!');
		}
	}

	return false;
}

function submitBusinessForm(_form){
	var formValidate = validateForm(_form);

	if(formValidate){
		var submitBtn = _form.querySelector('button');

		if(submitBtn){
			submitBtn.innerText = 'Please wait...';
			submitBtn.disabled = true;
		}

		var formData = new FormData(_form);
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function(){
            if(xhttp.readyState == 4){
                if(xhttp.status === 200){
                    try{
                        var response = JSON.parse(xhttp.response)
                    }catch(e){
                        var response = xhttp.response; 
                    }
                    
                    if(response.success){
                    	var btn = _form.querySelector('button');

                    	btn.innerText = 'Thank you';
                    	btn.disabled = true;
                    }else{
                    	var error = response.error ? response.error : 'There was an error, please contact us! Error Code: 1239';

                    	btn.innerText = 'Submit';
		                btn.removeAttribute('disabled');
                    	alert(error);
                    }
                }else{
                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
                }
            }
        };

        xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
    	xhttp.send(formData);
	}

	return false;
}

function submitForm(_form){
	var formValidate = validateForm(_form);

	if(formValidate){
		var formBtn = _form.querySelector('button');
		var btnText = formBtn.innerText;
		var formData = new FormData(_form);
		var xhttp = new XMLHttpRequest();

		formBtn.innerText = 'Please wait...';
		formBtn.disabled = true;

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
				    	var response = JSON.parse(xhttp.response)
					}catch(e){
				   		var response = xhttp.response; 
				    }

				    var msg = response.error ? response.error : 'Updated Successfully!';

				    formBtn.innerText = btnText;
				    formBtn.removeAttribute('disabled');

				    if(response.success){
				    	var confirmMsg = _form.querySelector('input[name="confirm_msg"]');

				    	if(confirmMsg){
				    		formBtn.innerText = 'Thank you!';
				    		formBtn.disabled = true;
				    		alert(confirmMsg.value);
				    	}else{
				    		location.reload();
				    	}
				    }else{
				    	alert(msg);
				    }
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
										  
		xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
		xhttp.send(formData);
	}

	return false;
}

function updateAmount(_node){
	var valid = _node.validity.valid;

	if(valid){
		var form = _node.parentNode.parentNode;
		var email = form.querySelector('input[name="email"]');
		var formData = new FormData();
		var xhttp = new XMLHttpRequest();

		formData.append('action','business_donation');
		formData.append('amount',_node.value);

		if(_node.nextElementSibling.value !== ''){
			formData.append('payment_intent',_node.nextElementSibling.value);
		}

		if(email){
			formData.append('email',email.value);
		}

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
				    	var response = JSON.parse(xhttp.response)
					}catch(e){
				   		var response = xhttp.response; 
				    }

				    if(response.success){
				    	_node.nextElementSibling.nextElementSibling.value = response.intent;
				    	_node.nextElementSibling.nextElementSibling.nextElementSibling.setAttribute('data-secret',response.secret);
				    }
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
										  
		xhttp.open(form.getAttribute('method'),form.getAttribute('action'),true);
		xhttp.send(formData);
	}else{

	}
}

function validateForm(_form){
    var fields = _form.querySelectorAll('input[type="text"], input[type="number"], input[type="checkbox"], input[type="radio"], input[type="password"], input[type="email"], select, textarea');
    var totalFields = fields.length;
    var validForm = true;

    if(totalFields){
        for(var x=0;x<totalFields;x++){
        	var valid = fields[x].validity.valid;
			
			fields[x].className = valid ? '' : 'invalid';

			if(!valid && validForm){
            	fields[x].focus();
                validForm = !validForm;
            }
        }
    }

    return validForm
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function trackLink(_node){
	var url = _node.getAttribute('href');
	
	if(url){
		ga('send','event','outbound','click',url);
	}
}

function getCookie(_name) {
    var name = _name + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookies = decodedCookie.split(';');
    var totalCookies = cookies.length;
    
    for(var i=0;i <totalCookies;i++){
        var cookie = cookies[i];
        
        while(cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
    
        if(cookie.indexOf(name) == 0) {
            return cookie.substring(name.length,cookie.length);
        }
    }
    
    return '';
}

/* Toggles the drop down menus for funding, opportunities, and programs page */

function toggle(divName) {

  var div;
  var parentDiv = document.getElementById(divName);
  var childDivs = parentDiv.getElementsByClassName('column');

  for (i = 0; i < childDivs.length; i++ ) {

    div = childDivs[i];
    div.style.display = div.style.display == 'inline-block' ? 'none' : 'inline-block';
    
  }

  parentDiv.getElementsByClassName("fas")[0].className = div.style.display == 'inline-block' ? 'fas fa-angle-up' : 'fas fa-angle-down';

}