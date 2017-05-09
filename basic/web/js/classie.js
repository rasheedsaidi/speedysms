/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) { console.log(document.documentElement);
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

function getLabel(label) {
	switch(label) {
		case 'q1': 
			return 'What\'s the kind of job?';
			break;
		case 'q2': 
			return 'Enter your name';
			break;
		case 'q3': 
			return 'Enter your phone number';
			break;
		case 'q4': 
			return 'Enter your email';
			break;
		case 'q5': 
			return 'Now your comment?';
			break;
		case 'q6': 
			return 'What\'s the kind of job?';
			break;
		case 'q7': 
			return 'Enter your name';
			break;
		case 'q8': 
			return 'Enter your phone number';
			break;
		case 'q9': 
			return 'Enter your email';
			break;
		case 'q10': 
			return 'Time to contact you?';
			break;
		case 'q11': 
			return 'Now your comment?';
			break;
		case 'q12': 
			return 'Enter your name';
			break;
		case 'q13': 
			return 'Enter your phone number';
			break;
		case 'q14': 
			return 'Enter your qualification';
			break;
		case 'q15': 
			return 'Enter your years of experience';
			break;
		case 'q16': 
			return 'Enter your email';
			break;
		case 'q17': 
			return 'Enter your first name';
			break;
		case 'q18': 
			return 'Enter your last name';
			break;
		case 'q19': 
			return 'Enter your phone number';
			break;
		case 'q20': 
			return 'Enter your email';
			break;
		case 'q21': 
			return 'What\'s your Skype ID?';
			break;
		case 'q22': 
			return 'What\'s your Whatsapp number?';
			break;
		default:
			return label;
	}
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  getLabel: getLabel,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass,
  label: getLabel
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );
