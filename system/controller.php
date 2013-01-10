<?php

	include 'queries.php';

	class Controller
	{
		public static function createTable($prefix)
		{
			return QueryList::createTable($prefix);
		}

		public static function dropTable($prefix)
		{
			return QueryList::dropTable($prefix);
		}

		public static function checkExisting($id,$prefix)
		{
			return QueryList::checkExisting($id,$prefix);;
		}

		public static function getFileName($id,$prefix)
		{
			return QueryList::getFilename($id,$prefix);
		}

		public static function getTableInformation($prefix)
		{
			return QueryList::getTableInformation($prefix);
		}

		public static function deleteRow($id,$prefix)
		{
			return QueryList::deleteRow($id,$prefix);
		}

		public static function getCategoryIds($prefix)
		{	
			return QueryList::getCategoryIds($prefix);	
		}
	}
?>
