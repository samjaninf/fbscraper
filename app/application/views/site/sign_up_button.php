<p>
<?php
	if(isset($default_package[0])) 
	{ 
	    if($default_package[0]['price']=="Trial")
	    $trial_str=$this->lang->line('trial')." : ".$default_package[0]["validity"]." ".$this->lang->line("days");
	    if($default_package[0]['price']=="0")
	    $trial_str=$this->lang->line("for free");
		?>
		<center><a style="color:#000;font-weight: bold;font-size: 22px;padding:12px 25px;text-decoration:none" class="btn btn-lg btn-default" href="<?php echo site_url('home/sign_up'); ?>"><?php echo $this->lang->line("sign up"); ?> - <?php echo $trial_str;?></a></center></p>
	<?php 
	} 
	else 
	{ ?>
		<center><a style="color:#000;font-weight: bold;font-size: 22px;padding:12px 25px;text-decoration:none" class="btn btn-lg btn-default" href="<?php echo site_url('home/sign_up'); ?>"><?php echo $this->lang->line("sign up"); ?></a></center></p>
	<?php
	}
	?>
</p>