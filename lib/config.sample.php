<?php 
/**
 * Worst Way Possible - A Practical Programmer's Guide: Simple Steps to better code
 * "Introduction To PDO" 
 * Released Apr 12 2011
 * http://worstwaypossible.prgmrbill.com
 * @author PrgmrBill <hi@prgmrbill.com>
 * @description - Introduction To PDO Config
 *
 */
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

define('DB_USER',     '');
define('DB_PASSWORD', '');
define('DB_NAME',     '');
define('DB_HOST',     '127.0.0.1');

/**
 * DB connection.
 *
 */
function GetConnection()
{
	try
	{
		$connection = new PDO(sprintf('mysql:dbname=%s;host=%s;charset=UTF-8', 
									DB_NAME,
									DB_HOST),
									DB_USER, 
									DB_PASSWORD);
									
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $connection;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		/*throw new DatabaseException($e->getMessage(), 
									$e->getCode(), 
									__FILE_, 
									__LINE__);*/
	}
}
