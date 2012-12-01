<!DOCTYPE html>
<html lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<script src="jquery-1.8.3.min.js"></script>
	<script src="jquery.cookie.js"></script>
    <script language="javascript" type="text/javascript">

		function dom_ready(){
			if($.cookie('current_lang') === null) { 
	    		$.cookie("current_lang", "en");
			}
	    	if($.cookie('alt_lang_1') === null) { 
	    		$.cookie("alt_lang_1", "ar");
			}
			
			var current_lang=$.cookie("current_lang");
	    	var alt_lang_1=$.cookie("alt_lang_1");
	    	//alert( "START: " + $.cookie("current_lang") );
				
			$('#button_lang').bind('click', function() {
				var tmp_button_lang=current_lang;
				current_lang=alt_lang_1;
				alt_lang_1=tmp_button_lang;
				$.cookie("current_lang", current_lang, { expires: 7 });
				$.cookie("alt_lang_1", alt_lang_1, { expires: 7 });

				redraw_language(current_lang, alt_lang_1);
			});

			$('head').append('<link rel="stylesheet" href="'+current_lang+'.css" type="text/css" />');
			$('head').append('<link rel="stylesheet" href="'+alt_lang_1+'.css" type="text/css" />');


			redraw_language(current_lang, alt_lang_1);
		}

		function redraw_language (current_lang, alt_lang_1) {
			//alert( "Redraw: " + $.cookie("current_lang") );
				
				$.ajax({
		        url: 'language.xml',
		        success: function(xml) {
		        	$(xml).find('translation').each(function(){
		                var id = $(this).attr('id');
		                if (id=="change_lang") {
		                	var lang=alt_lang_1;
		                } else {
		                	var lang=current_lang;
		                }

		                var text = $(this).find(lang).text();
		                $("." + id).html(text);
		                $("." + id).removeClass(function (index, css) {
    						return (css.match (/\bbutton_text_\S+/g) || []).join(' ');
						});
		                $("." + id).addClass("button_text_common");
		                $("." + id).addClass("button_text_"+lang);
		            });
		        }
		    });
		}


		jQuery(document).ready(dom_ready);
    </script>

    <link rel="stylesheet" type="text/css" href="common.css" />

</head>
<body>

	<div id="button_lang_div">
		<a href="#" id="button_lang" class="change_lang">empty</a>
	</div>

	<div id="button_lang_div_1" class="text_1">empty</div>
	<div id="button_lang_div_2" class="text_2">empty</div>

</body>
</html>
