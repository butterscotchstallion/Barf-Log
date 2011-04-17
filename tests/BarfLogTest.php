<?php 
/**
 * Worst Way Possible - A Practical Programmer's Guide: Simple Steps to better code
 * "Introduction To PDO" 
 * Released Apr 12 2011
 * http://prgmrbill.com
 * @author PrgmrBill <hi@prgmrbill.com>
 * @description - Introduction To PDO tests
 *
 */
require '../lib/config.php';
require '../lib/BarfLog.class.php';

class BarfLogTest extends PHPUnit_Framework_TestCase
{
	// @covers BarfLog::RemoveBarfLogByID
	public function RemoveBarfLogByID($logID)
	{
		$connection = GetConnection();
		$bl         = new Barflog($connection);
		
		// Cayenne just barfed on my bathroom floor.
        // Let's record it in the Barf Log.
		$logID = $bl->AddLog('Bathroom floor');
        
        // We should get the logID back after inserting it
        // into the barf_log table.
		$this->assertType('int', $logID);
		
		$deleteSuccess = $bl->RemoveBarfLogByID($logID);
		$this->assertTrue($deleteSuccess);
	}
	
	// @covers BarfLog::AddLog
	public function testAddLog()
	{
		// For the purposes of this example I take
		// the easy way out of doing this. In a real project
		// I would probably have something more robust in place
		// for DB access.
		$connection = GetConnection();
		
		// Pass in connection to BarfLog
		$bl    = new Barflog($connection);
		$logID = $bl->AddLog(sprintf('Testing at %s', date('r')));
		
		// We are expecting the result to be the primary key
		// value of the log it added.
		$this->assertType('int', $logID);
		
		// Remove it
		$deleteSuccess = $bl->RemoveBarfLogByID($logID);
		$this->assertTrue($deleteSuccess);
	}
	
    // @covers BarfLog::FetchLogByID
	public function testFetchLogByID()
	{
		$connection = GetConnection();
		$bl         = new Barflog($connection);
        
        // Create an entry and then fetch it
        $logID      = $bl->AddLog('Under my desk');
        
        // Fetch it
		$newEntry   = $bl->FetchLogByID($logID);		
        
        // Verify the result matches the ID we specified
		$this->assertEquals($newEntry->barfLogID, $logID);
	}
    
	// @covers BarfLog::FetchLogs
	public function testFetchLogs()
	{
		// For the purposes of this example I take
		// the easy way out of doing this. In a real project
		// I would probably have something more robust in place
		// for DB access.
		$connection = GetConnection();
		
		// Pass in connection to BarfLog
		$bl = new Barflog($connection);
		
		// Expecting an array back. If this fails, it will throw an 
		// exception and the test will fail. Note, false is an acceptable
		// return value because an empty result set will be false/empty array
		$logs = $bl->FetchLogs();
		$this->assertType('array', $logs);
	}
}