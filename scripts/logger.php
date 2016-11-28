<?php
	/**
	* Logging class:
	* - contains "logfile", "logwrite" and "logclose" public methods
	* - "logfile" sets path and name of log file
	* - "logwrite" writes message to the log file (and implicitly opens log file)
	* - "logclose" closes log file
	* - first call of "logwrite" method will open log file implicitly
	* - message is written with the following format: [d/M/Y:H:i:s] (script name) message
	*/
	class Logging 
	{
		## declare log file and file pointer as private properties
		private $log_file = './eventlog.txt';
		private $fp;
		## set log file (path and name)
		public function logfile($path) 
		{
			if (strlen($path) > 0) 
			{
				$this->log_file = $path;
			}
			}
		## write message to the log file
		public function logwrite($message) 
		{
			#### if file pointer doesn't exist, then open log file
			if (!is_resource($this->fp)) 
			{
				$this->logopen();
			}
			#### define script name
			$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
			#### define current time and suppress E_WARNING if using the system TZ settings
			#### (don't forget to set the INI setting date.timezone)
			$time = @date('[d/M/Y:H:i:s e]');
			#### write current time, script name and message to the log file
			fwrite($this->fp, "$time ($script_name) $message\n");
		}
		## close log file (it's always a good idea to close a file when you're done with it)
		public function logclose() 
		{
			fclose($this->fp);
		}
		## open log file (private method)
		private function logopen() 
		{
			#### Open log file for writing only and place file pointer at the end of the file.
			#### If the file does not exist, try to create it.
			$this->fp = fopen($this->log_file, 'a+') or exit("Can't open $logfile!");
		}
		///
		public function flushlog() 
		{
			#### If the log has not been created, return empty contents
			if (! file_exists($this->log_file))
                return "";
			$fp = fopen($this->log_file, 'r+');
			if (!$fp) return "";
			$content = file_get_contents($this->log_file);
			ftruncate($fp, 0);
			return $content;
		}
	}
?>