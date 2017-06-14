<?php

/**
* @category controller
* class Admin
*/

class update extends CI_Controller
{
      
    public function __construct()
    {
        parent::__construct();   
        $this->load->database();
        $this->load->model('basic');
        set_time_limit(0);
    }


    public function index()
    {
        $this->v2_2_to_2_3();
    }


    public function v2_2_to_2_3()
    {
      $lines="ALTER TABLE `transaction_history` ADD `stripe_card_source` TEXT NOT NULL";
        // Loop through each line

        $lines=explode(";", $lines);
        $count=0;
        foreach ($lines as $line) 
        {
            $count++;      
            $this->db->query($line);
        }
        echo "Item has been updated to v2.3 successfully.".$count." queries executed.";
    }

 
    public function v1_to_v1_1()
    {

        $lines="DROP TABLE IF EXISTS `widget`;
                CREATE TABLE IF NOT EXISTS `widget` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `user_id` int(11) NOT NULL DEFAULT '0',
                  `domain_name` varchar(100) DEFAULT NULL,
                  `widget_type` enum('page_search') NOT NULL DEFAULT 'page_search',
                  `border` varchar(50) NOT NULL DEFAULT '0px',
                  `width` varchar(50) NOT NULL DEFAULT '100%',
                  `height` varchar(50) NOT NULL DEFAULT '100%',
                  `background` varchar(50) NOT NULL DEFAULT '#ffffff',
                  `color` varchar(50) NOT NULL DEFAULT '#000000',
                  `icon_color` varchar(50) NOT NULL DEFAULT '31B809E',
                  `input_border_color` varchar(50) NOT NULL DEFAULT '#cccccc',
                  `button_style` enum('danger','info','primary','success','warning') NOT NULL DEFAULT 'primary',
                  `deleted` enum('0','1') NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";


       
        // Loop through each line

        $lines=explode(";", $lines);
        $count=0;
        foreach ($lines as $line) 
        {
            $count++;      
            $this->db->query($line);
        }
        echo "Item has been updated to v1.1 successfully.".$count." queries executed.";
        //$this->delete_update();        
    }


    public function v1_1_to_v1_2()
    {

        $lines="DROP TABLE IF EXISTS `ad_config`;
        CREATE TABLE `ad_config` (
        `id` int(11) NOT NULL,
        `section1_html` longtext,
        `section1_html_mobile` longtext,
        `section2_html` longtext,
        `section3_html` longtext,
        `section4_html` longtext,
        `status` enum('0','1') NOT NULL DEFAULT '1'
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
      ALTER TABLE `ad_config`
        ADD PRIMARY KEY (`id`);
      ALTER TABLE `ad_config`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      ALTER TABLE `page_search` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
      ALTER TABLE `page_search_guest` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
      ALTER TABLE `location_search` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
      ALTER TABLE `user_search` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
      DROP TABLE IF EXISTS `connectivity_config`;
      CREATE TABLE `connectivity_config` (
        `id` int(11) NOT NULL,
        `google_api_key` text
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
      ALTER TABLE `connectivity_config`
        ADD PRIMARY KEY (`id`);
      ALTER TABLE `connectivity_config`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
      INSERT INTO `connectivity_config` (`id`, `google_api_key`) VALUES
      (1, 'AIzaSyBG0sIVBWReW1Q0WGkWO28uGaKWhQp7Q4c')";
       
        // Loop through each line

        $lines=explode(";", $lines);
        $count=0;
        foreach ($lines as $line) 
        {
            $count++;      
            $this->db->query($line);
        }
        echo "Item has been updated to v1.2 successfully.".$count." queries executed.";
        //$this->delete_update();        
    }


     public function v1_2to_v2_0()
    {

        $lines="ALTER TABLE `page_search` ADD `video` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `deleted`;
        ALTER TABLE `location_search` ADD `video` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `deleted`;
        INSERT INTO `modules` (`id`, `module_name`, `deleted`) VALUES (6, 'facebook page insight', '0');
        CREATE TABLE IF NOT EXISTS `facebook_page_insight_page_list` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `page_id` varchar(250) DEFAULT NULL,
          `page_name` text,
          `page_email` varchar(250) DEFAULT NULL,
          `page_cover` longtext,
          `page_profile` longtext,
          `page_access_token` longtext,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ALTER TABLE `connectivity_config` ADD `recaptcha_site_key` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `google_api_key`, ADD `recaptcha_secret_key` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `recaptcha_site_key`;ALTER TABLE `payment_config` ADD `stripe_secret_key` VARCHAR(150) NOT NULL AFTER `paypal_email`, ADD `stripe_publishable_key` VARCHAR(150) NOT NULL AFTER `stripe_secret_key`";

       
        // Loop through each line

        $lines=explode(";", $lines);
        $count=0;
        foreach ($lines as $line) 
        {
            $count++;      
            $this->db->query($line);
        }
        echo "Item has been updated to v2.0 successfully.".$count." queries executed.";
        //$this->delete_update();        
    }


    function delete_update()
    {
        unlink(APPPATH."controllers/update.php");
    }
 


}
