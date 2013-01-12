=== Plugin Name ===
Contributors: maga56
Tags: category,images
Requires at least: 3.3.1
Tested up to: 3.5
Stable tag: 1.2.1

Maga Category Images v1.2.1 By Ricardo Magallanes.

Associates an image file (jpg or png) to a given category.

== Description ==

Maga Category Images v1.2.1 By Ricardo Magallanes.

Associates an image file (jpg or png) to a given category.

== Installation ==

Setup Instructions:

1. Drag the 'maga-category-images' folder into your Plugins Folder.

2. Find the plugin in the Wordpress Admin and Activate it.

3. After Activation you will find the 'Category Images' section under Settings.

4. Fill out the form, choosing the images you want and the category you wish to associate them with.

5. In your wordpress theme.. you can use two functions that are called invoking the $maga object.

	$maga->getSpecficImage($id) : Returns the url of the image corresponding to that category. This method can be used anywhere as long as you can fetch the ID you want.

	$maga->getImageInCategory : Returns the url of the image corresponding to the category you are currently browsing. This method is better suited for its use in your category.php files.

Example Usage:

`<?php if($maga) : ?>
		<img src = "<?php echo $maga->getImageInCategory(); ?>"/>		
<?php endif; ?>	

<?php if($maga) : ?>
		<img src = "<?php echo $maga->getSpecificImage(3); ?>"/>		
<?php endif; ?>`

== Upgrade Notice ==

==Upgrading to 1.2.1==

If you are upgrading from an older version of this plugin it is very important that you backup your img folder found on this plugin's diretory before you upgrade.

After you update the plugin overwrite the img folder with the old one, otherwise you will lose your images.

I will provide a fix so that this is not necessary on the next update. Sorry for the inconvenience.

==1.2.1==

I reorganized the files so that the automatic plugin installer would work properly.

==1.2==

Addressed several bugfixes regarding the wordpress prefix and some icons that weren't visible.

The category selection box now features a recursive function to traverse through all the categories at all levels.

==1.1==
Added a table where you can view the images that are assigned to the category and added a cleanup functions that will clean
the database of all records that belong to categories that are not in wordpress anymore.

For any bug reports, comments or feedback, please email me at ricardo.magallanes@gmail.com
