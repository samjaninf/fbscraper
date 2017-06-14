<?php $this->load->view('admin/theme/message'); ?>

<div class="alert alert-info text-center">
	<big><a href="https://www.youtube.com/watch?v=ASoR20lszrY&feature=youtu.be" target="_BLANK"><b><?php echo $this->lang->line("how to create mailchimp account?"); ?></b></a></big>
</div>	

<?php 

if(array_key_exists(0,$config_data))
$mailchimp_api_key=$config_data[0]["mailchimp_api_key"]; 
else $mailchimp_api_key="";

if(array_key_exists(0,$config_data))
$mailchimp_list_id=$config_data[0]["mailchimp_list_id"]; 
else $mailchimp_list_id="";

if(array_key_exists(0,$config_data))
$search_limit=$config_data[0]["search_limit"]; 
else $search_limit="";

if(array_key_exists(0,$config_data))
$search_result_display_limit=$config_data[0]["search_result_display_limit"]; 
else $search_result_display_limit="";

if(array_key_exists(0,$config_data))
$subscriber_download_limit=$config_data[0]["subscriber_download_limit"]; 
else $subscriber_download_limit="";

if(array_key_exists(0,$config_data))
$allowed_download_per_email=$config_data[0]["allowed_download_per_email"]; 
else $allowed_download_per_email="";


 ?>
<section class="content-header">
   <section class="content">
     	<div class="box box-info custom_box">
		    	<div class="box-header">
		         <h3 class="box-title"><i class="fa fa-connectdevelop"></i> <?php echo $this->lang->line("lead settings");?></h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->

		    <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url().'admin_config_lead/edit_lead_config';?>" method="POST">
		        <div class="box-body">			       
		        	<div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("mailchimp API key"); ?> 
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="mailchimp_api_key" value="<?php echo $mailchimp_api_key;?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('mailchimp_api_key'); ?></span>
		             		</div>
		            </div>

		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("mailchimp list ID"); ?> 
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="mailchimp_list_id" value="<?php echo $mailchimp_list_id;?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('mailchimp_list_id'); ?></span>
		             		</div>
		            </div>

		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("frontend : maximum how many rows may come into search"); ?> 
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		                		<?php $search_value_list[""]=$this->lang->line("select"); ?>
		               			<?php echo form_dropdown('search_limit',$search_value_list,$search_limit,'class="form-control" id="search_limit"');  ?>
		             			<span class="red"><?php echo form_error('search_limit'); ?></span>
		             		</div>
		            </div>



		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("frontend : maximum how many rows will be displayed"); ?> 
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="search_result_display_limit" value="<?php echo $search_result_display_limit;?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('search_result_display_limit'); ?></span>
		             		</div>
		            </div>

		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("frontend : maximum how many rows can a user download"); ?> 
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="subscriber_download_limit" value="<?php echo $subscriber_download_limit;?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('subscriber_download_limit'); ?></span>
		             		</div>
		            </div>

		            <div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("frontend : how many times a guest user can dowload using same email"); ?> 
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="allowed_download_per_email" value="<?php echo $allowed_download_per_email;?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('allowed_download_per_email'); ?></span>
		             		</div>
		            </div>


		          		                        
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line("Save");?>"/>  
		              			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line("Cancel");?>" onclick='goBack("admin_config_lead/lead_config",1)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>     
     	</div>
   </section>
</section>



