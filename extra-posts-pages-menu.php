<?php
/*
Plugin Name: Extra Posts Pages Menu
Plugin URI: http://www.mindstien.com
Description: Adds extra and individual menus for all available post/page statuses like drafts, pending, trash including count of number of posts in each status.
Version: 1.1
Author: Chirag Gadara (Mindstien Technologies)
Author URI: http://www.mindstien.com
*/


add_action( 'admin_menu', 'eppm_add_menu' );

function eppm_add_menu(){

	global $wpdb;
	//add posts menu
	$results = $wpdb->get_results("SELECT post_status,count(ID) as count FROM ".$wpdb->prefix."posts WHERE post_type = 'post' GROUP BY post_status ORDER BY FIELD(post_status,'publish','future','draft','pending','trash','auto-draft')");
	//echo "<pre>".print_r($results,true)."</pre>";die();
	if(is_array($results))
	{
		foreach($results as $r)
		{ //http://wp.mindstien.com/wp-admin/edit.php?page=redirectmetopublish
			//echo "<pre>".print_r($r,true)."</pre>";die();
			if($r->post_status !='inherit')
				add_submenu_page('edit.php', ucwords($r->post_status), ucwords($r->post_status).' ('.$r->count.')', 'edit_posts', 'redirectmeto'.$r->post_status, 'eppm_menu_page'); 
		}
	}
    
	// add pages menu
	
	$results = $wpdb->get_results("SELECT post_status,count(ID) as count FROM ".$wpdb->prefix."posts WHERE post_type = 'page' GROUP BY post_status  ORDER BY FIELD(post_status,'publish','future','draft','pending','trash','auto-draft')");
	if(is_array($results))
	{
		foreach($results as $r)
		{
			if($r->post_status !='inherit')
				add_submenu_page('edit.php?post_type=page', ucwords($r->post_status), ucwords($r->post_status).' ('.$r->count.')', 'edit_pages', 'redirectmetop'.$r->post_status, 'eppm_menu_page'); 
		}
	}
	
	$post_types = $wpdb->get_col("SELECT post_type FROM ".$wpdb->prefix."posts WHERE post_type != 'page' AND post_type != 'post'  GROUP BY post_type");
	
	if(is_array($post_types))
	{
		foreach ($post_types as $p)
		{
			$results = $wpdb->get_results("SELECT post_status,count(ID) as count FROM ".$wpdb->prefix."posts WHERE post_type = '".$p."' GROUP BY post_status  ORDER BY FIELD(post_status,'publish','future','draft','pending','trash','auto-draft')");
			if(is_array($results))
			{
				foreach($results as $r)
				{
					if($r->post_status !='inherit')
						add_submenu_page('edit.php?post_type='.$p, ucwords($r->post_status), ucwords($r->post_status).' ('.$r->count.')', 'edit_pages', 'redirectmetop'.$r->post_status, 'eppm_menu_page'); 
				}
			}
		}
    }
}

function eppm_menu_page(){
    echo 'Nothing here';
}

add_action('init','eppm_redirect_to_posts',1);
function eppm_redirect_to_posts()
{
	if(isset($_GET['page']))
	{
		switch($_GET['page'])
		{
			case "redirectmetodraft":
				wp_redirect(admin_url('edit.php?post_status=draft&post_type=post'));
				die();	
				break;
			case "redirectmetopublish":
				wp_redirect(admin_url('edit.php?post_status=publish&post_type=post'));
				die();	
				break;
			case "redirectmetoauto-draft":
				wp_redirect(admin_url('edit.php?post_status=auto-draft&post_type=post'));
				die();	
				break;
			case "redirectmetopending":
				wp_redirect(admin_url('edit.php?post_status=pending&post_type=post'));
				die();	
				break;
			case "redirectmetoprivate":
				wp_redirect(admin_url('edit.php?post_status=private&post_type=post'));
				die();	
				break;
			case "redirectmetotrash":
				wp_redirect(admin_url('edit.php?post_status=trash&post_type=post'));
				die();	
				break;
			case "redirectmetofuture":
				wp_redirect(admin_url('edit.php?post_status=future&post_type=post'));
				die();	
				break;
			case "redirectmetopdraft":
				wp_redirect(admin_url('edit.php?post_status=draft&post_type=page'));
				die();	
				break;
			case "redirectmetoppublish":
				wp_redirect(admin_url('edit.php?post_status=publish&post_type=page'));
				die();	
				break;
			case "redirectmetopauto-draft":
				wp_redirect(admin_url('edit.php?post_status=auto-draft&post_type=page'));
				die();	
				break;
			case "redirectmetoppending":
				wp_redirect(admin_url('edit.php?post_status=pending&post_type=page'));
				die();	
				break;
			case "redirectmetopprivate":
				wp_redirect(admin_url('edit.php?post_status=private&post_type=page'));
				die();	
				break;
			case "redirectmetoptrash":
				wp_redirect(admin_url('edit.php?post_status=trash&post_type=page'));
				die();	
				break;
			case "redirectmetopfuture":
				wp_redirect(admin_url('edit.php?post_status=future&post_type=page'));
				die();	
				break;
				
		
		}
		
	}
}
?>