<?php
	# It is the context of the subscription, in which a customer can manage its cert.
	# It must correspond to a tenant created for the subscriber in the remote application system.
	require "aps/2/runtime.php";
	
	require_once realpath(dirname(__FILE__)) ."/logger.php";
	
	date_default_timezone_set('UTC');
	/**
	* Class context
	* @type("http://intertele.pl/Test/management/1.0")
	* @implements("http://aps-standard.org/types/core/resource/1.0")
	*/
	class management extends \APS\ResourceBase
	{
		## Strong relation (link) to the application instance
		/**
		* @link("http://intertele.pl/Test/cloud/1.0")
		* @required
		*/
		public $cloud;
		## Weak relation (link) to the Event Processing resource
		/**
		 * @link("http://intertele.pl/Test/event/1.0")
		 */
		public $event;		
		## Below we define a strong relation with the Subscription.
		## This way, we allow the service to access the operation resources
		## with the limits and usage defined in the subscription.
		/**
		 * @link("http://aps-standard.org/types/core/subscription/1.0")
		 * @required
		 */
		public $subscription;
		#
		## We define a link to the account type in order the service can get access to account attributes,
		## e.g., the account (subscriber) name, and all its other data.
		#
		/**
		* @link("http://aps-standard.org/types/core/account/1.0")
		* @required
		*/
		public $account;
		/**
		* @link("http://aps-standard.org/types/core/user/1.0")
		* @required
		*/
		public $user;
		/**
		* @link("http://aps-standard.org/types/core/service-user/1.0")
		*/
		public $serviceuser;
		/**
		* @link("http://aps-standard.org/types/core/admin-user/1.0")
		*/
		public $adminuser;
		/**
		* @link("http://parallels.com/aps/types/pa/serviceTemplate/1.1")
		*/
		public $servicetemplate;
		/**
		 * @type("integer")
		 * @title("order_id")
		 * @description("Order ID")
		 */
		public $order_id;
		/**
		 * @type("string")
		 * @title("order_status")
		 * @description("Order Status")
		 */
		public $order_status;
		
		public function configure($new)
		{
			$this->logger('Management - On configure - '.$this->aps->id);
			
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
		}

		public function provision() 
		{
			$this->logger('Management - On provision - '.$this->aps->id);
			
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
   		}

		public function retrieve()
		{				 
			$this->logger('Management - On retrieve - '.$this->aps->id);
			
			try
			{
				///
			}
			catch(Exception $e)
			{
				$this->logger(print_r($e, true));
			}
		}
		
		public function unprovision() 
		{
			$this->logger('Management - On unprovision - '.$this->aps->id);
			
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
		/**
		 * @verb(GET)
		 * @path(/Ustawianie)
		 */
		public function Ustawianie()
		{
			$this->logger('On Ustawianie');
			$this->logger($this);
			
			$apsc = \APS\Request::getController();
			$this->order_id = 10001;
			$this->order_status = 'Waiting';

			$this->logger($this);
			
			$apsc->updateResource($this);
		}
	}
