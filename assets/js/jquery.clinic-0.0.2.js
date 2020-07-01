// JavaScript Document
$(document).ready(function(){
	$('#loaderFrame').load(function(){
            var w = (this.contentWindow || this.contentDocument.defaultView);
            w.print();
			//setTimeout("closePrintView()", 3000);
			setTimeout(function () {
  				w.close();
				parent.location.reload();
				//alert('cerrado');
			}, 500);
		
		
	});
	$('.printerButton').click(function(){
		var id = $(this).attr("data-id");
		var src = $(this).attr("data-rel");
		var val = $(this).attr("data-val");
		$('#loaderFrame').attr('src', src+'?id='+id+'&val='+val);
	});
	function closePrintView() {
        //document.location.href = 'somewhere.html';
		parent.location.reload();
    }
});