<!-- All plugins used :
1. simple_html_dom - html parser for php
2. bootstrap css + bootstrap js 3+ -->

<!-- php -->
<?php
require_once ('simple_html_dom.php');
function gallery_slides( $atts, $content ) {
		$exp = array();
		$alt = array();
		$cap = array();
		$link = array();
    // get content as html to parse
		$ht = str_get_html($content);
    // push content to arrays (returning html in a loop with .= is not supported)
		foreach($ht->find('img') as $element) {
			 array_push($exp,$element->src);
       // get alternative text of image and explode it to different variables
       // any other element (caption, description) can be used for that purpose
       //the first element is a slogan, the second is a text in a button and third is a link of this button
			 $tt = $element->alt;,
			 $tt2 = explode('#',$tt);
			 array_push($alt,$tt2[0]);
			 array_push($cap,$tt2[1]);
			 array_push($link,$tt2[2]);
		}
		// print_r($content); - print content for debug
    $html = '<div class="d-md-none d-block">
							<div class="d-none d-sm-block" style="background-color:lightgrey;padding:1em;">
								<h5 style=" text-align:center; color:rgba(0,0,0,0.5)">
								'.$alt[0].'
								</h5>
							</div>
							<div>
							<img src="'.$exp[0].'"'. ' ' .'style="width:100%;">
							</div>
						</div>
						<div class="bd-example galeria_duza_kontener d-none d-md-block">
            <div id="nawigacja_karuzeli_galerii_duzej_1"
            class="carousel slide" data-ride="carousel"
            >
            <ol class="carousel-indicators">';
            $ind = 0;
          while($ind<count($exp)){
            $src = $exp[$ind];
            //first element of carousel always have to be active
                  if($ind == 0){
                    $html .= '<div data-target="#nawigacja_karuzeli_galerii_duzej_1" data-slide-to="' . $ind . '"
										class="bullet" style="">
                    </div>';
                  }
                  if($ind > 0){
                    $html .= '<div data-target="#nawigacja_karuzeli_galerii_duzej_1" data-slide-to="' . $ind . '"
										class="bullet " style="">
                    </div>';
                  }
            $ind++;
          }
          $ind = 0;
          $html .= '</ol>';
          $html .= '<div class="carousel-inner" role="listbox">';
          while($ind<count($exp)){
            $src2  = $exp[$ind];
						$meta_alt = $alt[$ind];
						$meta_cap = $cap[$ind];
						$meta_link = $link[$ind];
            if($ind == 0){
              $html .= '
                <div class="carousel-item active">
                  <img id="" class="d-block img-fluid galeria_zdj" data-custom-src="'.$src2.'" alt=""
                  src="" data-holder-rendered="true" style="background-image:url('.$src2.');"
                   >
                  <div class="carousel-caption d-md-block opis_karuzela black_high">
									<div style="position:absolute; left:50%; top:-650%;">
										<h1 class="galeria_tekst">
										'.$meta_alt.'
										</h1>
										<div class="" style="position:relative;left:-50%; padding:1em;">'
											.( isset($meta_cap)  ?
											'<a href="'. $meta_link .'" style="display:block;">
											<h2 class="galeria_tekst2">'.$meta_cap.'</h2></a>': ' ').
										'</div>
									</div>
                  </div>
                </div>';
            }
            if($ind > 0){
              $html .= '
                <div class="carousel-item">
                  <img id="" class="d-block img-fluid galeria_zdj" data-custom-src="'.$src2.'" alt=""
                  src="" data-holder-rendered="true" style="background-image:url('.$src2.');"
                   >
                  <div class="carousel-caption d-md-block opis_karuzela black_high">
									<div style="position:absolute; left:50%; top:-650%;">
										<h1 class="galeria_tekst">
										'.$meta_alt.'
										</h1>
										<div class="" style="position:relative;left:-50%; padding:1em;">'
											.( isset($meta_cap)   ?
											'<a href="'. $meta_link .'" style="display:block;">
											<h2 class="galeria_tekst2">'.$meta_cap.'</h2></a>': ' ').
										'</div>
									</div>
                  </div>
                </div>';
            }
            $ind++;
          }
          $html .= '</div>';
          $html .='<a class="carousel-control-prev" data-target="#nawigacja_karuzeli_galerii_duzej_1" role="button" data-slide="prev"
          style="">
                    <span class="carousel-control-prev-icon" aria-none="true" style=""></span>
                    <span class="sr-only">Previous</span>
                  </a>
              <a class="carousel-control-next" data-target="#nawigacja_karuzeli_galerii_duzej_1" role="button" data-slide="next"
              style="">
                <span class="carousel-control-next-icon" aria-none="true" style=""></span>
                <span class="sr-only">Next</span>
              </a>';
      $html .= "</div></div>";
      return $html;
}
add_shortcode( 'gallery_slides', 'gallery_slides' );
 ?>

<script type="text/javascript">
var set = false;
//initiate only if document has a gallery
if (!jQuery.contains(document, $('.carousel-inner')) && window.innerWidth>600) {
set = true;
}
if (set==true) {
  // console log attributes given by a shortcode
  // console.log($('.galeria_zdj').eq(2).attr('alt'));
  $('.carousel-control-prev span').css('display','none');
  $('.carousel-control-next span').css('display','none');
  $('.carousel-control-prev span').fadeIn('slow');
  $('.carousel-control-next span').fadeIn('slow');
  var ind = 0;
  // create array from slides
  var l = $('.carousel-inner .carousel-item').toArray();
  $('.carousel-control-prev').click(function() {
    clearInterval(inter);
    if (ind==0) {
      ind=l.length-1;
    } else { ind--;
    }
    animateGallery();
    inter = setInterval(changeIt, time);
  });
  $('.carousel-control-next').click(function() {
    clearInterval(inter);
    if (ind==l.length-1 || ind>l.length) {
      ind = 0;
    } else { ind++;
    }
    animateGallery();
    inter = setInterval(changeIt, time);
  });
  $('.carousel-inner').css('background-color','grey');
  var time = 5000;
  // getImageBrightness();
  var inter = setInterval(changeIt, time);
function changeIt () {
  animateGallery();
  if (ind==l.length-1) {
    ind = 0;
  } else {
    ind++;
  }
}
// var counter = [];
function animateGallery(){
  // getImageBrightness(ind);
  $('.bullet').css('background-color','rgba(255,255,255,0.6)');
  $('.bullet').css('border','0');
  $( "[data-slide-to='"+ind+"']").css('background-color','white');
  $( "[data-slide-to='"+ind+"']").css('border','2px solid rgba(0,0,0,0.8)');
  $('.carousel-inner .carousel-item').fadeOut('slow', 'linear');
  setTimeout(function () {
    $('.carousel-inner .carousel-item').eq(ind).fadeIn('slow', 'linear');
  }, 500);
  // console.log(counter);
  // if ($.inArray(ind, counter) == -1){counter.push(ind); }
}
var ind_slide;
$('.bullet').click(function(){
    clearInterval(inter);
    ind_slide = $(this).attr('data-slide-to');
    ind = parseInt(ind_slide);
    animateGallery();
    inter = setInterval(changeIt, time);
});
var indx=0;

//CALCULATE AVARAGE BRIGHTNESS OF IMAGE AND CHANGE TEXT ON TOP ACCORDINGLY:

while (indx<l.length) {
  // if ($.inArray(ind, counter) !== -1){
  //   console.log('Div has a class');
  //   return;
  // }
    var imgSrc = new Image();
    imgSrc.id = 'temp';
    imgSrc.src = $('.galeria_zdj').eq(indx).data('custom-src');
    imgSrc.style.display = "none";
    console.log($('.galeria_zdj').eq(indx).data('custom-src'));
    // console.log($('.galeria_tekst').eq(ind).hasClass('backgroundLight'));
    var colorSum = 0;
            // create canvas
            var canvas = document.createElement("canvas");
            canvas.width = Math.max(1, Math.floor(imgSrc.width));
            canvas.height = Math.max(1, Math.floor(imgSrc.height));
            var ctx = canvas.getContext("2d");
            ctx.drawImage(imgSrc,0,0);
            var imageData = ctx.getImageData(0,0,canvas.width,canvas.height);
            var data = imageData.data;
            var r,g,b,avg;
            for(var x = 0, len = data.length; x < len; x+=8) {
              r = data[x];
              g = data[x+1];
              b = data[x+2];
              avg = Math.floor((r+g+b)/3);
              colorSum += avg;
            }
            $('canvas').remove();
            $('#temp').remove();
            var brightness = Math.floor(colorSum / (imgSrc.width*imgSrc.height));
            console.log(brightness);
            // wyzerowanie
            colorSum = 0;
            r = 0; g = 0; b = 0; avg = 0; data = 0;
            if (brightness>65) {
              $('.galeria_tekst').eq(indx).addClass('backgroundLight');
              $('.galeria_tekst2').eq(indx).addClass('backgroundLight');
            // } else if (brightness<71 && brightness>60) {
            //   $('.galeria_tekst').eq(ind).addClass('background-complex ');
            } else {
              $('.galeria_tekst').eq(indx).addClass('backgroundDark');
              $('.galeria_tekst2').eq(indx).addClass('backgroundDark');
            }
          indx++;
          console.log(indx);
        }
        //THE END OF while
      //   // THE END OF funkcji
      // }
    }
    // THE END OF setIt
</script>

<!-- css: -->
<style media="screen">
.galeria_zdj {
background-size: cover;
height: 60vh;
}
.carousel-inner {
background-size: cover;
height: 60vh;
overflow: hidden;
}
.bullet {
bottom: -5%;
height: 7px;
width: 7px;
border-radius: 50%;
background-color: rgba(255, 255, 255, 0.6);
margin: 0 6px 0 6px;
box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
cursor: pointer;
}
.bullet:hover {
background-color: white;
}
.galeria_tekst {
position: relative;
color: #575757;
text-align: center;
max-width: 400px;
left: -50%;
text-shadow: 1px 1px 3px grey;
}
.galeria_tekst2 {
border-radius: 4px;
border: 2px solid grey;
display: block;
color: #575757;
width: auto;
display: inline-block;
padding: 0.2em;
background-color: rgba(255, 255, 255, 0.2);
transition: all 0.5s;
-webkit-transition: all 0.5s;
}
</style>
