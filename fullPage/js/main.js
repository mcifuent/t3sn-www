var myConfig = {};
myConfig.sections = [];








function getSectionColors () {
	myreturn = [];
	$(myConfig.sections).each(function (key,val) {
		
		myreturn.push(val.color);
		
		
	}); 
	return myreturn;
}


function getSectionIds () {
	myreturn = [];
	$(myConfig.sections).each(function (key,val) {
		
		myreturn.push(val.id);
		
		
	}); 
	return myreturn;
}


function setSection (id,color,category,question, maxpoints, input) {
myConfig.sections.push({"id":id, "color":color, "category":category, "question":question, "maxpoints":maxpoints, "input":input});	
}

function getSectionsHMTL () {
myReturn = "";	
	$(myConfig.sections).each(function(key, val) {
		
	
    
    if (key == 0 )  {	
	prev = false;
	}
	else{
	prev = myConfig.sections[key - 1];	
	}
	
	if (myConfig.sections.length -1  == key )  {	next = false; }
	else {
	next = myConfig.sections[key  + 1];		
		
	}
		
	myReturn +=	mySectionHTML(val.id,val.color, val.category, val.question, val.maxpoints, val.input, prev,next);
		
	
	}); 
return myReturn; 	
	
}

function mySectionHTML (id,color,category,question,maxpoints, input,  prev,next) {
myPrev="";
if (prev) myPrev = '<div class="scroll-icon-top">\
               <a href="#'+prev.id+'/0" class="icon-up-open-big">vor</a>\
        </div>';	
myNext="";
if (next) {

myNext = '<div class="scroll-icon">\
        <a href="#'+next.id+'/1" class="icon-up-open-big"></a>\
        </div>';			
}
myNext="";

myCategory = '';
if (category) {
myCategory = '<h3>'+category+'</h3>';	
}

myQuestion = '';
if (question) {
myQuestion = '<h2>'+question+'</h2>';	
}

myMaxPoints = '';
mySwitch = "Punkten";
if (maxpoints) {
	if (maxpoints == 1 ) mySwitch = "Punkt";
myMaxPoints = ' <h4> <span contenteditable="true" style="margin-right:5px; font-size:1.3em; padding: 2px; " ></span>    von '+maxpoints+' ' + mySwitch +'</h4>';	
}

myInput = "";
myInputType = 'contenteditable="true"';
if (input) {
myInputType = 'contenteditable="false"';	
myInput = 	input;
}


return '<section class="vertical-scrolling"><div class="horizontal-scrolling">'+ myCategory+ myQuestion+ '\
				<div id="'+id+'-inputdiv" class="input1" '+ myInputType + '>'+ myInput+  ' </div>\
' +myMaxPoints  +			myNext+
      '     </div> <div class="horizontal-scrolling">'+ myCategory+ myMaxPoints  + myQuestion+ '\
				<div id="'+id+'-inputdiv" class="input1" '+ myInputType + '>'+ myInput+  ' </div>\
'+			myNext+
      '     </div></section>'; 
	
/*return '<section class="vertical-scrolling">  <div class="horizontal-scrolling">\
          <h2>fullPage.js</h2>\
          <h3>This is the fifth section and it contains the first slide (actually section == first slide)</h3>\
        </div>\
        <div class="horizontal-scrolling">\
          <h2>fullPage.js</h2>\
          <h3>This is the second slide</h3> \
          <p class="end">Thank you!</p>\
        </div>   </section>'; */
	
     	
}

$(document).ready(function(){
	

	

	setSection('eins','lightblue','Aufwärmung', 'Bitte füllen Sie folgendes Formular aus.', false, '<table width="100%" style="text-align: left" contenteditable="false"><tr ><td width="10%" >Name</td><td contenteditable="true"></td></tr> <tr><td >Klasse</td><td  contenteditable="true"></td></tr></table>');
  setSection('zwei','lightgrey','Allgemeines Wissen', 'Geben Sie an, mit welcher Funktion es möglich ist.', 1);
   setSection('drei','red');
    setSection('vier','orange');
  
  
  // variables
  var $header_top = $('.header-top');
  var $nav = $('nav');



  // toggle menu 
  $header_top.find('a').on('click', function() {
    $(this).parent().toggleClass('open-menu');
  });


  
  $('#fullpage2').html(getSectionsHMTL());
  
 /** CONTENTEDITABLE 	**/
 
  
  
			  $('[contenteditable=true]').focusin(function() {
				
			
				
				
				
				$.fn.fullpage.setKeyboardScrolling(false);  

				  
			  });
  
  myGlobalErrorCounter = 0;
  
  
			$('[contenteditable=true]').focusout(function(e) {
				
				if ($(this).attr('data-mandatory') == "true" ) {
				if ( $(this).text().length < 3 ) {
					
					
				if (!$(this).attr('data-mandatory-warning') || $(this).attr('data-mandatory-warning') =="false" ) { 		myGlobalErrorCounter++; 
				 $(this).attr('data-mandatory-warning', "true");
				}
							
				
					$(this).css('background-color','lightcoral'); 
				$.fn.fullpage.setAllowScrolling(false, 'up');
				$.fn.fullpage.setAllowScrolling(false, 'down');
			 
				$('a').fadeOut(200);
				
				//alert('Dies ist ein Pflichtfeld'); 
				
				
				
				}
			
			else {
				if ($(this).attr('data-mandatory-warning') && $(this).attr('data-mandatory-warning') =="true" ) { 		
				myGlobalErrorCounter--; 
				 $(this).attr('data-mandatory-warning', "false");
				}
				
			$(this).css('background-color','transparent'); 
			   // alert($loadedSection.find('[data-mandatory="true"]:last').text().length);
				if (myGlobalErrorCounter == 0 && $loadedSection.find('[data-mandatory="true"]:last').text().length > 2 ) {
					 $.fn.fullpage.setAllowScrolling(true, 'up');
					 $.fn.fullpage.setAllowScrolling(true, 'down');
					
					 $('a').show();
				}
				$.fn.fullpage.setKeyboardScrolling(true);  
			}
				}
				
				else {
					$.fn.fullpage.setKeyboardScrolling(true);  
				}
			  
		  });
		  
  
  	/** Problembehebung TAB 	**/

	$('a, input, select, textarea, [contenteditable=true]').attr('tabindex', -1);

	var $loadedSection;
/** Problembehebung TAB 	**/

  // fullpage customization
  $('#fullpage2').fullpage({
    sectionsColor: getSectionColors(),
    sectionSelector: '.vertical-scrolling',
    slideSelector: '.horizontal-scrolling',
    navigation: true,
    slidesNavigation: true,
    css3: true,
    controlArrows: false,
    anchors: getSectionIds(),
    menu: '#menu',

    afterLoad: function(anchorLink, index) {
		
		
		$('.l-left').html(parseInt (index) + '/' + myConfig.sections.length );
		
		if(index - 1 > 0) {
		$('.l-center').html( ' <div class="scroll-icon-top">\
        <a href="#'+myConfig.sections[index - 2].id+'/0" class="icon-down-open-big"></a>\
        </div>'   ); }
		else {
		$('.l-center').html( '' ); 	
		}
		
		
		if(index  <  myConfig.sections.length) {
		$('.l-center-bottom').html( ' <div class="scroll-icon">\
        <a href="#'+myConfig.sections[index].id+'/0" class="icon-up-open-big"></a>\
        </div>'   ); }
		else {
		$('.l-center-bottom').html( '' ); 	
		}
		
		
		
		$loadedSection = $(this);

		//if( $loadedSection.hasClass('form-section') ){
			$loadedSection.find('a, input, select, textarea, [contenteditable=true]').removeAttr("tabindex");
		//}
		
		$loadedSection.find('[data-mandatory="true"]:first').focus();
		//alert($loadedSection.find('[data-mandatory="true"]').size());
		if($loadedSection.find('[data-mandatory="true"]').size() > 0 && $loadedSection.find('[data-mandatory="true"]').text().length < 3 ) {
			$.fn.fullpage.setAllowScrolling(false, 'up');
			$.fn.fullpage.setAllowScrolling(false, 'down');
			$('a').fadeOut(200);
			
		}
     /* $header_top.css('background', 'rgba(0, 47, 77, .3)');
      $nav.css('background', 'rgba(0, 47, 77, .25)');
      if (index == 5) {
          $('#fp-nav').hide();
        } */
    },

    onLeave: function(index, nextIndex, direction) {
		
		
		
		//if( $loadedSection.hasClass('form-section') ){
		$loadedSection.find('a, input, select, textarea, [contenteditable=true]').attr('tabindex', -1);
	//}
		
		
      if(index == 5) {
        $('#fp-nav').show();
      }
    },

    afterSlideLoad: function( anchorLink, index, slideAnchor, slideIndex) {
      /*if(anchorLink == 'fifthSection' && slideIndex == 1) {
        $.fn.fullpage.setAllowScrolling(false, 'up');
        $header_top.css('background', 'transparent');
        $nav.css('background', 'transparent');
        $(this).css('background', '#374140');
        $(this).find('h2').css('color', 'white');
        $(this).find('h3').css('color', 'white');
        $(this).find('p').css(
          {
            'color': '#DC3522',
            'opacity': 1,
            'transform': 'translateY(0)'
          }
        );
      }*/
    },

    onSlideLeave: function( anchorLink, index, slideIndex, direction) {
      /*if(anchorLink == 'fifthSection' && slideIndex == 1) {
        $.fn.fullpage.setAllowScrolling(true, 'up');
        $header_top.css('background', 'rgba(0, 47, 77, .3)');
        $nav.css('background', 'rgba(0, 47, 77, .25)');
      } */
    } 
  }); 
  
  

  
 
  
});