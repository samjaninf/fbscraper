<?php $this->load->view('admin/theme/message'); ?>

<div class="alert alert-info text-center">
	<?php echo $this->lang->line("please enter google API key and make sure Google Map JavaScript API is enabled."); ?>
	<br><br>
	<big><a href="https://www.youtube.com/watch?v=hny9fSGL2c0&feature=youtu.be" target="_BLANK"><b><?php echo $this->lang->line("how to get google API key?"); ?></b></a></big>

	<br><br>
	<big><a href="https://www.google.com/recaptcha/intro/index.html" target="_BLANK"><b><?php echo $this->lang->line("how to get recaptcha site key and secret key");?></b></a></big></div>	  

<?php 

if(array_key_exists(0,$config_data))
$google_api_key=$config_data[0]["google_api_key"]; 
else $google_api_key="";

if(array_key_exists(0,$config_data))
$recaptcha_site_key=$config_data[0]["recaptcha_site_key"]; 
else $recaptcha_site_key="";

if(array_key_exists(0,$config_data))
$recaptcha_secret_key=$config_data[0]["recaptcha_secret_key"]; 
else $recaptcha_secret_key="";


 ?>
<section class="content-header">
   <section class="content">
     	<div class="box box-info custom_box">
		    	<div class="box-header">
		         <h3 class="box-title"><i class="fa fa-google"></i> <?php echo $this->lang->line("google API settings");?></h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->

		    <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url().'admin_config_connectivity/edit_config';?>" method="POST">
		        

		        <div class="box-body">				              	
		           	<div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("google API key"); ?> *
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="google_api_key" value="<?php echo $google_api_key;?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('google_api_key'); ?></span>
		             		</div>
		            </div>

		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("recaptcha site key"); ?> *
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="recaptcha_site_key" value="<?php echo $recaptcha_site_key;?>"  class="form-control" type="text">	               
		             			<span class="red"><?php echo form_error('recaptcha_site_key'); ?></span>
		             		</div>
		            </div>

		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("recaptcha secret key"); ?> *
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="recaptcha_secret_key" value="<?php echo $recaptcha_secret_key;?>"  class="form-control" type="text">	               
		             			<span class="red"><?php echo form_error('recaptcha_secret_key'); ?></span>
		             		</div>
		            </div>
		           		                        
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line("Save");?>"/>  
		              			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line("Cancel");?>" onclick='goBack("admin_config_connectivity",1)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>     
     	</div>
   </section>
</section>



