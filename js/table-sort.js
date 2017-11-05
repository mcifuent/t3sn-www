inittable = function(div) {
	
	$(div).find('[oldnr]').each(function() {
		
		$(this).find('td:first').click(function() {
		
		$(this).parents('tr:first').find('.nosolution').toggle(330);
		
		
	});
		
	});
	
	
	
	
			$(div).find('.nosolution, .solution').click(function(e) {
		
			var myNewVar = $.extend(true, {}, myVar);	 
				
				 
	 
	 
	 var mynr;
	 if ($(this).attr('class') == 'nosolution' ) {
		 mynr= $(this).attr('mynr');
		 $(this).parents('td:first').find('.solution').attr('class','nosolution').show();
		 $(this).parents('td:first').find('.glyphicon-ok').attr('class','placeholder');
		$(this).attr('class','solution'); 
		$(this).find('span').attr('class','glyphicon glyphicon-ok');
		myNewVar.fragen[parseInt($(this).parents('[oldnr]:first').attr('oldnr'))].choicetype="question";
		 
	 }
	 else {
		 mynr= "";
		 myNewVar.fragen[parseInt($(this).parents('[oldnr]:first').attr('oldnr'))].choicetype="survey";
		$(this).find('span').attr('class','placeholder');
		$(this).attr('class','nosolution').show(); 
		$(this).parents('td:first').find('.nosolution').show();
		
	 }
   // $(this).show();
//	 myVar.fragen[parseInt($(this).parents('[oldnr]:first').attr('oldnr'))].solution = $(this).attr('mynr') ;
	

	myNewVar.fragen[parseInt($(this).parents('[oldnr]:first').attr('oldnr'))].solution = mynr;
   // console.log(myNewVar);
	//myVar = $.extend(true, {}, myNewVar);
	saveQuestion(function(){null;}, myNewVar);
	myinitbody(myStartFrage);
		
	});
	

	
		$(div).find('.glyphicon-eye-open').click(function(e) {
	 $('.nosolution').toggle(300);

		
	});
	
	
	$(div).find('.glyphicon-trash').click(function(e) {

	var result= confirm ('Möchten Sie die Frage ' + $(this).parents('tr:first').find('td:first').text() + ' wirklich löschen?'	 );
	if (result == true) {
		
	var myOldVarX = $.extend(true, {}, myVar);
	var myNewVarX = $.extend(true, {}, myVar);
	var myNr = $(this).parents('tr:first').attr('oldnr');
	$(this).parents('tr:first').remove();
    var counter = 0;
	  
	    $('[oldnr]').each(function() {
//console.log(counter + '--' + $(this).attr('oldnr') + myOldVar.fragen[$(this).attr('oldnr')].head);		
		myNewVarX.fragen[counter] = myOldVarX.fragen[$(this).attr('oldnr')];
	
		$(this).attr('oldnr', counter);
		counter++;
		 
		 
	 });
	// console.log(myNewVar);
	 myNewVarX.fragen.pop();
	 //console.log(myNewVar);
	saveQuestion(function(){null;},myNewVarX);
	}
		
	});
	
	// Sortable rows
	var oldIndex;
	
$(div).find('.sorted_table').sortable({
  containerSelector: 'table',
  itemPath: '> tbody',
  itemSelector: 'tr',
  placeholder: '<tr class="placeholder"/>',
  onDragStart: function($item, container, _super) {
	  
	oldIndex = $item.index();
	  
  },
  onDrop: function($item, container, _super) {
	  var newIndex = $item.index();
	  var counter = 0;
	  var myOldVar = $.extend(true, {}, myVar);
	   var myNewVar = $.extend(true, {}, myVar);
	 $('[oldnr]').each(function() {
//console.log(counter + '--' + $(this).attr('oldnr') + myOldVar.fragen[$(this).attr('oldnr')].head);		
		
		myNewVar.fragen[counter] = myOldVar.fragen[$(this).attr('oldnr')];
		$(this).attr('oldnr', counter);
		counter++;
		 
		 
	 });
	 saveQuestion(function(){null;},myNewVar);
	 myinitbody(myStartFrage);
  }
});

// Sortable column heads
var oldIndex;
$(div).find('.sorted_head tr').sortable({
  containerSelector: 'tr',
  itemSelector: 'th',
  placeholder: '<th class="placeholder"/>',
  vertical: false,
  onDragStart: function ($item, container, _super) {
    oldIndex = $item.index();
    $item.appendTo($item.parent());
    _super($item, container);
  },
  onDrop: function  ($item, container, _super) {
    var field,
	        newIndex = $item.index();
var oldMyVar;
    if(newIndex != oldIndex) {
      $item.closest('table').find('tbody tr').each(function (i, row) {
        row = $(row);
        if(newIndex < oldIndex) {
          row.children().eq(newIndex).before(row.children()[oldIndex]);
        } else if (newIndex > oldIndex) {
          row.children().eq(newIndex).after(row.children()[oldIndex]);
        }

      });
	 
	}
    

	 
    _super($item, container);
  }
});
	
}


	
	
	
	
