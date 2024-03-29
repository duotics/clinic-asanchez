<!--LIBS JS-->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZn ?>bootstrap/dist/js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $RAIZa ?>js/chosen.jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/chosen_v1.7.0/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/tablesorter.2.0.5/jquery.tablesorter.min.js"></script>
<!-- Load TinyMCE -->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/tinymce/tinymce.min.js"></script>
<!--script src='<?php echo $RAIZa ?>js/readmore.min.js'></script>-->
<!-- Add fancyBox JS -->
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox-v3.5.7/jquery.fancybox.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
-->
<!-- GRITTER -->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery.gritter.min.js"></script>
<!--FULL CALENDAR-->
<script src='<?php echo $RAIZa ?>plugins/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo $RAIZa ?>plugins/fullcalendar/fullcalendar.min.js'></script>
<script src='<?php echo $RAIZa ?>plugins/fullcalendar/lang-all.js'></script>
<!--Personal Libs -->
<script type="text/javascript" src="<?php echo $RAIZa ?>js/jquery.clinic-0.0.2.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(window).bind('keydown', function(event) {
			if (event.ctrlKey || event.metaKey) {
				switch (String.fromCharCode(event.which).toLowerCase()) {
					case 's':
						event.preventDefault();
						if ($("#vAcc").length > 0) {
							$("#vAcc").click();
						} else {
							alert("No Existe Boton de Accion");
						}
						break;
						/* case 'f': event.preventDefault(); alert('ctrl-f'); break;
						case 'g': event.preventDefault(); alert('ctrl-g'); break; */
				}
			}
		});
		//Verify Acction SAVE Buttons DATABASE - original
		$('#vAcc').on('click', function() {
			var $btn = $(this).button('loading');
			if (confirm('Esta seguro ?') == true) {
				$('form').submit();
			} else {
				$btn.button('reset');
			}
		});
		//Verify Action of button, submit in a List interface (table tr td list)
		$('.vAccM').on('click', function(e) {
			var $btn = $(this).button('loading');
			var paramTit = $(this).attr('data-title');
			var paramText = $(this).attr('data-text');
			if (!paramTit) paramTit = 'Esta seguro ?';
			if (!paramText) paramText = '';
			var r = confirm(paramTit);
			if (r == true) {
				$('form').submit();
			} else {
				e.preventDefault();
				$btn.button('reset');
			}
		});
		$('.vAccTM').on('click', function(e) {
			var $btn = $(this).button('loading');
			var paramTit = $(this).attr('data-title');
			var paramText = $(this).attr('data-text');
			var r = confirm(paramTit);
			if (r == true) {
				$('form').submit();
			} else {
				e.preventDefault();
				$btn.button('reset');
			}
		});
		//Verify Accion for a LINK
		$('.vAccL').on('click', function(e) {
			var link = this;
			var paramTit = $(this).attr('data-title');
			var paramText = $(this).attr('data-text');
			if (!paramTit) paramTit = 'Esta seguro ?';
			if (!paramText) paramText = 'Precaución!'
			e.preventDefault();
			$("<div>" + paramText + "</div>").dialog({
				title: paramTit,
				buttons: {
					"Aceptar": function() {
						$(this).dialog("close");
						window.location = link.href;
					},
					"Cancelar": function() {
						$(this).dialog("close");
					}
				},
				show: {
					effect: "blind",
					duration: 400
				},
				minWidth: 350
			});
		});

		//Verify Action show dialog html

		$('.vAccT').on('click', function(e) {

			var link = this;

			var paramTit = $(this).attr('data-title');

			var paramText = $(this).attr('data-text');

			e.preventDefault();

			$("<div>" + paramText + "</div>").dialog({

				title: paramTit,

				buttons: {

					"Aceptar": function() {

						$(this).dialog("close");

						$('form').submit();

					},

					"Cancelar": function() {

						$(this).dialog("close");

					}

				},

				show: {
					effect: "blind",
					duration: 400
				},

				minWidth: 350

			});

		});

		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})

		//TOOLTIPS BS

		$('.tooltips').tooltip({
			html: true
		});

		var contlog = $("#log");
		contlog.delay(3800).slideUp(200);

		//FANCYBOX

		var loading = $('#loading');

		$('.fancybox').fancybox();



		$(".fancyR").fancybox({

			iframe: {

				preload: false

			},

			beforeClose: function() {
				location.reload();
			}

		});



		$(".fancyRP").fancybox({

			iframe: {

				preload: true

			},

			beforeClose: function() {
				location.reload();
			}

		});



		$(".fancyI").fancybox({

			iframe: {

				preload: false

			}

		});

		$(".fancyIP").fancybox({

			iframe: {

				preload: true

			}

		});



		$(".fancyreload").fancybox({

			iframe: {

				preload: false

			},

			beforeClose: function() {
				location.reload();
			}

		});





		$(".fancyreload_old").fancybox({

			autoSize: false,

			width: "95%",

			height: "95%",

			beforeClose: function() {
				location.reload();
			}

		});

		$(".fancyMed").fancybox({

			autoSize: false,

			width: "60%",

			height: "90%",

			beforeClose: function() {
				location.reload();
			}

		});

		$(".fancyclose").fancybox({

			autoSize: true,

			beforeClose: function() {
				location.reload();
			}

		});

		//

	});

	//Tiny MCE

	tinymce.init({

		language: "es",

		selector: "textarea.tinymce",

		plugins: [

			"advlist autolink lists link image charmap print preview anchor",

			"searchreplace visualblocks code fullscreen",

			"insertdatetime media table contextmenu paste"

		],

		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

	});

	tinymce.init({

		language: "es",

		selector: "textarea.tinymcemin",

		menubar: false

	});



	tinymce.init({

		language: "es",

		selector: "textarea.tmceExam",

		menubar: false,

		plugins: "autoresize"

	});







	tinymce.init({

		language: "es",

		selector: "textarea.tmceExamE",

		menubar: false,

		plugins: [

			"autoresize",

			"code"

		],

		toolbar1: " code"



	});







	tinymce.init({

		language: "es",

		selector: "textarea.tmceDB",

		menubar: false,

		toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",

		setup: function(ed) {

			ed.on('keyup', function(e) {

				var field = ed.id;

				var id = $('.tmceDB').attr('data-id');

				var cont = ed.getContent();

				setDB(field, cont, id);

			});

		}

	});



	//GRITTER

	$.extend($.gritter.options, {

		//class_name: 'gritter-light', // for light notifications (can be added directly to $.gritter.add too)

		position: 'bottom-right', // possibilities: bottom-left, bottom-right, top-left, top-right

		fade_in_speed: 1000, // how fast notifications fade in (string or int)

		fade_out_speed: 1500, // how fast the notices fade out

		time: 5000 // hang on the screen for...

	});

	function logGritter(titulo, descripcion, imagen) {

		$.gritter.add({

			title: titulo, // (string | mandatory) the heading of the notification

			text: descripcion, // (string | mandatory) the text inside the notification

			image: imagen, // (string | optional) the image to display on the left

			sticky: false, // (bool | optional) if you want it to fade out on its own or just sit there

			time: '', // (int | optional) the time you want it to be alive for before fading out

			//class_name: 'my-sticky-class'// (string | optional) the class name you want to apply to that specific message

		});

	}

	//TABLESORTED

	$(function() {

		$("#mytable").tablesorter({
			widgets: ['zebra']
		});

		$("#mytable_cli").tablesorter({
			widgets: ['zebra']
		});

		$("#mytable_terpen").tablesorter({
			sortList: [
				[1, 0]
			],
			widgets: ['zebra']
		});

		$("#myt_rescons").tablesorter({
			sortList: [
				[3, 0]
			],
			widgets: ['zebra']
		});

		$("#myt_listcons").tablesorter({
			sortList: [
				[1, 1]
			],
			widgets: ['zebra']
		});

		$("#mytableall").tablesorter({
			sortList: [
				[0, 1]
			],
			widgets: ['zebra']
		});

	});

	//imprimir seleccion -->

	function imprSelec(nombre) {

		var ficha = document.getElementById(nombre);

		var ventimp = window.open(' ', 'popimpr');

		ventimp.document.write(ficha.innerHTML);

		ventimp.document.close();

		ventimp.print();

		ventimp.close();

	}

	function showLoading() {
		$('#loading').css({
			visibility: "visible"
		}).css({
			opacity: "1"
		});
	}

	//hide loading bar

	function hideLoading() {
		$('#loading').fadeTo(200, 0);
	};

	var ansclose = false;
	window.onbeforeunload = ansout;

	function ansout() {
		if (ansclose) return "Precaución de Cierre!";
	}



	function getRow(table, fiel, param, ford, pord) {

		$.ajax({

				method: "POST",

				url: url,

				data: {
					table: "db_examenes_format",
					field: "id",
					param: valSel
				},

				dataType: "json"

			})

			.done(function(msg) {

				alert("Data Saved: " + msg.log);

			});

	}
</script>