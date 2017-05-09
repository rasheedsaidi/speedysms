/**
 * stepsForm.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {
	
	'use strict';

	var transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function extend( a, b ) {
		for( var key in b ) { 
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function stepsForm( el, options ) {
		this.el = el;
		this.options = extend( {}, this.options );
  		extend( this.options, options );
  		this._init();
	}

	stepsForm.prototype.options = {
		onSubmit : function() { return false; }
	};

	stepsForm.prototype._init = function() {
		// current question
		this.current = 0;

		// questions
		this.questions = [].slice.call( this.el.querySelectorAll( 'ol.questions > li' ) );
		// total questions
		this.questionsCount = this.questions.length;
		// show first question
		classie.addClass( this.questions[0], 'current' );
		
		// next question control
		this.ctrlNext = this.el.querySelector( 'button.next' );

		// submit button control
		this.submitButton = this.el.querySelector( 'button.submit' );
		
		// cancel button control
		this.cancelButton = this.el.querySelector( 'button.cancel' );
		
		// progress bar
		this.progress = this.el.querySelector( 'div.progress' );
		
		// question number status
		this.questionStatus = this.el.querySelector( 'span.number' );
		// current question placeholder
		this.currentNum = this.questionStatus.querySelector( 'span.number-current' );
		this.currentNum.innerHTML = Number( this.current + 1 );
		// total questions placeholder
		this.totalQuestionNum = this.questionStatus.querySelector( 'span.number-total' );
		this.totalQuestionNum.innerHTML = this.questionsCount;

		// error message
		this.error = this.el.querySelector( 'span.error-message' );
		
		// init events
		this._initEvents();
	};

	stepsForm.prototype._initEvents = function() {
		var self = this,
			// first input
			firstElInput = this.questions[ this.current ].querySelector( 'input' ),
			// focus
			onFocusStartFn = function() {
				firstElInput.removeEventListener( 'focus', onFocusStartFn );
				classie.addClass( self.ctrlNext, 'show' );
			};

		// show the next question control first time the input gets focused
		firstElInput.addEventListener( 'focus', onFocusStartFn );

		// show next question
		this.ctrlNext.addEventListener( 'click', function( ev ) { 
			ev.preventDefault();
			self._nextQuestion(); 
		} );
		
		// show preview
		this.submitButton.addEventListener( 'click', function( ev ) { 
			ev.preventDefault();
			self._submit(); 
		} );
		
		// cancel form
		this.cancelButton.addEventListener( 'click', function( ev ) { 
			ev.preventDefault();
			self._cancel(); 
		} );

		// pressing enter will jump to next question
		document.addEventListener( 'keydown', function( ev ) {
			var keyCode = ev.keyCode || ev.which;
			// enter
			if( keyCode === 13 ) {
				ev.preventDefault();
				self._nextQuestion();
			}
		} );

		// disable tab
		this.el.addEventListener( 'keydown', function( ev ) {
			var keyCode = ev.keyCode || ev.which;
			// tab
			if( keyCode === 9 ) {
				ev.preventDefault();
			} 
		} );
	};

	stepsForm.prototype._nextQuestion = function() {
		if( !this._validade() ) {
			return false;
		}

		// check if form is filled
		if( this.current === this.questionsCount - 1 ) {
			this.isFilled = true;
		}

		// clear any previous error messages
		this._clearError();

		// current question
		var currentQuestion = this.questions[ this.current ];

		// increment current question iterator
		++this.current;

		// update progress bar
		this._progress();

		if( !this.isFilled ) {
			// change the current question number/status
			this._updateQuestionNumber();

			// add class "show-next" to form element (start animations)
			classie.addClass( this.el, 'show-next' );

			// remove class "current" from current question and add it to the next one
			// current question
			var nextQuestion = this.questions[ this.current ];
			classie.removeClass( currentQuestion, 'current' );
			classie.addClass( nextQuestion, 'current' );
		}

		// after animation ends, remove class "show-next" from form element and change current question placeholder
		var self = this,
			onEndTransitionFn = function( ev ) {
				if( support.transitions ) {
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				if( self.isFilled ) {
					self._preview();
				}
				else {
					classie.removeClass( self.el, 'show-next' );
					self.currentNum.innerHTML = self.nextQuestionNum.innerHTML;
					self.questionStatus.removeChild( self.nextQuestionNum );
					// force the focus on the next input
					nextQuestion.querySelector( 'input' ).focus();
				}
			};

		if( support.transitions ) {
			this.progress.addEventListener( transEndEventName, onEndTransitionFn );
		}
		else {
			onEndTransitionFn();
		}
	}

	// updates the progress bar by setting its width
	stepsForm.prototype._progress = function() {
		this.progress.style.width = this.current * ( 100 / this.questionsCount ) + '%';
	}

	// changes the current question number
	stepsForm.prototype._updateQuestionNumber = function() {
		// first, create next question number placeholder
		this.nextQuestionNum = document.createElement( 'span' );
		this.nextQuestionNum.className = 'number-next';
		this.nextQuestionNum.innerHTML = Number( this.current + 1 );
		// insert it in the DOM
		this.questionStatus.appendChild( this.nextQuestionNum );
	}

	// submits the form
	stepsForm.prototype._submit = function() { //alert('toSubmit: ');
		if (this._validadeAll(this.el) === false) return false;
		this.options.onSubmit( this.el );
	}
	
	// previews the form
	stepsForm.prototype._preview = function() {
		this.options.onPreview( this.el );
	}
	
	stepsForm.prototype._cancel = function() {
		location.reload(true);
	}

	// TODO (next version..)
	// the validation function
	stepsForm.prototype._validade = function() {
		// current question´s input
		if (this.isFilled) {
			return true;
		}
		
		//var input = this.questions[ this.current ].querySelector( 'input' ).value;
		
		var input = this.questions[ this.current ].querySelector( 'input' );
		if (input.hasAttribute('data-validate')) {
			switch (input.getAttribute('data-validate')) {
				case 'none' :
					// there's no validation in this field, moving on
					break;
				case 'email' :
					if (!this._validateEmail(input.value)) {
						this._showError( 'INVALIDEMAIL' );
						return false;
					}
					break;
				case 'phone' :
					if (!this._validatePhone(input.value)) {
						this._showError( 'INVALIDPHONE' );
						return false;
					}
					break;
				case 'name' :
					if (!this._validateName(input.value)) {
						this._showError( 'INVALIDNAME' );
						return false;
					}
					break;
			}
		} else {
			if( input.value === '' ) {
				this._showError( 'EMPTYSTR' );
				return false;
			}
 		}
 
 		return true;
		
		/*
		if( input === '' ) {
			this._showError( 'EMPTYSTR' );
			return false;
		}

		return true;
		*/
	}
	
	stepsForm.prototype._validate = function(field) {		
		
		//var input = this.questions[ this.current ].querySelector( 'input' ).value;
		
		var input = field;
		if (input.hasAttribute('data-validate')) {
			switch (input.getAttribute('data-validate')) {
				case 'none' :
					// there's no validation in this field, moving on
					break;
				case 'email' :
					if (!this._validateEmail(input.value)) {
						//this._showError( 'INVALIDEMAIL' );
						return false;
					}
					break;
				case 'phone' :
					if (!this._validatePhone(input.value)) {
						//this._showError( 'INVALIDPHONE' );
						return false;
					}
					break;
				case 'name' :
					if (!this._validateName(input.value)) {
						//this._showError( 'INVALIDNAME' );
						return false;
					}
					break;
			}
		} else {
			if( input.value === '' ) {
				//this._showError( 'EMPTYSTR' );
				return false;
			}
 		}
 
 		return true;
	}
	
	stepsForm.prototype._validadeAll = function(d) { console.log(d.querySelectorAll( 'input.preview_right' ));
		//var input = this.questions.querySelector( 'input' );
		var res;
		//d.querySelectorAll( 'input' ).each(function(key, value){			
			//res = this._validate(value);
		//});
		var test = [];
		var list = d.querySelectorAll( 'input.preview_right' );
		for (var i = 0; i < list.length; ++i) {
		  res = this._validate(list[i]);
		  test.push(res);
		  //console.log(list[i].value + ' is ' + res);
		}
		console.log(test);
		if ($.inArray(false, test) != -1) {
			alert('Please fill in all required fields');
			return false;
		} else {
			//alert('go: ' + $.inArray(false, test));
			return true;
		}
		
		console.log(res);
		
	}

	// TODO (next version..)
	stepsForm.prototype._showError = function( err ) {
		var message = '';
		switch( err ) {
			case 'EMPTYSTR' : 
				message = 'Please fill the field before continuing';
				break;
			case 'INVALIDEMAIL' : 
				message = 'Please fill a valid email address';
				break;
			case 'INVALIDPHONE' : 
				message = 'Please fill a valid phone number';
				break;
			case 'INVALIDNAME' : 
				message = 'Please fill a valid name';
				break;
			// ...
		};
		this.error.innerHTML = message;
		classie.addClass( this.error, 'show' );
	}

	// clears/hides the current error message
	stepsForm.prototype._clearError = function() {
		classie.removeClass( this.error, 'show' );
	}
	
	// email validation /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/
	stepsForm.prototype._validateEmail = function( email ) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
		return regex.test(email);
	}
	
	// name validation 
	stepsForm.prototype._validateName = function( name ) {
		var regex = /^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/;
		return regex.test(name);
	}
	
	// phone no validation \d{3,5}
	stepsForm.prototype._validatePhone = function( phone ) {
		//var regex = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
		//var regex = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i;
		
		var regex = /^\d{6}\d{0,6}$/;
		return regex.test(phone);
	}

	// add to global namespace
	window.stepsForm = stepsForm;

})( window );