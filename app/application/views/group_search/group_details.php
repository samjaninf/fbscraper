<link href="<?php echo base_url();?>assets/site/css/facebook.css" rel="stylesheet">

<?php 

$name=isset($info['name']) ? $info['name'] : "";			
$group_id=isset($info['group_id']) ? $info['group_id'] : "";			
$email=isset($info['email']) ? $info['email'] : "";			
$description=isset($info['description']) ? $info['description'] : "";	
$member_request_count=isset($info['member_request_count']) ? $info['member_request_count'] : "";				
$privacy=isset($info['privacy']) ? $info['privacy'] : "";				
$picture=json_decode($info['picture'],true); 				
$cover=json_decode($info['cover'],true); 				
$owner=json_decode($info['owner'],true); 	

if(isset($cover["source"])) 		$cover_source=$cover["source"]; 		else $cover_source=base_url("assets/site/images/cover.jpg");		
if(isset($picture["data"]["url"]))  $pic_source=$picture["data"]["url"]; 	else $pic_source=base_url("assets/site/images/profile.jpg");		

if(is_array($owner))
{
    array_walk($owner, function(&$value, $key) {
    $key=ucfirst($key);
    $value = "{$key} : {$value}";
    });
    $start_date =  "<br/>".implode('<br>', $owner);
} 
else $start_date="";
$owner="<br/>".$start_date;

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
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('owner');?></b> : <?php echo $owner; ?></span> <br/>
			</div>	
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('email');?></b> : <?php echo $email; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('Requested Member Number');?></b> : <?php echo $member_request_count; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('privacy');?></b> : <?php echo $privacy; ?></span> <br/>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-box-container col-right">		
		<div class="col-xs-12 col-box">
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('group name');?></b> : <?php echo $name; ?></span> <br/>
			</div>	
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('description');?></b> : <br/><br/><?php echo $description; ?></span> <br/>
			</div>
		</div>
	</div>

</div>