// Как только страничка загрузилась 
  window.onload = function () { 
    // проверяем поддерживает ли браузер FormData 
    if(!window.FormData) {
      alert("Браузер не поддерживает загрузку файлов на этом сайте");
    }
  }

jQuery(document).ready(function(){
	// =validation
	var errorTxt = 'Ошибка отправки';
	jQuery("#sendform").validate({
		submitHandler: function(form){
			var form = document.forms.sendform,
				formData = new FormData(form),
				xhr = new XMLHttpRequest();
				
			xhr.open("POST", "send.php");
			
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if(xhr.status == 200) {
						jQuery("#sendform").html('<p class="thank">Ваши данные отправлены! Мы свяжемся с Вами в кратчайшие сроки! Спасибо что выбрали нас!<p>');
					}
				}
			};
			xhr.send(formData);
		}
	});	
})

function sendSuccess(callback){
	jQuery(callback).find("form fieldset").html(thank);
	startClock();
}

(function($) {
  "use strict"; // Start of use strict




  var btn = $('.scroll-to-top');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });


  $("a.scrollto").click(function() {
    var elementClick = $(this).attr("href")
    var destination = $(elementClick).offset().top;
    jQuery("html:not(:animated),body:not(:animated)").animate({
      scrollTop: destination
    }, 800);
    return false;
  });


})(jQuery); 
