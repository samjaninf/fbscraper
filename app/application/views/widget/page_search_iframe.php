<section class="content-header">
   <section class="content">
 		<div class="box box-info custom_box">
	    	<div class="box-header">
	         <h3 class="box-title"><i class="fa fa-code"></i> <?php echo $this->lang->line('get widget embed code');?></h3>
	        </div><!-- /.box-header -->
	       		<!-- form start -->
	
	        <div class="box-body">
	        	<span class="label label-success" style="font-weight:400"><?php echo $this->lang->line("copy the html code, put it in the websites's html and let website users to use awesome facebook page search"); ?></span>
				<textarea style="width:100%">&lt;iframe style="border: <?php echo $info[0]['border'];?>;" height="<?php echo $info[0]['height'];?>" width="<?php echo $info[0]['width'];?>"  src="<?php echo site_url('widget/page_search_widget').'/'.$info[0]['user_id'].'/'.$info[0]['id']; ?>"&gt;&lt;/iframe&gt;</textarea>
	        </div> <!-- /.box-body -->       
	    </div><!-- /.box-info -->   
   </section>
</section>
<section class="content-header">
   <section class="content">
 		<div class="box box-info custom_box">
	    	<div class="box-header">
	         <h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('widget preview');?></h3>
	        </div><!-- /.box-header -->
	       		<!-- form start -->
	
	        <div class="box-body">	           
	         		 <span class="label label-success" style="font-weight:400"><?php echo $this->lang->line("how the widget will look in to your website?").$this->lang->line("have a look"); ?></span>

	         		 <iframe style="border: <?php echo $info[0]['border'];?>;" height="<?php echo $info[0]['height'];?>" width="<?php echo $info[0]['width'];?>"  src="<?php echo site_url('widget/page_search_widget').'/'.$info[0]['user_id'].'/'.$info[0]['id']; ?>"></iframe>               
	        </div> <!-- /.box-body -->       
	    </div><!-- /.box-info -->   
   </section>
</section>