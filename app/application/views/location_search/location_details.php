<link href="<?php echo base_url();?>assets/site/css/facebook.css" rel="stylesheet">

<?php 
$name=isset($info['name']) ? $info['name']:''; 
$page_id=isset($info['location_id']) ? $info['location_id']:'';
$phone=isset($info['phone']) ? $info['phone']:''; 
$website=isset($info['website']) ? $info['website']:'';
$link=isset($info['link']) ? $info['link']:''; 	
$about=isset($info['about']) ? $info['about']:'';
$founded=isset($info['founded']) ? $info['founded']:'';
$category=isset($info['category']) ? $info['category']:''; 	
$searched_at=isset($info['searched_at']) ? $info['searched_at']:'';
$talking_about_count=isset($info['talking_about_count']) ? $info['talking_about_count']:'';
$fan_count=isset($info['fan_count']) ? $info['fan_count']:''; 
$likes=json_decode($info['likes'],true); 
$location=json_decode($info['location'],true);
$posts=json_decode($info['posts'],true); 				
$picture=json_decode($info['picture'],true); 				
$cover=json_decode($info['cover'],true); 	
if($info['video']!="")	
$video=json_decode($info['video'],true); 
else $video=array();  				

if(isset($cover["source"])) 		$cover_source=$cover["source"]; 		else $cover_source=base_url("assets/site/images/cover.jpg");		
if(isset($picture["data"]["url"]))  $pic_source=$picture["data"]["url"]; 	else $pic_source=base_url("assets/site/images/profile.jpg");		

if(is_array($location))
{
	array_walk($location, function(&$value, $key) {
	$key=ucfirst($key);
    $value = "{$key} : {$value}";
	});
	$location =  "<br/>".implode('<br>', $location);
}
else $location="";


if(isset($start_info["type"])) $start_type=$start_info["type"]; else $start_type="";
if(isset($start_info["date"]) && is_array($start_info["date"]))
{
	array_walk($start_info["date"], function(&$value, $key) {
	$key=ucfirst($key);
    $value = "{$key} : {$value}";
	});
	$start_date =  "<br/>".implode('<br>', $start_info["date"]);
} 
else $start_date="";
$start_info="<br/><br/>Type: ".$start_type." <br/> Stared at : ".$start_date;
?>
<style>
    .cover_image{
        height: 315px;
        width: 851px;
    }
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
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('Name');?></b> : <?php echo $name; ?></span> <br/>
			</div>
			<!-- <div class="layer">
				<i class="fa fa-star"></i> <span><b>Username</b> : <?php echo $username; ?></span> <br/>
			</div> -->
			<div class="layer">
                <i class="fa fa-star"></i> <span><a target="_blank" href="<?php echo $website; ?>"><b><?php echo $this->lang->line('Website');?></b> : <?php echo $website; ?></a></span> <br/>
            </div>
			<!-- <div class="layer">
				<i class="fa fa-star"></i> <span><b>Email</b> : <?php echo $emails; ?></span> <br/>
			</div> -->
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('Phone');?></b> : <?php echo $phone; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('Category');?></b> : <?php echo $category; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('Location');?></b> : <br/><?php echo $location; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('Founded');?></b> : <?php echo $founded; ?></span> <br/>
			</div>
			<!-- <div class="layer">
				<i class="fa fa-star"></i> <span><b>Start Info</b> : <?php echo $start_info; ?></span> <br/>
			</div> -->
			<!-- <div class="layer">
				<i class="fa fa-star"></i> <span><b>Mission</b> : <br/><br/><?php echo $mission; ?></span> <br/>
			</div> -->
			<div class="layer">
				<i class="fa fa-star"></i> <span><b><?php echo $this->lang->line('About');?></b> : <br/><br/><?php echo $about; ?></span> <br/>
			</div>			    		
			<div class="layer">
				<i class="fa fa-star"></i> <span><?php echo $talking_about_count; ?><?php echo ' ', $this->lang->line('people were talking about');?> </span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> <span> <b><?php echo $this->lang->line('Likes');?>: </b> <?php echo $fan_count; ?></span> <br/>
			</div>
			<div class="layer">
				<i class="fa fa-star"></i> 
				<span>
					<b><?php echo $this->lang->line('Liked Pages');?></b> : <br/><br/>
					<ul>
						<?php 
						if(isset($likes["data"]))
						{
							foreach($likes["data"] as $like)
							{
								echo "<li><a terget='_BLANK' href='".$like['link']."'>".$like['name']."</a></li>";
							}
						}
						?>						
					</ul>
				</span> 
				<br/>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-box-container col-right">		
		<?php 
		if(isset($posts["data"])) 
		{ 
			foreach($posts["data"]as $post)
			{ ?>
				<div class="col-xs-12 col-box">
					<img src="<?php echo $pic_source;?>" class="img-pic-thumbail">
					<span class="publish-time"> published at  <?php echo $post["created_time"];?></span><br/>
					<a target="_BLANK" href="<?php echo $post["permalink_url"];?>">
						<?php if(isset($post["picture"])) 
						{ ?>
							<img src="<?php echo $post["picture"];?>" class="post-thumbnail">
						<?php
						} ?>		    		
						<p class="post-description">
							<?php if(isset($post["message"])) echo $post["message"];?>
						</p>	
					</a>

					<?php if(isset($post["shares"]["count"])) 
					{ ?>			    		
						<i class="fa fa-share pull-right share-count"> <?php echo $post["shares"]["count"];?> <?php echo $this->lang->line('shares');?></i>
					<?php
					} ?>

				</div> 	<?php
			}
		}
		?>    	
			

	</div>

</div>






<div class="row total_div row-container">
    <div class="col-xs-12 col-sm-12 col-box-container">
        <div class="col-xs-12 col-box text-center">
              <h2><i class="fa fa-camera"></i> <?php echo $this->lang->line("videos");?></h2>
        </div>
    </div>
    <?php
    if(count($video)==0) echo '<div class="col-xs-12 col-sm-12 col-box-container"><div class="col-xs-12 col-box text-center">'.$this->lang->line("no data found").'</div></div>';
    $i=0;
    if(is_array($video))
    foreach ($video as $value) 
    {
        $i++;

        if(($i+1)%2==0) echo '<div class="row"  style="margin:0 5px;">';

        echo '
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-box-container">
            <div class="col-xs-12 col-box overflow-x">';
                echo "<br/>";
                if(isset($value["description"]))
                echo "<center>".substr($value["description"], 0, 200).'...'."</center>";
                echo "<br/>";
                echo "<br/>";
                if(isset($value["embed_html"]))
                echo "<center>".$value["embed_html"]."</center><br/>";
            echo 
            '</div>
        </div>';  

        if($i%2==0) echo '</div>';      
    }

    if((count($video)+1)%2==0) echo "</div>";
    ?>
</div>