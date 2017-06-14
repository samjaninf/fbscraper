<div id="banner" class="banner">
	<div class="banner-image"></div>
	<div class="banner-caption">				
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 object-non-visible" data-animation-effect="fadeIn">
					<h2 class="text-center product_name"> <span> <?php echo $this->config->item('product_name');?></span></h2>
					<p class="lead text-center">
						<?php echo $this->lang->line("catch line"); ?></p>
						<div class="lead text-center form_holder">
							<input type="text" name="page_search" id="page_search" placeholder="<?php echo $this->lang->line('type keyword'); ?>..."/>
							<button id="search" type="submit"> <i class="fa fa-search"></i> </button>						
							<center style="padding-top:60px"><div style="margin:0 auto;" class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key;?>"></div></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- banner end -->


	<!-- section start -->
	<!-- ================ -->

	<div class="space">	</div>
	<?php if($this->is_ad_enabled && $this->is_ad_enabled1) : ?>	
	<div class="add-970-90 hidden-xs hidden-sm"><?php echo $this->ad_content1; ?></div>	
	<div class="add-320-100 hidden-md hidden-lg"><?php echo $this->ad_content1_mobile; ?></div>	
	<?php endif; ?>	

	<div class="section pb-clear" id="feature-section">
		<div class="container-fluid object-non-visible" data-animation-effect="fadeIn">
			<h1 id="features" class="title text-center"><?php echo $this->lang->line("detailed features");?></h1>
			<p class="text-center slogan"><?php echo $this->lang->line("best way to search in facebook"); ?></p>
		
			<div class="row even">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<img src="<?php echo site_url('assets/site/images/page.png');?>" class="img-responsive img-left">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 feature-container">
					<h2 class="navy-blue text-center"><?php echo $this->lang->line("page search"); ?></h2>
					<p>

					</p>
					<div class="quote">
						<div class="quote-content">
							<blockquote>
								<p>
									<?php echo $this->lang->line("page search description") ?>
								</p>
							</blockquote>
						</div> 
						<?php include("application/views/site/sign_up_button.php"); ?>
					</div>
				</div>
			</div>

			<div class="row odd">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<img src="<?php echo site_url('assets/site/images/location.png');?>" class="img-responsive img-left">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 feature-container">
					<h2 class="navy-blue text-center"><?php echo $this->lang->line("page search by location"); ?></h2>
					<p>

					</p>
					<div class="quote">
						<div class="quote-content">
							<blockquote>
								<p>
								<?php echo $this->lang->line("page search by location description") ?>
								</p>
							</blockquote>
						</div> 
						<?php include("application/views/site/sign_up_button.php"); ?>
					</div>
				</div>
			</div>


			<div class="row even">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<img src="<?php echo site_url('assets/site/images/group.png');?>" class="img-responsive img-left">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 feature-container">
					<h2 class="navy-blue text-center"><?php echo $this->lang->line("group search"); ?></h2>
					<p>
						
					</p>
					<div class="quote">
						<div class="quote-content">
							<blockquote>
								<p>
									<?php echo $this->lang->line("group search description") ?>
								</p>
							</blockquote>
						</div> 
						<?php include("application/views/site/sign_up_button.php"); ?>
					</div>
				</div>
			</div>

			<div class="row odd">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<img src="<?php echo site_url('assets/site/images/event.png');?>" class="img-responsive img-left">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 feature-container">
					<h2 class="navy-blue text-center"><?php echo $this->lang->line("event search"); ?></h2>
					<p>
					
					</p>
					<div class="quote">
						<div class="quote-content">
							<blockquote>
								<p>
									<?php echo $this->lang->line("event search description") ?>
								</p>
							</blockquote>
						</div> 
						<?php include("application/views/site/sign_up_button.php"); ?>
					</div>
				</div>
			</div>


			<div class="row even">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<img src="<?php echo site_url('assets/site/images/user.png');?>" class="img-responsive img-left">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 feature-container">
					<h2 class="navy-blue text-center"><?php echo $this->lang->line("user search"); ?></h2>
					<p>

					</p>
					<div class="quote">
						<div class="quote-content">
							<blockquote>
								<p>
									<?php echo $this->lang->line("user search description") ?>
								</p>
							</blockquote>
						</div> 
						<?php include("application/views/site/sign_up_button.php"); ?>
					</div>
				</div>
			</div>


			<div class="row odd">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<img src="<?php echo site_url('assets/site/images/insight.png');?>" class="img-responsive img-left">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 feature-container">
					<h2 class="navy-blue text-center"><?php echo $this->lang->line("facebook page insight"); ?></h2>
					<p>

					</p>
					<div class="quote">
						<div class="quote-content">
							<blockquote>
								<p>
									<?php echo $this->lang->line("page insight description") ?>
								</p>
							</blockquote>
						</div> 
						<?php include("application/views/site/sign_up_button.php"); ?>
					</div>
				</div>
			</div>



		</div>			
	</div>
	<!-- section end -->


	<!-- section start -->
	<!-- ================ -->
	<div class="space"></div>
	<div class="space"></div>
	<h1 id="pricing" class="title text-center"><?php echo $this->lang->line("pricing"); ?></h1>
	<p class="text-center slogan"><?php echo $this->lang->line('awesome features in reasonable price'); ?></p>
	<hr>

	<div class="container-fluid">
		<div class="space"></div>
		<div class="row">
			<div class="col-xs-12">
				<?php include("application/views/site/sign_up_button.php"); ?>
			</div>
		</div>

		<div class="row" >
			<?php 
			$i=0;
			$classes=array(1=>"tiny",2=>"small",3=>"medium",4=>"pro");
			foreach($payment_package as $pack)
			{ 	
				$i++;	
				?>
				<div class="col-xs-12 col-sm-6 col-md-3" style="padding-left:5px;padding-right:5px;height:400px;">
					<div class="<?php echo $classes[$i]; ?>">
						<div class="pricing-table-header-<?php echo $classes[$i]; ?> text-center">
							<h2><?php echo $pack["package_name"]?></h2>
							<h3><?php echo $currency; ?> <?php echo $pack["price"]?> / <?php echo $pack["validity"]?> <?php echo $this->lang->line("days");?></h3>
						</div>
						<div class="pricing-table-features" style="text-align:left !important;padding-left:3px;">
							<?php 
							$module_ids=$pack["module_ids"];
							$monthly_limit=json_decode($pack["monthly_limit"],true);
							$module_names_array=$this->basic->execute_query('SELECT module_name,id FROM modules WHERE FIND_IN_SET(id,"'.$module_ids.'") > 0  ORDER BY module_name ASC');  

							foreach ($module_names_array as $row) 
							{
								$limit=0;
								$limit=$monthly_limit[$row["id"]];
								if($limit=="0") $limit2="<b>".$this->lang->line("unlimited")."</b>";
								else $limit2=$limit;
								if($row["id"]!="1" && $limit!="0") $limit2="<b>".$limit2."/".$this->lang->line("month")."</b>";
								echo "<i class='fa fa-check'></i> ".$this->lang->line($row["module_name"]);
								if($row["id"]!="13" && $row["id"]!="14" && $row["id"]!="16") echo " : <b>". $limit2."</b>"."<br>";
								else echo "<br>";
							}
							?>
						</div>
						<div class="pricing-table-signup-<?php echo $classes[$i]; ?>">
							<p><center><a href="<?php echo site_url('home/sign_up'); ?>"><?php echo $this->lang->line("sign up"); ?></a></center></p>
						</div>
					</div>
				</div>

				<?php
				if($i%4==0) break;
			}?>
		</div>
	</div>
	<!-- section end -->



	<!-- section start -->
	<!-- ================ -->
	<div class="space"></div>
	<div class="space"></div>
	<div class="space"></div>
	<div class="space"></div>
	<div class="space"></div>
	<h1 id="latest_search_report" class="title text-center"><?php echo $this->lang->line("latest search report"); ?></h1>
	<p class="text-center slogan"><?php echo $this->lang->line('have a look what other users searched for'); ?></p>
	<hr>

	<div class="container-fluid">
		<div class="space"></div>
		<div class="row" >	
		<?php 

			$part1=
			'<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 add-300-250">';
				if($this->is_ad_enabled2) $part1.=$this->ad_content2;
				if($this->is_ad_enabled3) $part1.="<div style='margin-top:100px'></div>".$this->ad_content3;
			$part1.='</div>';

			$part2=
			'<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 add-300-600">';
				if($this->is_ad_enabled4) $part2.=$this->ad_content4;
			$part2.='</div>';

			$table_data='<table class="table table-striped table-hover table-bordered">
					<tr>
						<th>'.$this->lang->line("sl").'</th>
						<th>'.$this->lang->line("keyword").'</th>
						<th>'.$this->lang->line("last searched at").'</th>
						<th>'.$this->lang->line("total page found").'</th>
					</tr>';
					$i=0;
					foreach($recent_search as $row) 
					{
						$i++;
						$table_data.="<tr>";
							$table_data.="<td>";
								$table_data.=$i;
							$table_data.="</td>";
							$table_data.="<td>";
								$table_data.=$row['search_keyword'];
							$table_data.="</td>";
							$table_data.="<td>";
								$table_data.=$row['searched_at'];
							$table_data.="</td>";
							$table_data.="<td>";
								$table_data.=$row['total_count'];
							$table_data.="</td>";
						$table_data.="</tr>";
					}
				$table_data.='</table></div>';

			if($this->is_ad_enabled && ($this->is_ad_enabled2 || $this->is_ad_enabled3 || $this->is_ad_enabled4)) // 2/3/4 position add are enabled
			{
				if(($this->is_ad_enabled2 || $this->is_ad_enabled3) && !$this->is_ad_enabled4) // one or both 300x250 is enabled, not 300x600
				{
					$div_positioning=$part1.'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 table-responsive">'.$table_data;
				}

				else if((!$this->is_ad_enabled2 && !$this->is_ad_enabled3) && $this->is_ad_enabled4) // no 300x250 is enabled, 300x600 is enabled
				{
					$div_positioning='<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 table-responsive">'.$table_data.$part2;
				}
				else
				{
					$div_positioning=$part1.'<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 table-responsive">'.$table_data.$part2;
				}	
			}
			else // no displayable add is not enabled
			{
				$div_positioning='<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 table-responsive">'.$table_data;
			}

		?>	
			

			<?php echo $div_positioning; ?> <!-- col div starts here using php variable -->
				
		</div>
	</div>
	<!-- section end -->

	
	<?php echo $this->load->view("site/contact.php"); ?>

	<script type="text/javascript">

		function get_bulk_progress()
		{
			var base_url="<?php echo base_url(); ?>";			
			$.ajax({
				url:base_url+'home/bulk_page_search_progress_count',
				type:'POST',
				dataType:'json',
				success:function(response){
					var search_completed=response.search_completed;
					var search_counting=response.search_counting;
					var page_search_keyword=response.page_search_keyword;
					var keyword_str="<?php echo $this->lang->line('keyword');?> : "+page_search_keyword+" - ";

					if(search_counting)
						$("#progress_msg_text").html(keyword_str+search_counting+" <?php echo $this->lang->line('results found') ?><hr/>");

					if(search_completed == 1) 
					{
						$("#progress_msg_text").html(keyword_str+search_counting+" <?php echo $this->lang->line('results found') ?><hr/>");

						clearInterval(interval);
					}				

				}
			});		
		}

		var interval="";


		$j(document).ready(function() {

			var base_url="<?php echo base_url(); ?>";

			$("#search").on('click',function(){

				var keyword = $("#page_search").val();

				if(keyword == '')
				{
					alert("<?php echo $this->lang->line('you have not enter any Keyword'); ?>");
					return false;
				}

				var captcha_val= $("[name='g-recaptcha-response']").val();
				if(captcha_val == '')
				{
					alert("<?php echo $this->lang->line('you have not enter captcha'); ?>");
					return false;
				}

				$("#progress_msg_text").html("0  <?php echo $this->lang->line('results found') ?><hr/>");				
				interval=setInterval(get_bulk_progress, 10000);

				$("#success_msg").html("<center><h3 style='color:olive;'><?php echo $this->lang->line('please wait'); ?></h3></center>");
				$("#progress_msg_text").html("");	
				$("#download_div").hide("");	
				$("#new_search_div").hide("");	
				$("#subscribe_div").hide("");	
				$("#demo_search").modal({backdrop: 'static', keyboard: false});			

				// $("#success_msg").html('<img class="center-block" src="'+base_url+'assets/pre-loader/custom.gif" alt="Processing..."><br/>');
							
				$("#display_table").html('<img class="center-block" src="'+base_url+'assets/pre-loader/custom_lg.gif" alt="Processing..."><br/>');
				$("#display_table").css('border','none');
				$.ajax({
					url:base_url+'home/page_search_action',
					type:'POST',
					data:{keyword:keyword,captcha_val:captcha_val},
					success:function(response){			
						if(response=="0")
						{
							$("#new_search_div").show("");
							$("#success_msg").html("<center><h3 style='color:olive;'><?php echo $this->lang->line('completed'); ?></h3></center>");
							$("#display_table").html("<div class='alert alert-warning text-center' style='border-radius:0;'><?php echo $this->lang->line('no data found'); ?></div>");		
							$("#new_search_div").html("<a class='pull-left btn btn-primary btn-lg' href='<?php echo site_url(); ?>' ><i class='fa fa-search'></i> <?php echo $this->lang->line('new search'); ?></a>");
						}
						else
						{
							$("#download_div").show("");
							$("#new_search_div").show("");
							$("#success_msg").html("<center><h3 style='color:olive;'><?php echo $this->lang->line('completed'); ?></h3></center>");
							$("#download_div").html("<a class='pull-right btn btn-warning btn-lg' id='download_list'><i class='fa fa-download'></i> <?php echo $this->lang->line('download full list'); ?></a>");
							$("#new_search_div").html("<a class='pull-left btn btn-primary btn-lg' href='<?php echo site_url(); ?>' ><i class='fa fa-search'></i> <?php echo $this->lang->line('new search'); ?></a>");
							$("#display_table").css('border','1px solid #ccc');
							$("#display_table").html(response);		
						}
					}

				});


			});

			$(document).on('click','#download_list',function(){
				$("#subscribe_div").css("display","block");
			});

			$('#demo_search').on('hidden.bs.modal', function () { 
				var link="<?php echo site_url(); ?>"; 
				window.location.assign(link); 
			})


			$(document).on('click','#send_email',function(){
				var email=$("#email").val();
				var name=$("#name").val();

				if(email=="" || name=="") 
				{
					alert("<?php echo $this->lang->line('something is missing'); ?>");
					return;
				}

				$("#send_email_message").hide();
				$("#success_msg").html('<img class="center-block" src="'+base_url+'assets/pre-loader/custom.gif" alt="Processing..."><br/>');

				var sign_up="<br/><a target='_BLANK' href='"+base_url+"home/sign_up'><?php echo $this->lang->line('sign up to get access to all our awesome features'); ?></a>";
				$.ajax({
				url:base_url+'home/send_download_link',
				type:'POST',
				data:{email:email,name:name},
				success:function(response){
					$("#success_msg").html("<center><h3 style='color:olive;'><?php echo $this->lang->line('completed'); ?></h3></center>");
					$("#send_email_message").show();

					if(response=="0")
					{
						$("#send_email_message").removeClass('alert-info');
						$("#send_email_message").removeClass('alert-success');
						$("#send_email_message").addClass('alert-danger');
						$("#send_email_message").html("<?php echo $this->lang->line('you can not download more result using this email, download quota is crossed'); ?>."+sign_up);
					}					
					else
					{
						$("#send_email_message").removeClass('alert-info');
						$("#send_email_message").removeClass('alert-danger');
						$("#send_email_message").addClass('alert-success');
						$("#send_email_message").html("<?php echo $this->lang->line('a email has been sent to your email'); ?>" + sign_up);
					}
				}
			});


			});

		});
	</script>

	<div class="modal fade" id="demo_search">
		<div class="modal-dialog modal-lg" style="width: 100%;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-close fa-2x"></i> </button>
					<h4 class="modal-title"> <i class="fa fa-search"></i> <?php echo $this->lang->line('page search'); ?></h4>
				</div>
				<div class="modal-body clearfix">
					<div id="success_msg" class='col-xs-12'></div>					
					<div class='col-xs-12 no-padding'>
						<center><h3 id="progress_msg_text" style='color:olive;'></h3></center>
					</div>
					<br/>
					<div class='col-xs-6 no-padding' id="new_search_div"></div>
					<div id="download_div" class='col-xs-6 no-padding'></div>
					<div id="subscribe_div" class='col-xs-12' style="display:none;">
						<div class="col-xs-12">
							<div class="alert alert-info text-center" id="send_email_message"><?php echo $this->lang->line('the download link will be sent to your email'); ?></div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<input type="text" class="form-control" id="name" required placeholder="<?php echo $this->lang->line('your name'); ?> *">
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<input type="text" class="form-control" id="email" required placeholder="<?php echo $this->lang->line('your email'); ?> *">
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<input type="button" class="btn btn-primary btn-lg" id="send_email" value="<?php echo $this->lang->line('send report'); ?>">
						</div>
						<?php if($this->is_ad_enabled && $this->is_ad_enabled1) : ?>	
						<div class="add-970-90 hidden-xs hidden-sm"><?php echo $this->ad_content1; ?></div>	
						<div class="add-320-100 hidden-md hidden-lg"><?php echo $this->ad_content1_mobile; ?></div>	
						<?php endif; ?>	
					</div>
					<div id="display_table" class="table-responsive col-xs-12 no-padding" style="margin-top:50px;max-height: 500px;min-height:180px;overflow-y: auto;"></div>
				</div>
			</div>
		</div>
	</div>




