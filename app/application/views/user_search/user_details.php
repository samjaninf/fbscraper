<link href="<?php echo base_url();?>assets/site/css/facebook.css" rel="stylesheet">

<?php 

$name=isset($info['name']) ? $info['name'] : "";			
$link=isset($info['link']) ? $info['link'] : "";				
$picture=json_decode($info['picture'],true); 				
$cover=json_decode($info['cover'],true); 	

if(isset($cover["source"])) 		$cover_source=$cover["source"]; 		else $cover_source=base_url("assets/site/images/cover.jpg");		
if(isset($picture["data"]["url"]))  $pic_source=$picture["data"]["url"]; 	else $pic_source=base_url("assets/site/images/profile.jpg");

?>
<style>
    .total_div{
        padding: 15px;
    }
</style>
<div class="row total_div row-container" >
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 img-container">
		<a href="<?php echo $link; ?>" target="_BLANK">
			<img class="img-cover img-responsive" src="<?php echo $cover_source; ?>" >
			<img class="img-profile img-responsive" src="<?php echo $pic_source; ?>" >
		</a>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-box-container col-left">
		<div class="col-xs-12 col-box">				
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('name');?></b> : <?php echo $name; ?></span> <br/>
			</div>	
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-box-container col-right">		
		<div class="col-xs-12 col-box">
			<div class="layer" style="padding-top:10px !important;">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('link');?></b> : <a target="_BLANK" href="<?php echo $link; ?>"><?php echo $link; ?></a></span> <br/>
			</div>	
		</div>
	</div>

</div>