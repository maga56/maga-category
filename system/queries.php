<?php

	class QueryList
	{
		 public static function createTable($prefix)
		 {
			 $sql = "CREATE TABLE IF NOT EXISTS `".$prefix."image_category`(
 				`ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 				`Category_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
 				`Image_Path` varchar(500) NOT NULL DEFAULT '',
  				PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT= 1 DEFAULT CHARSET= utf8;";
			  return $sql;
		 }

		public static function dropTable($prefix)
		{
			return "DROP TABLE IF EXISTS ".$prefix."image_category;";
		}


		public static function checkExisting($id,$prefix)
		{
			return "SELECT COUNT(*) FROM ".$prefix."image_category WHERE Category_ID = ".$id;
		}

		public static function getFilename($id,$prefix)
		{
			return "SELECT Image_Path FROM ".$prefix."image_category WHERE Category_ID = ".$id;
		}

		public static function getCategoryIds($prefix)
		{
			return "SELECT Category_ID from ".$prefix."image_category;";
		}

		public static function getTableInformation($prefix)
		{
			return "SELECT name, Image_Path, Category_ID FROM ".$prefix."terms, ".$prefix."image_category WHERE ".$prefix."terms.term_id = ".$prefix."image_category.Category_ID ORDER BY Category_ID;";
		}

		public static function deleteRow($id,$prefix)
		{
			return "DELETE FROM ".$prefix."image_category WHERE Category_ID = ".$id.";";
		}

	}
?>
