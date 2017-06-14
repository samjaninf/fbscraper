<div class="container-fluid">	
	<div class="well text-center" style="margin-top:5px;padding:10px 0 8px 0 !important"><p style="color: #55AAFF; font-size: 28px; font-weight: bold;"><?php echo $this->lang->line("Recent Activities"); ?></p></div>
	<?php if($this->session->userdata("user_type")=="Member") {?>
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<div class="info-box bg-aqua">
				<span class="info-box-icon"><i class="fa fa-cube"></i></span>
				<div class="info-box-content">
					<!-- <span class="info-box-text">Inventory</span> -->
					<span class="info-box-number">
					   <?php if($price=="Trial") $price=0; ?>
					   <?php echo $package_name;?> @
					   <?php echo $payment_config[0]['currency']; ?> <?php echo $price;?> /
					   <?php echo $validity;?> <?php echo $this->lang->line("days")?>	
					</span>
					<div class="progress">
						<div style="width: 70%" class="progress-bar"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("package name")?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div>	
		</div>
		<div class="col-xs-12 col-md-6">
			<div class="info-box bg-blue">
				<span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
				<div class="info-box-content">
					<!-- <span class="info-box-text">Inventory</span> -->
					<span class="info-box-number">
					    <?php echo date("Y-m-d",strtotime($this->session->userdata("expiry_date"))); ?>
					</span>
					<div class="progress">
						<div style="width: 70%" class="progress-bar"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("expired date")?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div>	
		</div>
	</div>
	<?php } ?>
	
	<div class="row" style="">
		<?php if($this->session->userdata("user_type")=="Member") {?>
		<div class="col-xs-12 col-sm-12">
			<div class="box box-warning box-solid">
				<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-search-plus"></i> <?php echo $this->lang->line("Total Search Vs Result Found (Today's Report)"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<input type="hidden" id="bar_chart_data" value='<?php if(isset($bar_chart_data)) echo $bar_chart_data; ?>'/>

					<div class="col-xs-12">
						<div class="row">
							<div class="chart">
								<div class="chart" id="dashboard_bar_chart" style="height: 230px;"></div>
							</div>
						</div><!-- /.row -->
					</div>
					
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>


		<div class="col-xs-12 col-sm-12" style="display: none;">
			<div class="box box-warning box-solid">
				<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-envelope"></i> <?php echo $this->lang->line("Total Collected Emails (Today's Report)"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body chart-responsive">
					<input type="hidden" id="total_email_found" value='<?php if(isset($total_email_found)) echo $total_email_found; ?>'/>

					<div class="col-xs-12">
						<div class="row">
							<div class="col-md-7 col-xs-12">
								<div class="chart-responsive">
									<canvas id="total_email_found_pieChart" height="220"></canvas>
								</div><!-- ./chart-responsive -->
							</div><!-- /.col -->
							<div class="col-md-5 col-xs-12" style="padding-top:35px;">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o" style="color: #F39C12;"></i> <?php echo $this->lang->line("emails from page search"); ?> (<?php echo $page_search_emails; ?>)</li>
									<li><i class="fa fa-circle-o" style="color: #22264b;"></i> <?php echo $this->lang->line("emails from guest search"); ?> (<?php echo $page_search_emails_guest; ?>)</li>									
									<li><i class="fa fa-circle-o" style="color: #b56969;"></i> <?php echo $this->lang->line("emails from guest user"); ?> (<?php echo $lead_emails; ?>)</li>
								</ul>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>

		<?php } else { ?>

		<div class="col-xs-12 col-sm-12">
			<div class="box box-warning box-solid">
				<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-search-plus"></i> <?php echo $this->lang->line("Total Search Vs Result Found (Today's Report)"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<input type="hidden" id="bar_chart_data" value='<?php if(isset($bar_chart_data)) echo $bar_chart_data; ?>'/>

					<div class="col-xs-12">
						<div class="row">
							<div class="chart">
								<div class="chart" id="dashboard_bar_chart" style="height: 230px;"></div>
							</div>
						</div><!-- /.row -->
					</div>
					
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>

		<div class="col-xs-12 col-sm-12">
			<div class="box box-warning box-solid">
				<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-envelope"></i> <?php echo $this->lang->line("Total Collected Emails (Today's Report)"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body chart-responsive">
					<input type="hidden" id="total_email_found" value='<?php if(isset($total_email_found)) echo $total_email_found; ?>'/>

					<div class="col-xs-12">
						<div class="row">
							<div class="col-md-7 col-xs-12">
								<div class="chart-responsive">
									<canvas id="total_email_found_pieChart" height="220"></canvas>
								</div><!-- ./chart-responsive -->
							</div><!-- /.col -->
							<div class="col-md-5 col-xs-12" style="padding-top:35px;">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o" style="color: #F39C12;"></i> <?php echo $this->lang->line("emails from page search"); ?> (<?php echo $page_search_emails; ?>)</li>
									<li><i class="fa fa-circle-o" style="color: #22264b;"></i> <?php echo $this->lang->line("emails from guest search"); ?> (<?php echo $page_search_emails_guest; ?>)</li>									
									<li><i class="fa fa-circle-o" style="color: #b56969;"></i> <?php echo $this->lang->line("emails from guest user"); ?> (<?php echo $lead_emails; ?>)</li>
								</ul>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>

		<?php } ?>

	</div> <!-- end of row -->



	<!-- /////////////////////////// -->

	<div class="row">		

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">			
			<div class="box" style="border-top: 3px solid #3C8DBC;">
				<div class="box-header with-border">
					<h3 class="box-title" style="color: #198EC8"><i class="fa fa-file-o" style="color: #E05A17;"></i> <?php echo $this->lang->line("Page Search"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<?php 
						if(empty($page_search)) echo "<h3 class='text-center'>".$this->lang->line("no data found")."</h3>";
						else {
					?>

					<table class="table table-hover table-striped">
						<tr>
							<th><?php echo $this->lang->line("Keyword"); ?></th>
							<th><?php echo $this->lang->line("Name"); ?></th>
							<th><?php echo $this->lang->line("Details"); ?></th>
						</tr>
						<?php $i=0; foreach($page_search as $value): ?>
							<tr>
								<td><?php echo $value['search_keyword']; ?></td>
								<td><?php echo $value['name']; ?></td>
								<td><a target="_blank" href="<?php echo base_url('page_search/page_details').'/'.$value['id']; ?>"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Details"); ?></a></td>
							</tr>
						<?php $i++; if($i==10) break; endforeach; ?>
					</table>
					<?php } ?>
					<div class="text-center" style="margin-top: 5px;"><span class="label label-primary"><a href="<?php echo base_url('page_search/index'); ?>" style="color: white" target="_blank"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line("more info"); ?></a></span></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->			
		</div>

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">			
			<div class="box" style="border-top: 3px solid #3C8DBC;">
				<div class="box-header with-border">
					<h3 class="box-title" style="color: #198EC8"><i class="fa fa-user" style="color: #E05A17;"></i> <?php echo $this->lang->line("User Search"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php 
						if(empty($user_search)) echo "<h3 class='text-center'>".$this->lang->line("no data found")."</h3>";
						else {
					?>

					<table class="table table-hover table-striped">
						<tr>
							<th><?php echo $this->lang->line("Keyword"); ?></th>
							<th><?php echo $this->lang->line("Name"); ?></th>
							<th><?php echo $this->lang->line("Details"); ?></th>
						</tr>
						<?php $i=0; foreach($user_search as $value): ?>
							<tr>
								<td><?php echo $value['search_keyword']; ?></td>							
								<td><?php echo $value['name']; ?></td>	
								<td><a target="_blank" href="<?php echo base_url('user_search/user_details').'/'.$value['id']; ?>"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Details"); ?></a></td>						
							</tr>
						<?php $i++; if($i==10) break; endforeach; ?>
					</table>
					<?php } ?>
					<div class="text-center" style="margin-top: 5px;"><span class="label label-primary"><a href="<?php echo base_url('user_search/index'); ?>" style="color: white" target="_blank"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line("Details"); ?></a></span></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->			
		</div>
		
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">			
			<div class="box" style="border-top: 3px solid #8ABA45;">
				<div class="box-header with-border">
					<h3 class="box-title" style="color: #198EC8"><i class="fa fa-flag" style="color: #E05A17;"></i> <?php echo $this->lang->line("Page Search By Location"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php 
						if(empty($location_search)) echo "<h3 class='text-center'>".$this->lang->line("no data found")."</h3>";
						else {
					?>

					<table class="table table-hover table-striped">
						<tr>
							<th><?php echo $this->lang->line("Keyword"); ?></th>
							<th><?php echo $this->lang->line("Name"); ?></th>
							<th><?php echo $this->lang->line("Details"); ?></th>
						</tr>
						<?php $i=0; foreach($location_search as $value): ?>
							<tr>
								<td><?php echo $value['search_keyword']; ?></td>
								<td><?php echo $value['name']; ?></td>
								<td><a target="_blank" href="<?php echo base_url('location_search/location_details').'/'.$value['id']; ?>"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Details"); ?></a></td>
							</tr>
						<?php $i++; if($i==10) break; endforeach; ?>
					</table>
					<?php } ?>
					<div class="text-center" style="margin-top: 5px;"><span class="label label-primary"><a href="<?php echo base_url('location_search/index'); ?>" style="color: white" target="_blank"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line("Details"); ?></a></span></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->			
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">			
			<div class="box" style="border-top: 3px solid #8ABA45;">
				<div class="box-header with-border">
					<h3 class="box-title" style="color: #198EC8"><i class="fa fa-users" style="color: #E05A17;"></i> <?php echo $this->lang->line("Group Search"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php 
						if(empty($group_search)) echo "<h3 class='text-center'>".$this->lang->line("no data found")."</h3>";
						else {
					?>

					<table class="table table-hover table-striped">
						<tr>
							<th><?php echo $this->lang->line("Keyword"); ?></th>
							<th><?php echo $this->lang->line("Name"); ?></th>
							<th><?php echo $this->lang->line("Details"); ?></th>
						</tr>
						<?php $i=0; foreach($group_search as $value): ?>
							<tr>
								<td><?php echo $value['search_keyword'];?></td>
								<td><?php echo $value['name'];?></td>
								<td><a target="_blank" href="<?php echo base_url('group_search/group_details').'/'.$value['id']; ?>"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Details"); ?></a></td>
							</tr>
						<?php $i++; if($i==10) break; endforeach; ?>
					</table>
					<?php } ?>
					<div class="text-center" style="margin-top: 5px;"><span class="label label-primary"><a href="<?php echo base_url('group_search/index'); ?>" style="color: white" target="_blank"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line("Details"); ?></a></span></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->			
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">			
			<div class="box" style="border-top: 3px solid #EA4335;">
				<div class="box-header with-border">
					<h3 class="box-title" style="color: #198EC8"><i class="fa fa-calendar" style="color: #E05A17;"></i> <?php echo $this->lang->line("Event Search"); ?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">					
					<?php 
						if(empty($event_search)) echo "<h3 class='text-center'>".$this->lang->line("no data found")."</h3>";
						else {
					?>

					<table class="table table-hover table-striped">
						<tr>
							<th><?php echo $this->lang->line("Keyword"); ?></th>
							<th><?php echo $this->lang->line("Name"); ?></th>
							<th><?php echo $this->lang->line("Details"); ?></th>
						</tr>
						<?php $i=0; foreach($event_search as $value): ?>
							<tr>
								<td><?php echo $value['search_keyword']; ?></td>
								<td><?php echo $value['name']; ?></td>
								<td><a target="_blank" href="<?php echo base_url('event_search/event_details').'/'.$value['id']; ?>"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line("Details"); ?></a></td>
							</tr>
						<?php $i++; if($i==10) break; endforeach; ?>
					</table>
					<?php } ?>
					<div class="text-center" style="margin-top: 5px;"><span class="label label-primary"><a href="<?php echo base_url('event_search/index'); ?>" style="color: white" target="_blank"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line("Details"); ?></a></span></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->			
		</div>
	</div>



</div>

<script type="text/javascript">
	$j("document").ready(function(){
		
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 10, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false
        };


		  //-------------
		  //- PIE CHART -
		  //-------------
		  // Get context with jQuery - using jQuery's .get() method.
		  var pieChartCanvas = $("#total_email_found_pieChart").get(0).getContext("2d");
		  var pieChart = new Chart(pieChartCanvas);
		  var total_email_found = $("#total_email_found").val();
		  if(total_email_found != "" && total_email_found != "undefined"){
			  var total_email_found_Data1 = JSON.parse(total_email_found);			  
			  // You can switch between pie and douhnut using the method below.  
			  pieChart.Doughnut(total_email_found_Data1, pieOptions);
			  //-----------------
			  //- END PIE CHART -
			  //-----------------
		  }


		var bar_chart_data = $("#bar_chart_data").val();
		var bar = new Morris.Bar({
          element: 'dashboard_bar_chart',
          resize: true,
          data: JSON.parse(bar_chart_data),
          barColors: ['#74828F', '#96C0CE'],
          xkey: 'search_type',
          ykeys: ['total_search', 'total_result_found'],
          labels: ['<?php echo $this->lang->line("total search"); ?>', '<?php echo $this->lang->line("total result found"); ?>'],
          hideHover: 'auto'
        });



	});
</script>