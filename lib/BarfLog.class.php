<?php 
/**
 * Worst Way Possible - A Practical Programmer's Guide: Simple Steps to better code
 * "Introduction To PDO" 
 * Released Apr 12 2011
 * http://prgmrbill.com
 * @author PrgmrBill <hi@prgmrbill.com>
 * @description - Introduction To PDO
 *
 */
class BarfLog
{
	// The PDO connection that is used
	private $connection;
	
    // @param resource $connection - db connection
	public function __construct($connection)
	{
		$this->connection = $connection;
	}
	
	// @param int $logID - barf_log_id
	public function RemoveBarfLogByID($logID)
	{
		try
		{
			// ":logID" is a named placeholder. It represents
			// a variable we are going to bind.
			$q = "DELETE 
				  FROM barf_log
				  WHERE barf_log.barf_log_id = :logID";

			$stmt = $this->connection->prepare($q);
            
            // It's not a bad idea to use intval to ensure that
            // logID is a number.
			$stmt->execute(array(':logID' => intval($logID)));
			return $stmt->rowCount() > 0;
		}
		catch(PDOException $e)
		{
			// Note: this is intentionally made simple. In a real scenario
			// you would probably instead log the error and handle the error
			// more responsibly and appropriately.
			echo sprintf("Error message: %s - Code: %d", $e->getMessage(), $e->getCode());
			
			return false;
		}
	}
	
	// @param string $location - where the cat barfed, like
	// on my floor, windowsill, or in my door way where I will
	// probably step in it if my dog doesn't eat it first
	public function AddLog($location)
	{
		try
		{
			$q = "INSERT INTO barf_log(barf_log_location, barf_log_date)
				  VALUES(:barfLocation, NOW())";
			$stmt = $this->connection->prepare($q);

			// Binding :barfLocation to the argument passed to us,
			// making it safe for database
			$stmt->execute(array(':barfLocation' => $location));
			return intval($this->connection->lastInsertId());
		}
		catch(PDOException $e)
		{
			echo sprintf("Error message: %s - Code: %d", 
						 $e->getMessage(), 
						 $e->getCode());
			return false;
		}
	}
	
    // @param int $logID - primary key of this log
	public function FetchLogByID($logID)
	{
		try
		{
			$q = "SELECT bl.barf_log_id AS barfLogID,
						 bl.barf_log_location AS barfLocation,
						 bl.barf_log_date AS barfDate
			      FROM barf_log bl
				  WHERE bl.barf_log_id = :logID";
			$stmt = $this->connection->prepare($q);
			$stmt->execute(array(':logID' => intval($logID)));
            
            // Note: we're using Fetch, not FetchAll because we are 
            // expecting exactly one result.
			$log = $stmt->Fetch(PDO::FETCH_OBJ);
			return $log;
		}
		catch(PDOException $e)
		{
			echo sprintf("Error message: %s - Code: %d", 
						 $e->getMessage(), 
						 $e->getCode());

			return false;
		}
	}
    
	// Get entries from Barf Log
	public function FetchLogs()
	{
		try
		{
			$q = "SELECT bl.barf_log_id AS barfLogID,
						 bl.barf_log_location AS barfLocation,
						 bl.barf_log_date AS barfDate
			      FROM barf_log bl
				  ORDER BY bl.barf_log_date DESC";
			$stmt = $this->connection->prepare($q);
			$stmt->execute();
			$logs = $stmt->FetchAll(PDO::FETCH_OBJ);
			return $logs;
		}
		catch(PDOException $e)
		{
			echo sprintf("Error message: %s - Code: %d", 
						 $e->getMessage(), 
						 $e->getCode());

			return false;
		}
	}
}

