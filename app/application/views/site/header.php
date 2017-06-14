<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo $this->config->item('product_name')." | ".$this->lang->line("slogan");?></title>
	<meta name="description" content="complete visitor and seo analytics">
	<meta name="author" content="<?php echo $this->config->item('institute_address1');?>">

	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php echo $this->load->view("site/css_include_site.php"); ?>
	<?php echo $this->load->view("site/js_include_site.php"); ?>

	<script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body class="no-trans">
	<!-- scrollToTop -->
	<!-- ================ -->
	<div class="scrollToTop"><i class="icon-up-open-big"></i></div>

	<!-- header start -->
	<!-- ================ --> 
	<header class="header fixed clearfix navbar navbar-fixed-top">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-7 col-sm-9 col-md-4 col-lg-4">

					<!-- header-left start -->
					<!-- ================ -->
					<div class="header-left clearfix">

						<!-- logo -->
						<div class="logo smooth-scroll">
							<a href="#banner"><img id="logo" style="max-height:50px !important;max-width:170px!important" src="<?php echo base_url();?>assets/images/logo.png" alt="<?php echo $this->config->item('product_name');?>"></a>
						</div>


					</div>
					<!-- header-left end -->

				</div>

				<div class="col-xs-5 col-sm-3 col-md-4 col-lg-4 hidden-md hidden-lg">
					<?php 
					$select_lan=$this->language;
					$select_id="countries";
					?>
					<?php include("application/views/site/language.php"); ?>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

					<!-- header-right start -->
					<!-- ================ -->
					<div class="header-right clearfix">

						<!-- main-navigation start -->
						<!-- ================ -->
						<div class="main-navigation animated">

							<!-- navbar start -->
							<!-- ================ -->
							<nav class="navbar navbar-default" role="navigation">
								<div class="container-fluid">

									<!-- Toggle get grouped for better mobile display -->
									<div class="navbar-header">
										<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1" style="margin-top:25px;">
											<span class="sr-only">Toggle navigation</span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</button>
									</div>

									<!-- Collect the nav links, forms, and other content for toggling -->
									<div class="collapse navbar-collapse scrollspy smooth-scroll" id="navbar-collapse-1">
										<ul class="nav navbar-nav navbar-right">
											<li class="active"><a href="#banner"><?php echo $this->lang->line("home"); ?></a></li>
											<li><a href="#pricing"><?php echo $this->lang->line("pricing"); ?></a></li>
											<li><a href="#latest_search_report"><?php echo $this->lang->line("latest search report"); ?></a></li>
											<li><a href="#contact"><?php echo $this->lang->line("contact"); ?></a></li>
											<li><a href="<?php echo site_url('home/login'); ?>"><?php echo $this->lang->line("login"); ?></a></li>
											<?php if($this->session->userdata("logged_in")!=1) 
											{?>
												<li><a href="<?php echo site_url('home/sign_up'); ?>"><?php echo $this->lang->line("sign up"); ?></a></li>
												<?php 
											} 
											else
												{ ?>
													<li><a href="<?php echo site_url('home/logout'); ?>"><?php echo $this->lang->line("logout"); ?></a></li>
													<?php
												} ?>	
											</ul>
										</div>
									</div>
								</nav><!-- navbar end -->
							</div><!-- main-navigation end -->
						</div><!-- header-right end -->
					</div>

					<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 hidden-xs hidden-sm">
						<?php 
						$select_id="countries2";
						include("application/views/site/language.php"); 
						?>
					</div>
				</div>
			</div>
		</header>
		<!-- header end -->
