<?php
	error_reporting(0);
	global $wpdb;
	$type = $_FILES['myFile']['type'];
	$formats = array("image/jpeg","image/png");
	$catId = $_POST['catValue'];
	
	if(!in_array($type,$formats))
	{
		die('<h3>Invalid Format. Please choose a different file.<h3>');
	}
	else
	{
		$target_path = '../wp-content/plugins/maga-category/img/';
		$extension = '.'.str_replace('image/','',$_FILES['myFile']['type']);
		$final = $target_path.$catId.$extension;

		$check = $wpdb->get_var(Controller::checkExisting($catId));
		if($check != 0)
		{
			$file = $wpdb->get_var(Controller::getFileName($catId));
			unlink('../wp-content/plugins/maga-category/img/'.$file);
		}
	
		if(move_uploaded_file($_FILES['myFile']['tmp_name'],$final))
		{
			if($check == 0)
			{
				$wpdb->insert("wp_image_category",array("Category_ID" => $catId, "Image_Path" => ($catId.$extension)));
				die('<h3>Image Inserted Sucessfully!</h3>');
			}
			else
			{
				$wpdb->update("wp_image_category",array("Image_Path" => ($catId.$extension)),array("CategoryID" => $catId));
				die('<h3>Image Updated Successfully</h3>');
			}
		}
		else
		{
			die('<h3>Error uploading File. Check if <i>img</i> folder in this plugin is writeable.</h3>');
		}

	}
?>
