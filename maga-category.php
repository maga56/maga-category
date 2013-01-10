<?php
/*
Plugin Name: Maga Category Images
Plugin URI: http://divisionentrecero.mx
Description: Allows us to associate an image to a given category.
Version: 1.0
Author: Ricardo Magallanes Arco (@rMaga56)
Author URI: http://divisionentrecero.mx
License: GPL
*/

include 'system/controller.php';
$maga = new CatImgHandler();
class CatImgHandler
{

	public function __construct()
	{
		add_action('admin_menu', array(&$this,'settings_page'));
		add_action('wp_ajax_handle_response',array(&$this,'handle_response'));
		add_action('wp_ajax_delete_row',array(&$this,'delete_row'));
		add_action('wp_ajax_refresh_table',array(&$this,'refresh_table'));
	}

	public function perform_cleanup()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$current = get_categories("hide_empty=0");
		$ids = array();
		foreach($current as $c)
		{
			array_push($ids,$c->term_id);
		}
		$res = $wpdb->get_results(Controller::getCategoryIds($prefix));
		foreach($res as $r)
		{
			if(!in_array($r->Category_ID,$ids))
			{
				$file = $wpdb->get_var(Controller::getFileName($r->Category_ID,$prefix));
				$path = "../wp-content/plugins/maga-category/img/".$file;
				unlink($path);
				$wpdb->query(Controller::deleteRow($r->Category_ID,$prefix));
			}
		}
	}

	public function getSpecificImage($catId)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$check = $wpdb->get_var(Controller::checkExisting($catId,$prefix));
		if($check != 0)
		{
			$res = $wpdb->get_var(Controller::getFileName($catId,$prefix));
			return ''.get_bloginfo("url").'/wp-content/plugins/maga-category/img/'.$res;
		}
	}

	public function getImageInCategory()
	{
		$cat = get_query_var("cat");
		return $this->getSpecificImage($cat);
	}

	public function handle_response()
	{
		include 'system/fileUploader.php';
	}

	public function settings_page()
	{
		add_options_page('Category Images','Category Images','manage_options','maga_admin',array(&$this,'renderMenu'));
	}

	public function renderMenu()
	{
		include 'views/settings.php';
	}

	public function getSettingsTable()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$res = $wpdb->get_results(Controller::getTableInformation($prefix));

		$tbl = "<h3>Current Images</h3>";
		$tbl.= '<table border = "1" width = "300" class = "myTable">';
		$tbl.= "<tr><th>ID</th><th>Category</th><th>Image</th><th>Delete</th>";
		
		foreach($res as $elem)
		{
			$path = get_bloginfo('url').'/wp-content/plugins/maga-category/img/'.$elem->Image_Path;
			$delPath = get_bloginfo('url').'/wp-content/plugins/maga-category/system/Delete.png';
			$tbl.= '<tr><td>'.$elem->Category_ID.'</td><td>'.$elem->name.'</td><td><center><a class = "colorbox" href = "'.$path.'"><img src = "'.$path.'" class = "myImage"/></a></center></td>
			<td><center><img src = "'.$delPath.'" class = "delIcon" onclick = "deleteRow('.$elem->Category_ID.');"/></center></td></tr>';
		}
		$tbl.="</table>";
		return $tbl;
	}

	public function refresh_table()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		die($this->getSettingsTable($prefix));
	}

	public function delete_row()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$id = $_GET['myId'];
		$file = $wpdb->get_var(Controller::getFileName($id,$prefix));
		$path = "../wp-content/plugins/maga-category/img/".$file;
		unlink($path);
		$wpdb->query(Controller::deleteRow($id,$prefix));
		die($this->getSettingsTable($prefix));
	}

	public function createTable()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sql = Controller::createTable($prefix);
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	public function dropTable()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sql = Controller::dropTable($prefix);
		$wpdb->query($sql);
		$files = glob(ABSPATH.'wp-content/plugins/maga-category/img/*');
		foreach($files as $f)
		{
			unlink($f);
		}
	}
	
	public function getRecCombo($cat,$count)
	{
		$padding = "";
		
		for($i=0; $i<$count; $i++)
		{
			$padding.= '&nbsp;';
		}
		
		if($count > 0)
		{
			$padding.= "-";
		}
		
		foreach($cat as $elem)
		{
			$child = get_categories("hide_empty=0&parent=".$elem->term_id);
			if(!$child)
			{
				echo '<option value ="'.$elem->term_id.'">'.$padding.$elem->name.'</option>';
			}
			else
			{
				echo '<option value ="'.$elem->term_id.'">'.$padding.$elem->name.'</option>';
				echo $this->getRecCombo($child,$count+1);
			}
		}
	}
}

/*Activation/Deactivation Hooks*/
register_activation_hook(__FILE__,array('CatImgHandler','createTable'));
register_deactivation_hook(__FILE__,array('CatImgHandler','dropTable'));
?>
