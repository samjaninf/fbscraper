<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header"></li> 
      <li><a href='<?php echo site_url()."dashboard/index"; ?>'><i class="fa fa-dashboard"></i> <span><?php echo $this->lang->line("dashboard"); ?></span></a></li>
       <?php if($this->session->userdata('user_type') == 'Member'): ?>        
          <li><a href='<?php echo site_url()."admin_config_facebook/facebook_config"; ?>'><i class="fa fa-facebook"></i> <span><?php echo $this->lang->line("facebook settings"); ?></span></a></li>     
      <?php endif; ?>    

     <?php if ($this->session->userdata('user_type') == 'Admin') : ?>

       <li class="treeview">
        <a href="#">
          <i class="fa fa-cogs"></i> <span><?php echo $this->lang->line("Settings"); ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
    
        <ul class="treeview-menu">
          <li><a href='<?php echo site_url()."admin_config/configuration";?>' > <i class="fa fa-cog"></i> <?php echo $this->lang->line("General Settings"); ?></a></li>  
          <li><a href='<?php echo site_url()."admin_config_email/email_smtp_settings"; ?>'><i class="fa fa-envelope"></i> <?php echo $this->lang->line("Email Settings"); ?></a></li>    
          <li><a href='<?php echo site_url()."admin_config_facebook/facebook_config"; ?>'><i class="fa fa-facebook"></i> <?php echo $this->lang->line("facebook settings"); ?></a></li>            
          <li><a href='<?php echo site_url()."admin_config_lead/lead_config"; ?>'><i class="fa fa-connectdevelop"></i> <?php echo $this->lang->line("lead settings"); ?></a></li>     
          <li><a href='<?php echo site_url()."admin_config_ad/ad_config"; ?>'><i class="fa fa-bullhorn"></i> <?php echo $this->lang->line("advertisement settings"); ?></a></li>     
          <li><a href='<?php echo site_url()."admin_config_connectivity/connectivity_config"; ?>'><i class="fa fa-google"></i> <?php echo $this->lang->line("google API settings"); ?></a></li>
        </ul>
      </li> <!-- end settings -->

      <li><a href='<?php echo site_url()."admin/user_management"; ?>'><i class="fa fa-user"></i> <span><?php echo $this->lang->line("User Management"); ?></span></a></li>     
      <li><a href='<?php echo site_url()."admin/notify_members";?>'><i class="fa fa-bell-o"></i> <span><?php echo $this->lang->line("Send Notification"); ?></span></a></li>


          
       <li class="treeview">
        <a href="#">
          <i class="fa fa-paypal"></i> <span><?php echo $this->lang->line("Payment"); ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>    
        <ul class="treeview-menu">
          <li> <a href="<?php echo site_url()."payment/payment_dashboard_admin"; ?>"> <i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Dashboard"); ?></a></li>   
          <li><a href="<?php echo site_url()."payment/package_settings"; ?>"><i class="fa fa-cube"></i> <?php echo $this->lang->line("Package Settings"); ?></a></li>    
          <li><a href="<?php echo site_url()."payment/payment_setting_admin"; ?>"><i class="fa fa-cog"></i> <?php echo $this->lang->line("Payment Settings"); ?></a></li>    
          <li><a href="<?php echo site_url()."payment/admin_payment_history"; ?>"><i class="fa fa-history"></i> <?php echo $this->lang->line("Payment History"); ?></a></li>     
        </ul>
      </li> 

      <li> <a href="<?php echo site_url()."admin/delete_junk_file"; ?>"> <i class="fa fa-trash-o"></i> <span><?php echo $this->lang->line("delete junk files/data"); ?></span></a></li>
      <li> <a href="<?php echo site_url()."admin_leads/lead_list"; ?>"> <i class="fa fa-list"></i> <span><?php echo $this->lang->line("lead list"); ?></span></a></li>
      <li><a href='<?php echo site_url()."page_search_guest/index"; ?>'><i class="fa fa-list-alt"></i> <span><?php echo $this->lang->line("page list searched by guests"); ?></span></a></li>
      <?php endif; ?>

      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(1,$this->module_access)): ?>
        <li><a href='<?php echo site_url()."page_search/index"; ?>'><i class="fa fa-file-o"></i> <span><?php echo $this->lang->line("page search"); ?></span></a></li>
      <?php endif; ?>
      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(2,$this->module_access)): ?>
        <li><a href='<?php echo site_url()."location_search/index"; ?>'><i class="fa fa-map-marker"></i> <span><?php echo $this->lang->line("page search by location"); ?></span></a></li>
      <?php endif; ?>
      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(5,$this->module_access)): ?>
        <li><a href='<?php echo site_url()."event_search/index"; ?>'><i class="fa fa-calendar-o"></i> <span><?php echo $this->lang->line("event search"); ?></span></a></li>
      <?php endif; ?>
      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(3,$this->module_access)): ?>
        <li><a href='<?php echo site_url()."group_search/index"; ?>'><i class="fa fa-group"></i> <span><?php echo $this->lang->line("group search"); ?></span></a></li>
      <?php endif; ?>
      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(4,$this->module_access)): ?>
        <li><a href='<?php echo site_url()."user_search/index"; ?>'><i class="fa fa-user"></i> <span><?php echo $this->lang->line("user search"); ?></span></a></li>
      <?php endif; ?>


      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(6,$this->module_access)): ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-area-chart"></i> <span><?php echo $this->lang->line("facebook page insight"); ?></span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>    
          <ul class="treeview-menu">
            <li><a href='<?php echo site_url()."admin_facebook_page_insight/page_insight_login"; ?>'><i class="fa fa-plus"></i> <span><?php echo $this->lang->line("add page"); ?></span></a></li>
            <li><a href='<?php echo site_url()."admin_facebook_page_insight/page_list_grid"; ?>'><i class="fa fa-th-list"></i> <span><?php echo $this->lang->line("page list"); ?></span></a></li>
          </ul>
        </li> 
      <?php endif; ?>

     


      <?php if($this->session->userdata('user_type') == 'Member'): ?>
      <li> 
        <a href='<?php echo site_url()."payment/usage_history"; ?>'> <i class="fa fa-list-ol"></i> <span><?php echo $this->lang->line("usage log"); ?></span></a>
      </li> 
      <li><a href="<?php echo site_url()."payment/member_payment_history"; ?>"><i class="fa fa-paypal"></i> <span><?php echo $this->lang->line("Payment history"); ?></span> </a></li>
      <?php endif; ?>


      <?php if ($this->session->userdata('user_type') == 'Admin') : ?>     
        <li><a href='<?php echo site_url()."native_api/index"; ?>'><i class="fa fa-clock-o"></i> <span><?php echo $this->lang->line("cron job"); ?></span></a></li>
        <li><a href='<?php echo site_url()."widget/index"; ?>'><i class="fa fa-plug"></i> <span><?php echo $this->lang->line("widget"); ?></span></a></li>
        <li style="margin-bottom:200px"><a href="<?php echo site_url('documentation'); ?>"><i class="fa fa-book"></i> <span><?php echo $this->lang->line("read documentation"); ?></span></a></li>    
      <?php endif; ?>     

       
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>