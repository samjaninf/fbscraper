<?php $this->load->view('admin/theme/message'); ?>
<?php 
if(isset($google_api[0]['google_api_key'])) $google_api_key=$google_api[0]['google_api_key'];
else $google_api_key="AIzaSyBG0sIVBWReW1Q0WGkWO28uGaKWhQp7Q4c";
?>
<!-- Main content -->
<section class="content-header">
	<h1 class = 'text-info'><?php echo $this->lang->line("Location Search");?></h1>
</section>
<section class="content">  
	<div class="row" >
		<div class="col-xs-12">
			<div class="grid_container" style="width:100%; min-height:760px;">
				<table 
				id="tt"  
				class="easyui-datagrid" 
				url="<?php echo base_url()."location_search/location_search_data"; ?>" 

				pagination="true" 
				rownumbers="true" 
				toolbar="#tb" 
				pageSize="15" 
				pageList="[5,10,15,20,50,100]"  
				fit= "true" 
				fitColumns= "true" 
				nowrap= "true" 
				view= "detailview"
				idField="id"
				>
				
					<!-- url is the link to controller function to load grid data -->					

					<thead>
						<tr>
							<th field="id"  checkbox="true"></th>
							<th field="search_keyword" sortable="true"><?php echo $this->lang->line('Keyword');?></th>
							<th field="name" sortable="true"><?php echo $this->lang->line('Name');?></th>
							<th field="fan_count" sortable="true"><?php echo $this->lang->line('Fan Count');?></th>
							<th field="talking_about_count" sortable="true"><?php echo $this->lang->line('Talking About Count');?></th>
							<th field="phone" sortable="true"><?php echo $this->lang->line('Phone');?></th>
							<th field="website" sortable="true"><?php echo $this->lang->line('Website');?></th>
							<th field="searched_at" sortable="true"><?php echo $this->lang->line('Searched at');?></th>
							<th field="details" sortable="true"><?php echo $this->lang->line('Details');?></th>
						</tr>
					</thead>
				</table>                        
			</div>

			<div id="tb" style="padding:3px">

			<div class="row">
				<div class="col-xs-12">
					<?php if($configured_or_not=='not_configured') {?>
						<div class="alert alert-danger text-center">
							<b><a href='<?php echo site_url()."admin_config_facebook/facebook_config"; ?>'><?php echo $this->lang->line("You haven't configured your facebook settings yet, please configure first.");?></a></b>
						</div>
					<?php } else {?>
					<?php if($access_token == 'no') { ?>
						<div class="alert alert-danger text-center">
							<b><?php echo $this->lang->line('Please'), ' ' ;?> <?php echo $fb_login_button; ?></b>
						</div>
					<?php }else { ?>
						<button type="button" style="width:150px;" class="btn btn-primary" id ="new_search_modal_open"><i class="fa fa-search"></i> <?php echo $this->lang->line("new search");?></button>
					<?php } ?>
					<?php } ?>
				</div>
			</div>
 

			<form class="form-inline" style="margin-top:20px">

				<div class="form-group">
					<input id="keyword" name="keyword" class="form-control" size="20" placeholder="<?php echo $this->lang->line('keyword');?>">
				</div>

				<div class="form-group">
					<input id="name" name="name" class="form-control" size="20" placeholder="<?php echo $this->lang->line('name');?>">
				</div>  

				<div class="form-group">
					<input id="from_date" name="from_date" class="form-control datepicker" size="20" placeholder="<?php echo $this->lang->line('from date');?>">
				</div>

				<div class="form-group">
					<input id="to_date" name="to_date" class="form-control  datepicker" size="20" placeholder="<?php echo $this->lang->line("to date");?>">
				</div>                    

				<button class='btn btn-info'  onclick="doSearch(event)"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("search report");?></button> <br/>  <br/>  
				<button type="button" style="width:220px;" class="btn btn-info download" id = "download_btn"><i class="fa fa-cloud-download"></i> <?php echo $this->lang->line("download selected");?></button>
				<button type="button" style="width:220px;" class="btn btn-info download" id = "download_btn_all"><i class="fa fa-cloud-download"></i> <?php echo $this->lang->line("download all");?></button>
				<button type="button" style="width:220px;" class="btn btn-danger delete" id = "delete_btn" style = 'margin-bottom:10px'><i class="fa fa-times"></i> <?php echo $this->lang->line("delete selected");?></button>
				<button type="button" style="width:220px;" class="btn btn-danger delete" id = "delete_btn_all" style = 'margin-bottom:10px'><i class="fa fa-times"></i> <?php echo $this->lang->line("delete all");?></button>
			
			</div>  

			</form> 

			</div>        
		</div>
	</div>   
</section>

<!-- Start modal for new search. -->
<div id="modal_new_search" class="modal fade">
	<div class="modal-dialog modal-lg" style="width:100%;">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"> <i class="fa fa-close fa-2x"></i> </span>
				</button>
				<h4 id="new_search_details_title" class="modal-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Location Search");?></h4>
			</div><br/>


			<div id="new_search_view_body" class="modal-body">
				<form enctype="multipart/form-data" method="post" class="form-inline" id="new_search_form" style="margin-bottom:10px">

			
					<div class="row">						
						<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<input id="new_search_keyword" type="text" class="form-control" placeholder="<?php echo $this->lang->line("Keyword"); ?>" style="width:100%"/>
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<input id="location" type="text" class="form-control" placeholder="<?php echo $this->lang->line("Location"); ?>" style="width:100%"/>
							<input id="location_lat" type="hidden" class="form-control" />
							<input id="location_long" type="hidden" class="form-control" />
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<!-- <input id="limit" type="text" class="form-control" placeholder="<?php echo $this->lang->line("Limit"); ?>" style="width:100%"/> -->
							<?php $this->load->view("limit"); ?>
						</div>								
					</div>
					<div class="row" style="margin-top:10px;">						
						<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<!-- <input id="distance" type="text" class="form-control" placeholder="<?php echo $this->lang->line("Distance"); ?>" style="width:100%"/> -->
							<?php $this->load->view("distance"); ?>
						</div>							
						<div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">										
								<label class="checkbox-inline" ><input type="checkbox" id = "is_video" value = "checked_proxy" ><span style = "font-size:15px"> Video </span></label>
						</div>								
						<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4 clearfix">						
							<button type="button"  id="new_search_button" class="btn btn-info"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("start searching"); ?></button>   
						</div>
					</div>

				</form>
				
			
				<div class="row"> 
					
					<br/>
					<div class="col-xs-12" class="text-center" id="success_msg"></div>

					<div class="col-xs-12" class="text-center">
						<h3><?php echo $this->lang->line("Total Location Search"); ?> : <span id="progress_msg_text"></span></h3>
					</div>   
			   

					<div class="col-xs-12 wow fadeInRight">		  
						<div class="loginmodal-container">
							
							<div id="download_div" class="text-center" style="margin-bottom:10px;">
								
							</div>
							
							<div class="table-responsive" id="display_table" style="max-height:500px;overflow-y:auto;">
								
							</div>                     
						</div>
					</div>	

					<div class="col-xs-12 wow fadeInRight table-responsive" id="live_data">	
					</div>		
				</div> 


				
			</div> <!-- End of body div-->

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End modal for new search. -->

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo $google_api_key;?>"></script>

<script>
	var placeSearch, autocomplete,autocomplete2,autocomplete3,autocomplete4,autocomplete5;
	function initialize() 
	{
	  autocomplete = new google.maps.places.Autocomplete((document.getElementById('location')),{ types: ['geocode'] });
	  google.maps.event.addListener(autocomplete, 'place_changed', function() 
	  {
		fillInAddress("location_lat","location_long",1);
	  });
	}
	
	function fillInAddress(lat_div,lng_div,autocomplete_no) 
	{
		if(autocomplete_no==1)
		var place = autocomplete.getPlace();		
		else var place = autocomplete5.getPlace();

		console.log(place);
		console.log(place.geometry.location.lat());
		console.log(place.geometry.location.lng());
		var latitude = place.geometry.location.lat();
		var longitude = place.geometry.location.lng();

		$("#location_lat").val(latitude);
		$("#location_long").val(longitude);		
	}	
	
	window.onload=initialize;

	var pacContainerInitialized = false;					  
	$(document).on('keypress','#location',function(){
	        if (!pacContainerInitialized) {
	                $('.pac-container').css('z-index', '9999');
	                pacContainerInitialized = true;
	        }
	});	
	
</script>

<script>

	$j(function() {
		$( ".datepicker" ).datepicker();
	});
	

	$("#new_search_modal_open").click(function(){
		$("#modal_new_search").modal();
	});

	$(".download").click(function(){
		var base_url="<?php echo base_url(); ?>";
		
		var d_id=$(this).attr("id");
		var all=0;
		if(d_id=="download_btn_all") all=1;

		$('#'+d_id).html('<i class="fa fa-spinner"></i> <?php echo $this->lang->line("please wait"); ?>');
		var url = "<?php echo site_url('location_search/location_search_download');?>";
		var rows = $j("#tt").datagrid("getSelections");
		var info=JSON.stringify(rows); 
		if(rows == '' && all==0)
		{
			$('#download_btn').html('<i class="fa fa-cloud-download"></i> <?php echo $this->lang->line("download selected"); ?>');
			alert("<?php echo $this->lang->line('You have not select any record');?>");
			return false;
		}
		$.ajax({
			type:'POST',
			url:url,
			data:{info:info,all:all},
			success:function(response)
			{
				if (response != '') 
				{
					if(all==1)
					$('#'+d_id).html('<i class="fa fa-cloud-download"></i> <?php echo $this->lang->line("download all"); ?>');
					else $('#'+d_id).html('<i class="fa fa-cloud-download"></i><?php echo $this->lang->line("download selected"); ?>');
					$('#modal_for_download').modal();
					
				} else {
					alert("<?php echo $this->lang->line('something went wrong, please try again'); ?>");
				}
			}
		});
	});

	//section for Delete
	$(".delete").click(function(){
		var result = confirm("<?php echo $this->lang->line('are you sure that you want to delete this record?'); ?>");

		if(result)
		{
			
			var d_id=$(this).attr("id");
			var all=0;
			if(d_id=="delete_btn_all") all=1;
			$('#'+d_id).html('<i class="fa fa-spinner"></i> <?php echo $this->lang->line("please wait"); ?>');

			var base_url="<?php echo base_url(); ?>";		
			var url = "<?php echo site_url('location_search/location_search_delete');?>";
	        var rows = $j("#tt").datagrid("getSelections");
	        var info=JSON.stringify(rows); 

	         /***For deleteing rows ***/
			var rowsLength = rows.length;	
			var rr = [];
			for (i = 0; i < rowsLength; i++) {
			     rr.push(rows[i]);
			}
			/****Sengment end for deleting rows*****/
	        if(rows == ''  && all==0)
	        {
	        	alert("<?php echo $this->lang->line('You have not select any record');?>");
	        	$('#delete_btn').html('<i class="fa fa-times"></i> <?php echo $this->lang->line("delete selected");?>');
	            return false;
	        }
	        $.ajax({
	            type:'POST',
	            url:url,
	            data:{info:info,all:all},
	            success:function(response){	

	            	if(all==1)
					$('#'+d_id).html('<i class="fa fa-times"></i> <?php echo $this->lang->line("delete all");?>');
					else $('#'+d_id).html('<i class="fa fa-times"></i> <?php echo $this->lang->line("delete selected");?>');
	
	            	/***For deleteing rows ***/					
					$.map(rr, function(row){
						var index = $j("#tt").datagrid('getRowIndex', row);
						$j("#tt").datagrid('deleteRow', index);
					});					
					/****Sengment end for deleting rows*****/ 
	            	$j('#tt').datagrid('reload'); 	              
	            }
	        });


		}//end of if.			

	});

	//End section for Delete.


	function doSearch(event)
	{
		event.preventDefault(); 
		$j('#tt').datagrid('load',{
			name     		:     $j('#name').val(),              
			keyword     	:     $j('#keyword').val(),              
			from_date  		:     $j('#from_date').val(),    
			to_date    		:     $j('#to_date').val(),         
			is_searched		:     1
		});


	}


	function get_bulk_progress()
	{
		var base_url="<?php echo base_url(); ?>";			
		$.ajax({
			url:base_url+'location_search/bulk_location_search_progress_count',
			type:'POST',
			dataType:'json',
			success:function(response){
				var search_completed=response.search_completed;
				var search_counting=response.search_counting;

				if(search_counting)
					$("#progress_msg_text").html(search_counting);
				
				if(search_completed == 1) 
				{
					$("#progress_msg_text").html(search_counting);
					
					clearInterval(interval);
				}
				
				
			}
		});
		
	}
	
	var interval="";


	$j("document").ready(function(){
		
		var base_url="<?php echo base_url(); ?>";
		
		$("#new_search_button").on('click',function(){
				
			var keyword = $("#new_search_keyword").val();
			var limit = $("#limit").val();
			var location = $("#location").val();
			var distance = $("#distance").val();
			var latitude = $("#location_lat").val();
			var longitude = $("#location_long").val();
			
			if(keyword == '')
			{
				alert("<?php echo $this->lang->line('you have not enter any Keyword'); ?>");
				return false;
			}

			var is_video;

			if ($('#is_video').is(':checked')) is_video=1;
			else is_video=0;


			$("#progress_msg_text").html("0");				
			interval=setInterval(get_bulk_progress, 10000);

			$("#success_msg").html('<img class="center-block" src="'+base_url+'assets/pre-loader/Fancy pants.gif" alt="Processing..."><br/>');
			
			$.ajax({
				url:base_url+'location_search/location_search_action',
				type:'POST',
				data:{keyword:keyword,limit:limit,latitude:latitude,longitude:longitude,distance:distance,is_video:is_video},
				success:function(response){
					$("#success_msg").html('<center><h3 style="color:olive;"><?php echo $this->lang->line("completed"); ?></h3></center>');
					$("#download_div").html('<center><a style="margin: 0px auto;" href="<?php echo base_url()."download/location_search/location_search_".$this->user_id."_".$this->session->userdata("download_id").".csv"; ?>" target="_blank" class="btn btn-lg btn-warning"><i class="fa fa-cloud-download"></i> <b><?php echo $this->lang->line('download'); ?></b></a></center>');
					$("#display_table").html(response);
					$j("#tt").datagrid('reload');					
				}
				
			});
			
			
		});


		$("#is_video").click(function(){
	
		if($(this).is(":checked")){
			$("#limit").val("150");
		}
		else{
			$("#limit").val("");
		}

		});
		
	});
	
	
</script>

<!-- Modal for download -->
<div id="modal_for_download" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#215;</span>
				</button>
				<h4 id="" class="modal-title"><i class="fa fa-cloud-download"></i> <?php echo $this->lang->line('download'); ?></h4>
			</div>

			<div class="modal-body">
				<style>
				.box
				{
					border:1px solid #ccc;	
					margin: 0 auto;
					text-align: center;
					margin-top:10%;
					padding-bottom: 20px;
					background-color: #fffddd;
					color:#000;
				}
				</style>
				<!-- <div class="container"> -->
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
							<div class="box">
							<h2><?php echo $this->lang->line('your file is ready to download'); ?></h2>
							<?php 
								$download_id=$this->session->userdata('download_id');
								echo '<i class="fa fa-2x fa-thumbs-o-up"style="color:black"></i><br><br>';
								echo "<a href='".base_url()."download/location_search/location_search_".$this->user_id."_".$download_id.".csv"."'". "title='Download' class='btn btn-warning btn-lg' style='width:200px;'><i class='fa fa-cloud-download' style='color:white'></i>  ".$this->lang->line('download')."</a>";							
							?>
							</div>		
							
						</div>
					</div>
				<!-- </div>	 -->
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
			</div>
		</div>
	</div>
</div>