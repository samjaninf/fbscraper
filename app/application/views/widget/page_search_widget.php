<!-- Web Fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:700,400,300' rel='stylesheet' type='text/css'>
<!-- Bootstrap core CSS -->
<link href="<?php echo base_url();?>assets/site/bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- Font Awesome CSS -->
<link href="<?php echo base_url();?>assets/site/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

<style>
	.form-inline
	{
		background: <?php echo $info["background"];?>;
		padding:30px;
		width:100%;
		height:100%;
	}
	body
	{
    	overflow:hidden;
	}
	.form-control
	{
		color: <?php echo $info["color"];?>;
	}
	.form-group .fa
	{
		color: <?php echo $info["icon_color"];?> !important;		
	}
	.input-group-addon
	{
		background:#fff;
	}

	::-webkit-input-placeholder,:-moz-placeholder,::-moz-placeholder,:-ms-input-placeholder
	{
	   color: <?php echo $info["color"];?> !important;	
	}
	:-moz-placeholder
	{ 
   		color: <?php echo $info["color"];?> !important;	  
	}

	::-moz-placeholder 
	{  
	   color: <?php echo $info["color"];?> !important;	  
	}

	:-ms-input-placeholder 
	{  
	   color: <?php echo $info["color"];?> !important;	  
	}
	input
	{
		border-radius:0 !important;
		-moz-border-radius:0 !important;
		-webkit-border-radius:0 !important;
		border: 1px solid <?php echo $info["input_border_color"];?> !important;	  
	}	

	.input-group-addon
	{
		border-radius:0 !important;
		-moz-border-radius:0 !important;
		-webkit-border-radius:0 !important;
		border: 1px solid <?php echo $info["input_border_color"];?>; 
		border-right-width:0;  
	}

	button
	{
		border-radius:0 !important;
		-moz-border-radius:0 !important;
		-webkit-border-radius:0 !important;  
	}	

	


</style>

<?php //echo "<pre>"; print_r($info); echo "</pre>"; ?>

<center>
<form class="form-inline">
  <div class="text-center" id="loading"></div>
  <h3 class="text-center" id="progress_msg_text"></h3>
  <div class="text-center" id="output"></div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon"> <i class="fa fa-tag"></i> </div>
      <input type="text" required id="keyword" class="form-control" placeholder="<?php echo $this->lang->line("keyword"); ?>" name="keyword">
      <!-- <div class="input-group-addon">.00</div> -->
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon"> <i class="fa fa-user"></i> </div>
      <input type="text" required id="name" class="form-control" autofocus="yes" placeholder="<?php echo $this->lang->line("your name"); ?>" name="name">
      <!-- <div class="input-group-addon">.00</div> -->
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon"> <i class="fa fa-envelope"></i> </div>
      <input type="email" required id="email" class="form-control" placeholder="<?php echo $this->lang->line("your email"); ?>" name="email">
      <!-- <div class="input-group-addon">.00</div> -->
    </div>
  </div>
  
  <button type="button" id="search" class="btn btn-<?php echo $info["button_style"];?>"> <i class="fa fa-search"></i> <?php echo $this->lang->line("search"); ?></button>
</form>
</center>





<!-- Jquery and Bootstap core js files -->
<script type="text/javascript" src="<?php echo base_url();?>assets/site/plugins/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/site/bootstrap/js/bootstrap.min.js"></script>



<script type="text/javascript">

		function get_bulk_progress()
		{
			var base_url="<?php echo base_url(); ?>";			
			$.ajax({
				url:base_url+'widget/bulk_page_search_progress_count',
				type:'POST',
				dataType:'json',
				success:function(response){
					var search_completed=response.search_completed;
					var search_counting=response.search_counting;

					if(search_counting)
						$("#progress_msg_text").html(search_counting+" <?php echo $this->lang->line('results found') ?>");

					if(search_completed == 1) 
					{
						$("#progress_msg_text").html(search_counting+" <?php echo $this->lang->line('results found') ?>");

						clearInterval(interval);
					}				

				}
			});		
		}

		var interval="";


		$(document).ready(function() {

			var base_url="<?php echo base_url(); ?>";

			$("#search").on('click',function(){

				var keyword = $("#keyword").val();
				var name = $("#name").val();
				var email = $("#email").val();

				if(keyword == '')
				{
					alert("<?php echo $this->lang->line('you have not enter any Keyword'); ?>");
					return false;
				}

				if(name=="" || email=="")
				{
					alert("<?php echo $this->lang->line('something is missing'); ?>");
					return false;
				}

				$("#progress_msg_text").html("0  <?php echo $this->lang->line('results found') ?>");				
				interval=setInterval(get_bulk_progress, 10000);

				$("#output").html("");	
				$("#loading").html('<img class="center-block" src="'+base_url+'assets/pre-loader/custom.gif" alt="Processing..."><br/>');

				$.ajax({
					url:base_url+'widget/page_search_widget_action',
					type:'POST',
					data:{keyword:keyword,name:name,email:email},
					success:function(response){	
						$("#progress_msg_text").html("");		
						$("#loading").html("");
						$("#output").html(response);		
						
					}

				});


			});

			
		});
	</script>
