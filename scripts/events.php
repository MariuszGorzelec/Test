<?php
	###		
	### logger class will be used for logging event notifications
	###		
 	require "logger.php";
 	require "aps/2/runtime.php";
 	/**
 	* Class events
 	* @type("http://intertele.pl/Test/event/1.0")
 	* @implements("http://aps-standard.org/types/core/resource/1.0")
 	*/
 	class event extends \APS\ResourceBase 
 	{
    	### 
		###	Require a link to the management context
		###
 		/**
 	 	* @link("http://intertele.pl/Test/management/1.0")
 	 	* @required
 	 	*/
 		public $management;
		###
     	### Subscribe to Events during the provisioning process using PHP runtime
		###
     	public function provision() 
     	{
     		$this->logger('Event - On configure - '.$this->aps->id);
     		###
	        ### Subscriptions to VPS related events:
			###
     		$subManagementavailable = new \APS\EventSubscription(\APS\EventSubscription::Available, "onManagementavailable");
     		
			$subManagementremove = new \APS\EventSubscription(\APS\EventSubscription::Removed, "onManagementremove");
     		
			$subManagementchange = new \APS\EventSubscription(\APS\EventSubscription::Changed, "onManagementchange");
	     	
			//$subManagementofferLink = new \APS\EventSubscription(\APS\EventSubscription::Linked, "onManagementofferLink");
    	 	//$subManagementofferUnlink = new \APS\EventSubscription(\APS\EventSubscription::Unlinked, "onManagementofferUnlink");
	     	//$subManagementuserLink = new \APS\EventSubscription(\APS\EventSubscription::Linked, "onManagementuserLink");
    	 	//$subManagementuserUnlink = new \APS\EventSubscription(\APS\EventSubscription::Unlinked, "onManagementuserUnlink");
			###
     		### Subscriptions to creation and removal of customer�s domains:
			###
     		$subSubscriptionAvailable = new \APS\EventSubscription(\APS\EventSubscription::Available, "onSubscriptionAvailable");
     		
			$subSubscriptionChange = new \APS\EventSubscription(\APS\EventSubscription::Changed, "onSubscriptionChange");
     		
			$subSubscriptionRemove = new \APS\EventSubscription(\APS\EventSubscription::Removed, "onSubscriptionRemove");     	
			###
     		### Subscriptions to creation and removal of customer�s service users:
			###
     		//$subUserAvailable = new \APS\EventSubscription(\APS\EventSubscription::Available, "onUserAvailable");
	     	//$subUserRemove = new \APS\EventSubscription(\APS\EventSubscription::Removed, "onUserRemove");     	
			###
     		### Connect to the APS controller
			###
     		$apsc = \APS\Request::getController();
			
     		if ($apsc == null) 
     		{
     			error_log("apsc is null");
     		}
			###
     		### Create event source classes:
			###
     		$subManagementavailable->source = new stdClass();
     		
			$subManagementremove->source = new stdClass();
     		
			$subManagementchange->source = new stdClass();
	     	//$subManagementofferLink->source = new stdClass();
    	 	//$subManagementofferUnlink->source = new stdClass();
	     	//$subManagementuserLink->source = new stdClass();
    	 	//$subManagementuserUnlink->source = new stdClass();
     		
			$subSubscriptionAvailable->source = new stdClass();
     		
			$subSubscriptionChange->source = new stdClass();
     		
			$subSubscriptionRemove->source = new stdClass();
     		//$subUserAvailable->source = new stdClass();
     		//$subUserRemove->source = new stdClass();
			###
        	### Activate the subscriptions:
			###
     		$subManagementavailable->source->type="http://intertele.pl/Test/management/1.0";
     		$apsc->subscribe($this, $subManagementavailable);
     		
			$subManagementremove->source->type="http://intertele.pl/Test/management/1.0";
     		$apsc->subscribe($this, $subManagementremove);
     		
			$subManagementchange->source->type="http://intertele.pl/Test/management/1.0";
     		$apsc->subscribe($this, $subManagementchange);
	     	
			//$subManagementofferLink->source->type="http://intertele.pl/Test/management/1.0";
    	 	//$subManagementofferLink->relation='offer';
     		//$apsc->subscribe($this, $subManagementofferLink);
	     	//$subManagementofferUnlink->source->type="http://intertele.pl/Test/management/1.0";
    	 	//$subManagementofferUnlink->relation='offer';
     		//$apsc->subscribe($this, $subManagementofferUnlink);
	     	//$subManagementuserLink->source->type="http://intertele.pl/Test/management/1.0";
    	 	//$subManagementuserLink->relation='user';
     		//$apsc->subscribe($this, $subManagementuserLink);
	     	//$subManagementuserUnlink->source->type="http://intertele.pl/Test/management/1.0";
    	 	//$subManagementuserUnlink->relation='user';
     		//$apsc->subscribe($this, $subManagementuserUnlink);
     	
     		$subSubscriptionAvailable->source->type="http://parallels.com/aps/types/pa/subscription/1.0";
     		$apsc->subscribe($this, $subSubscriptionAvailable);
     		
			$subSubscriptionChange->source->type="http://parallels.com/aps/types/pa/subscription/1.0";
     		$apsc->subscribe($this, $subSubscriptionChange);
     		
			$subSubscriptionRemove->source->type="http://parallels.com/aps/types/pa/subscription/1.0";
     		$apsc->subscribe($this, $subSubscriptionRemove);
     	
	     	//$subUserAvailable->source->type="http://parallels.com/aps/types/pa/service-user/1.1";
    	 	//$apsc->subscribe($this, $subUserAvailable);
     		//$subUserRemove->source->type="http://parallels.com/aps/types/pa/service-user/1.1";
	     	//$apsc->subscribe($this, $subUserRemove);     	
    	}
		###
     	### For each type of Event Notifications, define a handler
		###
     	### New Management is available:
		###		
     	/**
      	* @verb(POST)
     	* @path("/onManagementavailable")
     	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
     	*/
     	public function onManagementavailable($notification) 
     	{
     		$this->logger("Management created: ".json_format($notification));
     	}  
		###		
     	### A management is removed:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onManagementremove")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onManagementremove($notification) 
     	{
     		$this->logger("Management removed: ".json_format($notification));
     	}
		###
     	### A Management is linked or re-linked to an offer:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onManagementofferLink")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onManagementofferLink($notification) 
     	{
     		$this->logger("Management New offer Linked: ".json_format($notification));
	    }
		###		 
     	### A mangeemnt is unlinked from its offer:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onManagementofferUnlink")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onManagementofferUnlink($notification) 
     	{
     		$this->logger("Management Offer Unlinked: ".json_format($notification));
     	}
		###		
     	### A Management is linked or re-linked to a service user:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onManagementuserLink")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onManagementuserLink($notification) 
     	{
     		$this->logger("Management New user Linked: ".json_format($notification));
     	}
		###		
     	### A management is unlinked from its service user:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onManagementuserUnlink")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onManagementuserUnlink($notification) 
     	{
     		$this->logger("Management User UnLinked: ".json_format($notification));
     	}
		###		
     	### management properties are changed:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onManagementchange")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onManagementchange($notification) 
     	{
     		$this->logger("Management VPS properties changed: ".json_format($notification));
     	}
		###		
     	### New Subscription is available:
		###		
     	/**
      	* @verb(POST)
     	* @path("/onSubscriptionAvailable")
     	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
     	*/
     	public function onSubscriptionAvailable($notification) 
     	{
     		$this->logger("Subscription available: ".json_format($notification));
     	}
		###		
     	### A subscription is removed:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onSubscriptionChange")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onSubscriptionChange($notification) 
     	{
     		//$this->logger('Event - onSubscriptionChange - '.$this->aps->id);
     		
     		$apsc = \APS\Request::getController();
     		$wynik  = $apsc->getResource($notification->source->id);
     		
     		//$this->logger('Event - onSubscriptionChange - '.$this->aps->id."\n".json_format($notification)."\n".$wynik);
			
			$subscription_id = $wynik->subscriptionId;
     		
     		//$this->logger($serviceuser);
     	}
		###		
     	### A subscription is removed:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onSubscriptionRemove")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onSubscriptionRemove($notification) 
     	{
     		$this->logger("Subscription removed: ".json_format($notification));
     	}
		###		
     	### New service user is available:
		###		
     	/**
      	* @verb(POST)
     	* @path("/onUserAvailable")
     	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
     	*/
     	public function onUserAvailable($notification) 
     	{
     		$this->logger("New User available: ".json_format($notification));
     	}
		###		
     	### A service user is removed:
		###		
     	/**
      	* @verb(POST)
      	* @path("/onUserRemove")
      	* @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
      	*/
     	public function onUserRemove($notification) 
     	{	
     		$this->logger("User removed: ".json_format($notification));
     	}
     	###		
		### Define a function that returns the list of Notifications logged by the service
		###		
	 	/**
	 	* @verb(GET)
	 	* @path("/readNotifications")
	 	* @return(string)
	 	*/
	 	public function readNotifications() 
	 	{
	    	$log = new Logging();
	    	$log->logfile('./'.$this->aps->id.'.log');
	    	return $log->flushlog();
	 	}
		###		
	 	### Define a Logger function that will log a new Event Notification as a message
		###		
	 	function logger($message)
	 	{
	 		//echo "aaaaa";
	 		$requester=$_SERVER['REMOTE_ADDR'];
	 		$log = new Logging();
	 	
		 	//$log->logfile('./'.$this->aps->id.'.event');
	 	
		 	$log->logwrite($requester.":".$message);
		 	$log->logclose();
		 }
	}
?>