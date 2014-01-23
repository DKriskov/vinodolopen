$(document).ready(function(){
	$(".uizradi").tooltip({placement: 'bottom'});

	$("input[name='datum']").datepicker({ dateFormat: "dd.mm.yy." });

	$(".signup").click(function() {
		var href = $(this).attr("data-href");
		location.href = href;
		return false;
	});

	$('.collapse').live('show', function(){
	    $(this).parent().find('a .icon').attr('class', 'icon ent-minus'); //add active state to button on open
	});

	$('.collapse').live('hide', function(){
	    $(this).parent().find('a .icon').attr('class', 'icon ent-plus'); //remove active state to button on close
	});


	// carousel demo
    $('#carouselslide').carousel();
	//========================== SlideJS Slider Initiation ============================// 

	var triangle = "<div class='triangle'></div>";
	var block = "<div class='block'></div>";

	var slider = $('#slidejs'),
	 	sliderCaption = $('#bon-slider-caption');

	if (slider.size() > 0) {
		slider.slides({
			preload: true,
			preloadImage: baseURL+'/img/assets/ajax-loader.gif',
			play: false,
			pause: 2500,
			hoverPause: true,
			generateNextPrev: true,
			pagination: true,
			next: 'slide-next',
			prev: 'slide-prev',
			generatePagination: true,
			autoHeight: false,
			effect: 'slide',
			crossfade: true,
			paginationClass : 'slides-paginate',
			container: 'slides-container',
	        slidesLoaded: function() {
	            slider.find('.slides-paginate').addClass('visible-desktop');

	        }
		});
	}
	slider.find('.slide-next').append('<span class="awe-chevron-right"></span>');
    slider.find('.slide-prev').append('<span class="awe-chevron-left"></span>');

    if(slider.find('.slide-outer').children('.triangle').size() < 1){
		$('.slide-outer').prepend(triangle);
	}
	if(slider.find('.slide-outer').children('.block').size() < 1) {
		$('.slide-outer').prepend(block);
	}
	

	//========================== Camera Slider Initiation ============================// 

	var slider2 = $('#cameraslide');

	if(slider2.size() > 0) {
		slider2.camera({
			thumbnails: false,
			height: '376px',
			playPause: false
		});
	}
	if (slider2.find('.camera_overlayer').children('.triangle').size() > 0) {
		$('.camera_overlayer').remove('.triangle');
	}
	else {
		$('.camera_overlayer').prepend(triangle);
	}
	if (slider2.find('.camera_overlayer').children('.block').size() > 0) {
		$('.camera_overlayer').remove('.block');
	}
	else {
		$('.camera_overlayer').prepend(block);
	}

	if (slider2.find('.camera_next').children('span').not('.awe-chevron-right')) {
		$('.camera_next').children().addClass('awe-chevron-right');
	}
	if (slider2.find('.camera_prev').children('span').not('.awe-chevron-left')) {
		$('.camera_prev').children().addClass('awe-chevron-left');
	}
	if (slider2.find('.camera_play').children('.ent-play').size() < 1 ) {
		$('.camera_play').append('<span class="ent-play"></span>');
	}
	if (slider2.find('.camera_stop').children('.ent-pause').size() < 1 ) {
		$('.camera_stop').append('<span class="ent-pause"></span>');
	}

	//========================== Adding Pagination to Carousel ============================//

	$("#ljestvica").carousel({
	  interval: false
	});

	$('.carousel[id]').each(
		function() {
			var html = '<div class="carousel-nav" data-target="' + $(this).attr('id') + '"><ul>';
			
			for(var i = 0; i < $(this).find('.item').size(); i ++) {
				html += '<li><a';
				if(i == 0) {
					html += ' class="active"';
				}
				
				html += ' href="#">•</a></li>';
			}
			
			html += '</ul></li>';
			$(this).before(html);
			//$('.carousel-control.left[href="#' + $(this).attr('id') + '"]').hide();
		}
	).bind('slid',
		function(e) {
			var nav = $('.carousel-nav[data-target="' + $(this).attr('id') + '"] ul');
			var index = $(this).find('.item.active').index();
			var item = nav.find('li').get(index);
			
			nav.find('li a.active').removeClass('active');
			$(item).find('a').addClass('active');
			
			if($(this).attr('id') == "ljestvica") {
				$("#ljestvica-heading").html(($(this).find('.item.active').attr("data-heading")));
			}
		}
	);
	
	$('.carousel-nav a').bind('click',
		function(e) {
			var index = $(this).parent().index();
			var carousel = $('#' + $(this).closest('.carousel-nav').attr('data-target'));
			
			carousel.carousel(index);
			e.preventDefault();
		}
	);

	//========================== Activating Bootstrap Tabs ============================// 

    $('#tab1 a, #tab-content a').click(function (e) {
	    e.preventDefault();
	    $(this).tab('show');
    });


    //========================== SideBar Menu Children Slide In ============================// 

    $('.menu-widget ul li a, #responsive-nav ul li a').click( function (e){
    	$(this).find('span.icon').toggleClass(function() {
		    if ($(this).is('.awe-chevron-up')) {
                $(this).removeClass('awe-chevron-up');
		        return 'awe-chevron-down';
		    } else {
                $(this).removeClass('awe-chevron-down');
		        return 'awe-chevron-up';
		    }
		});
    	$(this).siblings('ul').slideToggle();
    });

    $('#responsive-nav .collapse-menu .collapse-trigger').click( function (e) {
        $(this).toggleClass(function() {
            if ($(this).is('.awe-chevron-down')) {
              $(this).removeClass('awe-chevron-down');
              return 'awe-chevron-up';
            } else {
              $(this).removeClass('awe-chevron-up');
              return 'awe-chevron-down';
            }
        });
        $(this).parent().siblings('ul').slideToggle();
    });


    //========================== Article Info Popover ============================// 

    $('.article-info .author-info span').popover({
    	animation: true,
    	html: true,
    	placement: 'left',
    	trigger: 'click',
    	content: function (i){
    		var src = $(this).data('image');
    		var author = $(this).data('author-desc');
    		var content = "<div class='popover-image image-polaroid'><img src='" + src + "' /></div><div class='popover-desc'>" + author + "</div>";
    		return content;
    	}
    });

    $('.article-info .time span').popover({
    	animation: true,
    	html: true,
    	placement: 'bottom',
    	trigger: 'click',
    	content: function(i) {
    		var date = $(this).data('date'),
    			day = date.day,
    			month = date.month,
    			year = date.year,
    			time = $(this).data('time');

    		var content = "<div class='popover-date'><span class='ent-calendar'></span>"+
    						month+" "+day+", "+year+"</div><div class='popover-time'>"+
    						"<span class='ent-clock'></span>"+time+"</div>";

    		return content;
    	}
    });

    $('.article-info .comment span').popover({
    	animation: true,
    	html: true,
    	placement: 'left',
    	trigger: 'click',
    	content: function(i) {
    		var data = $(this).data('comment-latest'),
    			author = data.author,
    			authorurl = data.authorurl,
    			comment = data.comment,
    			avatar = data.avatar;

    		var content = "<div class='info-title'><strong>Latest comment by:</strong></div>"+
    					  "<div class='popover-image image-polaroid'>" +
    					  "<img src='" + avatar + "' /></div>" +
    					  "<div class='popover-author'><a href='"+ authorurl + "' alt='"+author+"'>"+author+"</a></div>" +
    					  "<div class='popover-desc'>" + comment + "</div>";

    		return content;
    	}
    });

	//========================== Commnet Form ============================//

    $('input[type="text"], input[type="password"], input[type="email"], textarea').focus(function(){
    	$(this).parent('.input-border').addClass('focus');
    });
    $('input[type="text"], input[type="password"], input[type="email"], textarea').blur(function(){
    	$(this).parent('.input-border').removeClass('focus');
    });


    //========================== Article Info Popover ============================//
	
   
      
   $("#all").click(function(){
   	   $('.gallery-item').removeClass('last-col');
   	   $('.gallery-item:nth-child(4n+4)').addClass('last-col');
       $('.gallery-item').slideDown();
       $(this).parent().siblings().children('.active').removeClass('active');
       $(this).addClass("active");
       return false;
   });
   
   $(".filter").click(function(){
   		$('.gallery-item').slideUp();
   		$('.gallery-item').removeClass('last-col');

        var filter = $(this).attr("id");
        var i = 0;var j = 0;
        $('.'+filter).each(function(){
        		
        		if(i==3) {
        			j++;
	       			$('.'+filter).eq(i*j).addClass('last-col');
	       			i = 0;
	       		}
	       		i++;
	       		console.log("i", i);
	       		console.log("a",j);
        });
        $("."+ filter).slideDown();
        $(this).parent().siblings().children('.active').removeClass('active');
        $(this).addClass('active'); 


        return false;

   });
	
	//========================== Ajax Scores ============================//
   
	$('.buttonrezultati').click(function() {
		if($(this).parent().attr("data-retrieved")!="yes") {
			getScores(this);
			$(this).parent().attr("data-retrieved","yes");
		}
		
		if($(this).parent().attr("data-clicked")=="yes") {
			$(".scores",$(this).parent()).hide();
			$(this).parent().attr("data-clicked","no");
		} else {
			$(".scores",$(this).parent()).show();
			$(this).parent().attr("data-clicked","yes");
		}
		
	});

	$(".prvi").trigger('click');
	
	$('#submit').click(function(){		
		if($('#player1').val() == $('#player2').val()){
			alert('Izabrali ste dva ista igrača\nPokušajte ponovno');
			return false;
		}
	});

	$('.older').hide();

	$('.stariji').click(function(){
		$('.older').slideToggle();
	});
	
	//========================== current page ============================//

	var str=location.href.toLowerCase();
	$(".first-level li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
	 		$("li.current").removeClass("current");
			$(this).parent().addClass("current");
		}
 	});
	$("li.current").parents().each(function(){
		if ($(this).is("li")){
			$(this).find('li').removeClass('current');
			$(this).addClass("current");
		}
	});
	
	$("#del").click(function () {
        var didConfirm = confirm("Jesi siguran da zelis izbrisat profil?");
  		if (didConfirm === false) {
    		return false;
  		}
    });
	
// document.ready END //	
});



function getScores(thisdom) {
		var mjesec = $(thisdom).find('span.mjesec').html();
		var godina = $(thisdom).find('span.godina').html();
   		var htmlTemp = '';
		var parent = $(thisdom).parent();
	
   		$.post(BASE+'/ajax', { mjesec: mjesec, godina: godina },
	  		function(data){
	    		for (var i = 0; i <= data.length - 1; i++) {
	    			if (data[i].attributes.u1 != -1) {
	    				u1= '<td class="game">'+data[i].attributes.u1+'</td>';
	    			} else { u1 = '' ;}
	    			if (data[i].attributes.u2 != -1) {
	    				u2= '<td class="game">'+data[i].attributes.u2+'</td>';
	    			} else { u2 = '' ;}
	    			if (data[i].attributes.u3 != -1) {
	    				u3= '<td class="game">'+data[i].attributes.u3+'</td>';
	    			} else { u3 = '' ;}
	    			if (data[i].attributes.u4 != -1) {
	    				u4= '<td class="game">'+data[i].attributes.u4+'</td>';
	    			} else { u4 = '' ;}
	    			if (data[i].attributes.u5 != -1) {
	    				u5= '<td class="game">'+data[i].attributes.u5+'</td>';
	    			} else { u5 = '' ;}
	    			if (data[i].attributes.s1 != -1) {
	    				s1= '<td class="game">'+data[i].attributes.s1+'</td>';
	    			} else { s1 = '' ;}
	    			if (data[i].attributes.s2 != -1) {
	    				s2= '<td class="game">'+data[i].attributes.s2+'</td>';
	    			} else { s2 = '' ;}
	    			if (data[i].attributes.s3 != -1) {
	    				s3= '<td class="game">'+data[i].attributes.s3+'</td>';
	    			} else { s3 = ''; }
	    			if (data[i].attributes.s4 != -1) {
	    				s4= '<td class="game">'+data[i].attributes.s4+'</td>';
	    			} else { s4 = '' ;}
	    			if (data[i].attributes.s5 != -1) {
	    				s5= '<td class="game">'+data[i].attributes.s5+'</td>';
	    			} else { s5 = '' ;}
	    			htmlTemp += '\
	    				<div class="row-fluid">\
 							<div class="span7">\
		    					<table class="upisrezultata">\
		    						<tr>\
		    							<td><img class="img-circle" src="http://graph.facebook.com/'+data[i].relationships.user.attributes.fb_id+
		    							'/picture?width=60&height=60&r"></td>\
		    							<td>'+data[i].relationships.user.attributes.name+'</td>\
		    							<td class="set">'+data[i].attributes.u_final+'</td>'+
		    							u1+''+u2+''+u3+''+u4+''+u5+
		    						'</tr>\
		    						<tr>\
		    							<td><img class="img-circle" src="http://graph.facebook.com/'+data[i].relationships.suparnik.attributes.fb_id+
		    							'/picture?width=60&height=60&r"></td>\
		    							<td>'+data[i].relationships.suparnik.attributes.name+'</td>\
		    							<td class="set">'+data[i].attributes.s_final+'</td>'+
		    							s1+''+s2+''+s3+''+s4+''+s5+
		    						'</tr>\
		    					</table>\
		    				</div>\
		    				<div class="span5 podaci">\
		    					<table class="upisrezultata">\
		    						<tr>\
		    							<td>Teren: </td>\
		    							<td>'+data[i].relationships.teren.attributes.naziv+'</td>\
		    						</tr>\
		    						<tr>\
		    							<td>Podloga: </td>\
		    							<td>'+data[i].relationships.podloga.attributes.naziv+'</td>\
		    						</tr>\
		    						<tr>\
		    							<td>Datum: </td>\
		    							<td>'+data[i].attributes.datum+'</td>\
		    						</tr>\
		    					</table>\
		    				</div>\
		    			</div>\
	    				</br>\
	    				<hr>';
        		}
        		$(".scores",parent).html(htmlTemp);
	 	}, "json");

}

jQuery(function($){
        $.datepicker.regional['hr'] = {
                closeText: 'Zatvori',
                prevText: '&#x3c;',
                nextText: '&#x3e;',
                currentText: 'Danas',
                monthNames: ['Siječanj','Veljača','Ožujak','Travanj','Svibanj','Lipanj',
                'Srpanj','Kolovoz','Rujan','Listopad','Studeni','Prosinac'],
                monthNamesShort: ['Sij','Velj','Ožu','Tra','Svi','Lip',
                'Srp','Kol','Ruj','Lis','Stu','Pro'],
                dayNames: ['Nedjelja','Ponedjeljak','Utorak','Srijeda','Četvrtak','Petak','Subota'],
                dayNamesShort: ['Ned','Pon','Uto','Sri','Čet','Pet','Sub'],
                dayNamesMin: ['Ne','Po','Ut','Sr','Če','Pe','Su'],
                weekHeader: 'Tje',
                dateFormat: 'dd.mm.yy.',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['hr']);
});