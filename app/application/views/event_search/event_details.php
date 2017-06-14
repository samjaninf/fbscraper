<link href="<?php echo base_url();?>assets/site/css/facebook.css" rel="stylesheet">

<?php 
$name=isset($info['name']) ? $info['name'] : "";			
$event_id=isset($info['event_id']) ? $info['event_id'] : "";			
$description=isset($info['description']) ? $info['description'] : "";	
$searched_at=isset($info['searched_at']) ? $info['searched_at'] : "";		
$start_time=isset($info['start_time']) ? $info['start_time'] : "";		
$attending_count=isset($info['attending_count']) ? $info['attending_count'] : "";		
$declined_count=isset($info['declined_count']) ? $info['declined_count'] : "";		
$interested_count=isset($info['interested_count']) ? $info['interested_count'] : "";		
$maybe_count=isset($info['maybe_count']) ? $info['maybe_count'] : "";		
$noreply_count=isset($info['noreply_count']) ? $info['noreply_count'] : "";		
$timezone=isset($info['timezone']) ? $info['timezone'] : "";		
$type=isset($info['type']) ? $info['type'] : "";		
$can_guests_invite=isset($info['can_guests_invite']) ? $info['can_guests_invite'] : "0";		
$location=json_decode($info['place'],true); 				
$picture=json_decode($info['picture'],true); 				
$cover=json_decode($info['cover'],true); 				
$owner=json_decode($info['owner'],true); 	

if(isset($cover["source"])) 		$cover_source=$cover["source"]; 		else $cover_source=base_url("assets/site/images/cover.jpg");		
if(isset($picture["data"]["url"]))  $pic_source=$picture["data"]["url"]; 	else $pic_source=base_url("assets/site/images/profile.jpg");		


if(isset($location["name"])) $loc_name=$location["name"]; else $loc_name="";

if(isset($location["location"]) && is_array($location["location"]))
{
	array_walk($location["location"], function(&$value, $key) {
	$key=ucfirst($key);
    $value = "{$key} : {$value}";
	});
	$place =  "<br/>".implode('<br>', $location["location"]);
}
else $place="";

$place_final=$loc_name."<br/>".$place;
?>
<style>
    .total_div{
        padding: 15px;
    }
</style>
<div class="row total_div row-container" >
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 img-container">
		<a href="" target="_BLANK">
			<img class="img-cover img-responsive" src="<?php echo $cover_source; ?>" >
			<img class="img-profile img-responsive" src="<?php echo $pic_source; ?>" >
		</a>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-box-container col-left">
		<div class="col-xs-12 col-box">				
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('event name');?></b> : <?php echo $name; ?></span> <br/>
			</div>	
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('start info');?></b> : <?php echo $start_time; ?></span> <br/>
			</div>	
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('attending');?></b> : <?php echo $attending_count; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('interested');?></b> : <?php echo $interested_count; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('may be attend');?></b> : <?php echo $maybe_count; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('declined');?></b> : <?php echo $declined_count; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('category');?></b> : <?php echo $type; ?></span> <br/>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-box-container col-right">		
		<div class="col-xs-12 col-box">					
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('location');?></b> : <?php echo $place_final; ?></span> <br/>
			</div>				<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('description');?></b> : <br/><br/><?php echo $description; ?></span> <br/>
			</div>
		</div>
	</div>

</div>






