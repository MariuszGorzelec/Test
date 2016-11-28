<?php
	require "aps/2/runtime.php";
	require_once realpath( dirname(__FILE__)) ."/logger.php";
	/**
	* Class cloud presents application and its global parameters
	* @type("http://intertele.pl/Test/cloud/1.0")
	* @implements("http://aps-standard.org/types/core/application/1.0")
	*/
	class cloud extends APS\ResourceBase 
	{
		## 
		##	Link to collection of contexts. Pay attention to [] brackets at the end of the @link line.
		##
		/**
		* @link("http://intertele.pl/Test/management/1.0[]")
		*/
		public $management;
		///
		public function configure($new)
		{
			$this->logger('Clouds - On configure - '.$this->aps->id);
			
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
		}
		///
		public function provision() 
		{
			$this->logger('Clouds - On provision - '.$this->aps->id);			
				
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
   		}
   		///
		public function retrieve()
		{				 
			$this->logger('Clouds - On retrieve - '.$this->aps->id);
			
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
		}
		///		
		public function unprovision() 
		{
			$this->logger('Clouds - On unprovision - '.$this->aps->id);
			
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
		}	
		###
		###	Define a Logger function that will log a new Event Notification as a message
		###
		function logger($message)
		{
			$requester=$_SERVER['REMOTE_ADDR'];
			$log = new Logging();
			$log->logfile('./'.$this->aps->id.'.log');
			$log->logwrite($requester.":".$message);
			$log->logclose();
		}
	}
