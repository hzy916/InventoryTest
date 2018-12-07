<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

<style>
/*custom font*/
@import url(https://fonts.googleapis.com/css?family=Open+Sans);

@primary-color: #63a2cb;
@secondary-color: #67d5bf;

/*form styles*/
#msform {
	width: 600px;
	margin: 50px auto;
	text-align: center;
	position: relative;
}
#msform .fieldset {
	background: white;
	border: 0 none;
	border-radius: 3px;
	box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
	padding: 20px 30px;
	
	box-sizing: border-box;
	width: 80%;
	margin: 0 10%;
	/*stacking fieldsets above each other*/
	position: absolute;
}
/*Hide all except first fieldset*/
#msform .fieldset:not(:first-of-type) {
	display: none;
}
/*inputs*/
#msform input, #msform textarea {
	padding: 15px;
	border: 1px solid #ccc;
	border-radius: 3px;
	margin-bottom: 10px;
	width: 100%;
	box-sizing: border-box;
	font-family: montserrat;
	color: #2C3E50;
	font-size: 13px;
}
/*buttons*/
#msform .action-button {
	width: 100px;
	background:#2296f3;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px;
}
#msform .action-button:hover, #msform .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #67d5bf;
}
/*headings*/
.fs-title {
	font-size: 16px;
	text-transform: uppercase;
	color: #63a2cb;
	margin-bottom: 10px;
}
.fs-subtitle {
	font-weight: normal;
	font-size: 14px;
	color: #666;
	margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: white;
	text-transform: uppercase;
	font-size: 9px;
	width: 33%;
	float: left;
	position: relative;
}
#progressbar li:before {
	content: "Step"counter(step);
	counter-increment: step;
	width: 120px;
	line-height: 20px;
	display: block;
	font-size: 12px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #2296f3;
	color: white;
}

.help-block {
  font-size: .8em;
  color: #7c7c7c;
  text-align: left;
  margin-bottom: .5em;
}
</style>

</head>
<body>

  <!-- Thanks to Pieter B. for helping out with the logistics -->
<!-- multistep form -->
<div id="msform">
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active">Step 1</li>
		<li>Step 1</li>
		<li>Last Step</li>
	</ul>
	<!-- fieldsets -->
	<div class="fieldset">
	       <!-- Wizard STEP 1 -->
         
            <div class="col-sm-12">
                <div class="form-group">
        
                    <div id="NoItemDiv" style="display:<?php echo $NoItemDivView ?>">
                        <h2 class="fs-title">Shipment Contents</h2>
                        <hr class="seperateLine">
                     
                        <p class="noitemText">No Item in your shipment, please add item into your shipment </p>
                            <button id="addItem" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Add Item Into My Shipments</button>
                        <br>

                            <!-- form to remove selected product from the session -->
                        <form id="productDelete" method="POST">
                    
                            <input type="hidden"  name="makeaction" value="productDelete">
                            <input id="prod2del" type="hidden"  name="prod2del" value="">
                        </form>
                    </div>   
                </div>
            </div>
                           
                            <!-- Wizard STEP 1 END -->
  	    <input type="button" name="next" class="next action-button" value="Next" />
	</div>

	<div class="fieldset">
	      <!-- Wizard STEP 2 -->

             <h2 class="fs-title">Receiver’s Details</h2>
          
        <input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</div>

	<div class="fieldset">
            
                       <!-- Wizard STEP 3 -->         
                                
        3333

        <input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	
    </div>

</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<!-- jQuery easing plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" type="text/javascript"></script>

<script>
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($(".fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($(".fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

$(".submit").click(function(){
	return false;
})
</script>

  

</body>
</html>



