<?php
/*
Plugin Name: iDienstler's Tracking Code
Plugin URI: http://wordpress.org/extend/plugins/idienstlers-tracking-code
Description: Plugin for adding tracking code to the header and/or footer which based on Khaled Hossain Saikat's great plugin Tracking Code 1.0.0. 
Version: 1.0.0
Author: Jürgen Scholz
Author URI: http://informatikdienstleistungen.de
Min WP Version: 3.4.1
Max WP Version: 3.6.1
*/

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Please don\'t access this file directly.');
}

if (!class_exists( 'idienstlersTrackingCode' )){
    class idienstlersTrackingCode {
        
        function __construct(){     
            add_action( 'admin_menu', array( $this, 'menuItem' ) );    
            add_action( 'wp_head', array( $this, 'wpHead' ) ); 
            add_action( 'wp_footer', array( $this, 'wpFooter' ) );                         
        }
        
        function menuItem(){
            $page = add_submenu_page( 'options-general.php', 'iDienstler\'s Tracking Code', 'iDienstler\'s Tracking Code', 'manage_options', 'idienstlers-tracking-code', array( $this, 'init' ));                        
        }
        
        function init(){
            
            if( isset($_REQUEST['save']) ){
                update_option( 'idienstlers_tracking_code', $_REQUEST );
                $message = "Saved Successfully.";
            }
                        
            $data = get_option('idienstlers_tracking_code');
            $this->form( $data, @$message );
        }
        
        function wpHead(){
            $data = get_option('idienstlers_tracking_code');
            if( isset( $data['tracking_head']['enable'] ) )
                echo stripcslashes($data['tracking_head']['code']);            
        }
        
        function wpFooter(){
            $data = get_option('idienstlers_tracking_code');
            if( isset( $data['tracking_footer']['enable'] ) )
                echo stripcslashes($data['tracking_footer']['code']);               
        }
        
        function form( $data, $message=null ){
            ?>
            <div class="wrap">
                <div id="icon-options-general" class="icon32 icon32-posts-page"><br /></div>  
                <form method="post" action="">
                    <h2>iDienstler's Tracking Code</h2>   
                    <?php if( $message ) : ?>
                        <div class="updated"><p><strong><?php echo $message; ?></strong></p></div>
                    <?php endif; ?>
                    <p>
                        <h3>Add Tracking Code to HTML Head</h3>
                        <textarea rows="20" cols="150" name="tracking_head[code]"><?php echo stripcslashes( @$data['tracking_head']['code'] ); ?></textarea>
                        <br />
                        <input type="checkbox" name="tracking_head[enable]" <?php checked( @$data['tracking_head']['enable'], 'on' ); ?>  /> Enable Head Tracking Code
                    </p>
                    
                    <p><br /></p>
                    
                    <p>
                        <h3>Add Tracking Code to footer</h3>
                        <textarea rows="20" cols="150" name="tracking_footer[code]"><?php echo stripcslashes( @$data['tracking_footer']['code'] ); ?></textarea>                        <br />
                        <input type="checkbox" name="tracking_footer[enable]"  <?php checked( @$data['tracking_footer']['enable'], 'on' ); ?> /> Enable Footer Tracking Code
                    </p>
                    
                    <p><input class="button-primary" type="submit" name="save" value="Save Changes"/></p>
                    
                </form>             
            </div>            
            <?php
        }
                    
    }
}

global $idienstlersTrackingCode;
$idienstlersTrackingCode = new idienstlersTrackingCode;    
?>