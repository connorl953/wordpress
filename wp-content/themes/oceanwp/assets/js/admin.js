var hoursUsed = document.querySelector('.hours-used');

if(hoursUsed){
	hoursUsed.currentPage = 1;
	hoursUsed.retrieveHours = function(){
		var container = this;
		var userId = container.getAttribute('data-user');
		var page = container.getAttribute('data-page');
		var limit = container.getAttribute('data-limit');
		var itemContainer = container.querySelector('.table .items');
		var formData = new FormData();
		var xhttp = new XMLHttpRequest();

		formData.append('action','retrieve_hours');
		formData.append('student_id',userId);
		formData.append('page',page);
		formData.append('limit',limit);
		itemContainer.innerHTML = '';
		itemContainer.nextElementSibling.innerHTML = '';
		itemContainer.className += ' loading';

		xhttp.onreadystatechange = function(){
            if(xhttp.readyState == 4){
                if(xhttp.status === 200){
                    try{
                        var response = JSON.parse(xhttp.response)
                    }catch(e){
                        var response = xhttp.response; 
                    }
                    
                    if(response.success){
                    	var hours = response.data;
                    	var totalHours = hours.length;
                    	
                    	if(itemContainer && totalHours){
                    		itemContainer.className = 'items';

                    		for(var x=0;x<totalHours;x++){
                    			var list = document.createElement('ul');
                    			var date = document.createElement('li');
                                var type = document.createElement('li');
                    			var hour = document.createElement('li');
                    			var description = document.createElement('li');
                    			var deleteIcon = document.createElement('i');
                                var editIcon = document.createElement('i');

                                list.setAttribute('data-id',hours[x].id);
                                list.setAttribute('data-payment',hours[x].payment);
                    			date.innerText = hours[x].created;
                                type.innerText = hours[x].type == 1 ? 'Session' : 'Research';
                    			hour.innerText = hours[x].hours;
                    			description.innerText = hours[x].description;
                    			deleteIcon.className = 'fa fa-times';
                                editIcon.className = 'fas fa-pencil-alt';
                    			list.appendChild(date);
                                list.appendChild(type);
                    			list.appendChild(hour);
                    			list.appendChild(description);
                                description.appendChild(editIcon);
                    			description.appendChild(deleteIcon);
                    			itemContainer.appendChild(list);

                                editIcon.setAttribute('data-id',hours[x].id);
                                editIcon.addEventListener('click',function(){
                                    var data = this.parentNode.parentNode;
                                    var modal = this.parentNode.parentNode.parentNode.parentNode.parentNode.nextElementSibling.nextElementSibling.nextElementSibling;
                                    var fields = modal.firstElementChild.firstElementChild.querySelectorAll('fieldset');
                                    var date = data.firstElementChild.innerText;
                                    var type = data.children[1].innerText;

                                    modal.className += ' open';
                                    fields[0].lastElementChild.value = date;
                                    fields[1].lastElementChild.value = data.children[2].innerText;
                                    fields[2].lastElementChild.value = data.children[3].innerText;

                                    if(type === 'Session'){
                                        fields[3].firstElementChild.checked = true;
                                    }else{
                                        fields[3].children[2].checked = true;
                                    }

                                    fields[4].lastElementChild.value = data.getAttribute('data-payment');
                                    fields[5].lastElementChild.value = data.getAttribute('data-id');
                                });
                    			deleteIcon.setAttribute('data-id',hours[x].id);
                    			deleteIcon.addEventListener('click',function(){
                    				var id = this.getAttribute('data-id');

                    				if(deleteIcon){
                    					var container = this.parentNode.parentNode.parentNode.parentNode.parentNode;
                    					var itemsContainer = container.querySelector('.table .items');
                    					var formData = new FormData();
										var xhttp = new XMLHttpRequest();

										formData.append('action','delete_hours');
										formData.append('id',id);

										itemsContainer.innerHTML = '';
										itemsContainer.className += ' loading';
										
										xhttp.onreadystatechange = function(){
								            if(xhttp.readyState == 4){
								                if(xhttp.status === 200){
								                    try{
								                        var response = JSON.parse(xhttp.response)
								                    }catch(e){
								                        var response = xhttp.response; 
								                    }

								                    if(response.success){
								                    	container.retrieveHours();
								                    }
								                }
								            }
								        }

								        xhttp.open('POST',ajaxurl,true);
    									xhttp.send(formData);
                    				}
                    			});
                    		}

                    		//pagination
                    		var list = document.createElement('ul');
                    		var limit = response.limit;
                    		var page = response.page;
                    		var total = response.total;
                    		var displayPages = 5;
                    		var totalPages = Math.ceil(total/limit);
                    		var pageDivider = Math.ceil(page/displayPages);
                    		var startPage = pageDivider > 1 ? (pageDivider * displayPages) - displayPages : 0;
                    		var pageLimit = startPage + displayPages < totalPages ? startPage + displayPages : totalPages;
                    		
                    		if(pageDivider > 1){
                    			var item = document.createElement('li');

                    			item.setAttribute('data-index',startPage);
                    			item.innerText = '<';
                    			list.appendChild(item);
                    			item.addEventListener('click',function(){
                    				var container = this.parentNode.parentNode.parentNode.parentNode;
                    				
                    				container.setAttribute('data-page',this.getAttribute('data-index'));
                    				container.retrieveHours()
                    			})
                    		}

                    		for(var x=startPage;x<pageLimit;x++){
                    			var item = document.createElement('li');

                    			item.setAttribute('data-index',x + 1);
                    			item.innerText = (x + 1);
                    			list.appendChild(item);
                    			item.addEventListener('click',function(){
                    				var container = this.parentNode.parentNode.parentNode.parentNode;
                    				
                    				container.setAttribute('data-page',this.getAttribute('data-index'));
                    				container.retrieveHours()
                    			})

                    			if(x + 1 === page){
                    				item.className = 'active';
                    			}
                    		}

                    		if(x < totalPages){
                    			var item = document.createElement('li');

                    			item.setAttribute('data-index',x + 1);
                    			item.innerText = '>';
                    			list.appendChild(item);
                    			item.addEventListener('click',function(){
                    				var container = this.parentNode.parentNode.parentNode.parentNode;
                    				
                    				container.setAttribute('data-page',this.getAttribute('data-index'));
                    				container.retrieveHours()
                    			})
                    		}

                    		itemContainer.nextElementSibling.appendChild(list);
                    	}else{
                    		itemContainer.className = 'items empty';
                    	}
                    }else{
                    	var msg = response.error ? response.error : 'There was an error, please try again or contact us!';
                    }
                }else{
                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
                }
            }
        };

        xhttp.open('POST',ajaxurl,true);
    	xhttp.send(formData);
	}

	hoursUsed.retrieveHours();
}

var paymentsList = document.querySelector('.payment-list');

if(paymentsList){
	paymentsList.currentPage = 1;
	paymentsList.retrievePayments = function(){
		var container = this;
		var userId = container.getAttribute('data-user');
		var page = container.getAttribute('data-page');
		var limit = container.getAttribute('data-limit');
		var itemContainer = container.querySelector('.table .items');
		var formData = new FormData();
		var xhttp = new XMLHttpRequest();

		formData.append('action','retrieve_payments');
		formData.append('student_id',userId);
		formData.append('page',page);
		formData.append('limit',limit);
		itemContainer.innerHTML = '';
		itemContainer.nextElementSibling.innerHTML = '';
		itemContainer.className += ' loading';

		xhttp.onreadystatechange = function(){
            if(xhttp.readyState == 4){
                if(xhttp.status === 200){
                    try{
                        var response = JSON.parse(xhttp.response)
                    }catch(e){
                        var response = xhttp.response; 
                    }
                    
                    if(response.success){
                    	var hours = response.data;
                    	var totalHours = hours.length;
                    	
                    	if(itemContainer && totalHours){
                    		itemContainer.className = 'items';

                    		for(var x=0;x<totalHours;x++){
                    			var list = document.createElement('ul');
                    			var id = document.createElement('li');
                    			var date = document.createElement('li');
                    			var hour = document.createElement('li');
                    			var used = document.createElement('li');
                    			var payment = document.createElement('li');
                    			var addBtn = document.createElement('i');
                                var deleteIcon = document.createElement('i');

                                id.innerText = hours[x].id;
                    			date.innerText = hours[x].created;
                    			hour.innerText = hours[x].hours;
                    			used.innerText = hours[x].hours_used;
                    			addBtn.className = 'far fa-clock';
                                deleteIcon.className = 'fa fa-times';
                                payment.setAttribute('data-id',hours[x].id);
                    			payment.innerText = hours[x].payment_amount;
                    			payment.appendChild(addBtn);
                                payment.appendChild(deleteIcon);
                    			list.appendChild(id);
                    			list.appendChild(date);
                    			list.appendChild(hour);
                    			list.appendChild(used);
                    			list.appendChild(payment);
                    			itemContainer.appendChild(list);

                                deleteIcon.addEventListener('click',function(e){
                                    e.preventDefault();

                                    var deletePayment = confirm('Are you sure you want to delete this payment?');

                                    if(deletePayment){
                                        var formData = new FormData();
                                        var xhttp = new XMLHttpRequest();

                                        formData.append('action','process_payment_deletion');
                                        formData.append('payment_id',this.parentNode.getAttribute('data-id'));

                                        xhttp.onreadystatechange = function(){
                                            if(xhttp.readyState == 4){
                                                if(xhttp.status === 200){
                                                    try{
                                                        var response = JSON.parse(xhttp.response)
                                                    }catch(e){
                                                        var response = xhttp.response; 
                                                    }
                                                    
                                                    if(response.success){
                                                        location.reload();
                                                    }
                                                }else{
                                                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
                                                }
                                            }
                                        };

                                        xhttp.open('POST',ajaxurl,true);
                                        xhttp.send(formData);
                                    }
                                });

                    			addBtn.addEventListener('click',function(){
                                    clearModalContent();

                    				var modal = this.parentNode.parentNode.parentNode.parentNode.parentNode.nextElementSibling;
                    				
                    				modal.className += ' open';
                    				modal.querySelector('input[name="payment_id"]').value = this.parentNode.parentNode.firstElementChild.innerText;
                    			});
                    		}

                    		//pagination
                    		var list = document.createElement('ul');
                    		var limit = response.limit;
                    		var page = response.page;
                    		var total = response.total;
                    		var displayPages = 5;
                    		var totalPages = Math.ceil(total/limit);
                    		var pageDivider = Math.ceil(page/displayPages);
                    		var startPage = pageDivider > 1 ? (pageDivider * displayPages) - displayPages : 0;
                    		var pageLimit = startPage + displayPages < totalPages ? startPage + displayPages : totalPages;
                    		
                    		if(pageDivider > 1){
                    			var item = document.createElement('li');

                    			item.setAttribute('data-index',startPage);
                    			item.innerText = '<';
                    			list.appendChild(item);
                    			item.addEventListener('click',function(){
                    				var container = this.parentNode.parentNode.parentNode.parentNode;
                    				
                    				container.setAttribute('data-page',this.getAttribute('data-index'));
                    				container.retrievePayments()
                    			})
                    		}

                    		for(var x=startPage;x<pageLimit;x++){
                    			var item = document.createElement('li');

                    			item.setAttribute('data-index',x + 1);
                    			item.innerText = (x + 1);
                    			list.appendChild(item);
                    			item.addEventListener('click',function(){
                    				var container = this.parentNode.parentNode.parentNode.parentNode;
                    				
                    				container.setAttribute('data-page',this.getAttribute('data-index'));
                    				container.retrievePayments()
                    			})

                    			if(x + 1 === page){
                    				item.className = 'active';
                    			}
                    		}

                    		if(x < totalPages){
                    			var item = document.createElement('li');

                    			item.setAttribute('data-index',x + 1);
                    			item.innerText = '>';
                    			list.appendChild(item);
                    			item.addEventListener('click',function(){
                    				var container = this.parentNode.parentNode.parentNode.parentNode;
                    				
                    				container.setAttribute('data-page',this.getAttribute('data-index'));
                    				container.retrievePayments()
                    			})
                    		}

                    		itemContainer.nextElementSibling.appendChild(list);
                    	}else{
                    		itemContainer.className = 'items empty';
                    	}
                    }else{
                    	var msg = response.error ? response.error : 'There was an error, please try again or contact us!';
                    }
                }else{
                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
                }
            }
        };

        xhttp.open('POST',ajaxurl,true);
    	xhttp.send(formData);
	}

	paymentsList.retrievePayments();
}

function addPayment(_node){
    _node.parentNode.parentNode.previousElementSibling.className += ' open';

    return false;
}

function submitPayment(_node){
    var fields = _node.parentNode.parentNode.querySelectorAll('fieldset input[type="number"], fieldset input[type="date"], fieldset input[type="hidden"], fieldset input[type="number"]');
    var totalFields = fields.length;

    if(totalFields){
        var validFields = true;

        for(var x=0;x<totalFields;x++){
            var fieldValue = fields[x].value;
            var isRequired = fields[x].required ? true : false ;
            
            if(fieldValue && isRequired || !fieldValue && !isRequired){
                fields[x].removeAttribute('class');
            }else{
                fields[x].className = 'invalid';

                if(validFields){
                    validFields = false;
                }
            }
        }

        if(validFields){
            var formData = new FormData();
            var xhttp = new XMLHttpRequest();

            formData.append('action','process_manual_payment');
            formData.append('date',fields[0].value);
            formData.append('hours',fields[1].value);
            formData.append('payment',fields[2].value);
            formData.append('student_id',fields[3].value);

            _node.disabled = true;
            _node.innerText = 'Please wait...';

            xhttp.onreadystatechange = function(){
                if(xhttp.readyState == 4){
                    if(xhttp.status === 200){
                        try{
                            var response = JSON.parse(xhttp.response)
                        }catch(e){
                            var response = xhttp.response; 
                        }
                        
                        if(response.success){
                            alert('Payment has been added!');
                            location.reload();
                        }else{
                            var error = response.error ? response.error : 'There was an error!';
                            alert(error);

                            _node.removeAttribute('disabled');
                            _node.innerText = 'Submit';
                        }
                    }else{
                        throw 'invalid HTTP request: ' + xhttp.status + ' response';
                    }
                }
            };

            xhttp.open('POST',ajaxurl,true);
            xhttp.send(formData);
        }
    }
}

function submitHours(_node){
	var fields = _node.parentNode.parentNode.querySelectorAll('fieldset input[type="number"], fieldset input[type="date"], fieldset input[type="hidden"], fieldset textarea, fieldset input[type="radio"]:checked');
	var totalFields = fields.length;

	if(totalFields){
		var validFields = true;

		for(var x=0;x<totalFields;x++){
			var fieldValue = fields[x].value;
            var isRequired = fields[x].required ? true : false ;

			if(fieldValue && isRequired || !isRequired){
				fields[x].removeAttribute('class');
			}else{
				fields[x].className = 'invalid';

				if(validFields){
					validFields = false;
				}
			}
		}
        
        if(validFields){
            var formData = new FormData();
    		var xhttp = new XMLHttpRequest();

    		formData.append('action','process_hours');
    		formData.append('date',fields[0].value);
    		formData.append('hours',fields[1].value);
    		formData.append('description',fields[2].value);
            formData.append('type',fields[3].value);
    		formData.append('payment_id',fields[4].value);
            formData.append('student_id',fields[5].value);

            if(fields[6].value){
                formData.append('hours_id',fields[6].value);
            }
            
    		_node.disabled = true;
    		_node.innerText = 'Please wait...';

    		xhttp.onreadystatechange = function(){
	            if(xhttp.readyState == 4){
	                if(xhttp.status === 200){
	                    try{
	                        var response = JSON.parse(xhttp.response)
	                    }catch(e){
	                        var response = xhttp.response; 
	                    }
	                   
	                    if(response.success){
	                    	alert(fields[1].value + ' hours used have been added!');
	                    	location.reload();
	                    }else{
	                    	var error = response.error ? response.error : 'There was an error!';
	                    	alert(error);

	                    	_node.removeAttribute('disabled');
	                    	_node.innerText = 'Submit';
	                    }
	                }else{
	                    throw 'invalid HTTP request: ' + xhttp.status + ' response';
	                }
	            }
	        };

	        xhttp.open('POST',ajaxurl,true);
        	xhttp.send(formData);
		}
	}
}

function selectImage(_node){
	if(_node){
		var mediaFrame;

		mediaFrame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image',
			button: {
				text: 'Use this image',
			},
			multiple: false
		});

		mediaFrame.on( 'select', function() {
			var mediaFile = mediaFrame.state().get('selection').first().toJSON();
			
			if(mediaFile){
				_node.previousElementSibling.setAttribute('data-add',1);
				_node.previousElementSibling.style.background = 'url(\''+mediaFile.url+'\') no-repeat center center/contain #FFF';
				_node.nextElementSibling.value = mediaFile.url;
			}
		});

		mediaFrame.open();
	}else{

	}

	return false;
}

function clearModalContent(){
    var modals = document.querySelectorAll('.modal');
    var totalModals = modals.length;

    if(totalModals){
        for(var x=0;x<totalModals;x++){
            var modalFields = modals[x].querySelectorAll('input[type="text"], input[type="date"], input[type="number"], textarea');
            var totalModalFields = modalFields.length;

            if(totalModalFields){
                for(var y=0;y<totalModalFields;y++){
                    modalFields[y].value = '';
                }
            }
        }
    }
}


function selectFeaturedImage(_node){
    var isLinkNode = _node.nodeName === 'A' ? true : false;
    var container = _node.parentNode.parentNode;
    var selectImage = isLinkNode && _node.getAttribute('data-add') == 0 || _node.nodeName === 'IMG' ? true : false;

    if(selectImage){
        var mediaFrame;
        
        mediaFrame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image',
            button: {
                text: 'Use this image',
            },
            multiple: false
        });

        mediaFrame.on( 'select', function() {
            var mediaFile = mediaFrame.state().get('selection').first().toJSON();
            
            if(mediaFile){
                var featuredImage = container.querySelector('img');

                if(!featuredImage){
                    var featuredImage = document.createElement('img');

                    featuredImage.style.width = '100%';
                    featuredImage.setAttribute('onclick','return selectFeaturedImage(this)');
                }

                if(container.className.indexOf('has-featured') === -1){
                    container.className += ' has-featured';
                }

                if(isLinkNode){
                    _node.setAttribute('data-add',1);
                    _node.innerText = 'Remove featured image';
                }

                featuredImage.setAttribute('src',mediaFile.url);
                container.firstElementChild.insertBefore(featuredImage,container.firstElementChild.lastElementChild);
                container.querySelector('input[type="hidden"]').value = mediaFile.url;
            }
        });

        mediaFrame.open();
    }else{
        var featuredImage = container.querySelector('img');

        featuredImage.parentNode.removeChild(featuredImage);
        container.className = container.className.replace(' has-featured','');
        container.querySelector('input[type="hidden"]').value = '';
        _node.innerText = 'Set featured image';
        _node.setAttribute('data-add',0);
    }

    return false;
}

function selectImage(_node){
    var isButton = _node.nodeName === 'INPUT' ? true : false;
    var selectImage = !isButton || isButton && _node.getAttribute('data-add') != 1 ? true : false;
    
    if(isButton && selectImage || !isButton){
        var mediaFrame;

        mediaFrame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image',
            button: {
                text: 'Use this image',
            },
            multiple: false
        });

        mediaFrame.on( 'select', function() {
            var mediaFile = mediaFrame.state().get('selection').first().toJSON();
            
            if(mediaFile){
                _node.parentNode.className = 'form-input has-image';
                _node.parentNode.children[1].value = 'Remove Image';
                _node.parentNode.children[1].setAttribute('data-add',1);
                _node.parentNode.firstElementChild.style.background = 'url(\''+mediaFile.url+'\') no-repeat center center/cover';
                _node.parentNode.lastElementChild.value = mediaFile.url;
            }
        });

        mediaFrame.open();
    }else{
        _node.parentNode.className = 'form-input';
        _node.parentNode.children[1].value = 'Select Image';
        _node.parentNode.children[1].setAttribute('data-add',0);
        _node.parentNode.firstElementChild.style.background = '#efefef';
        _node.parentNode.lastElementChild.value = '';
}

    return false;
}