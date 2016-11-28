<?php

require_once 'testbase.php';
require_once 'lib/logger.php';

class configure extends TestBase
{
    protected $DEFAULT_COUNTRY = 'us';

    public function createApplication($app_id, $endpoint_url, $package_version = null)
    {
        \APSTEST\Logger::info("Creating application instance for application #$app_id with endpoint $endpoint_url");
        $asettings = $this->getParam('instanceProperties');
        $result = $this->createApplicationInstance($app_id, $endpoint_url, $asettings, $package_version);
        \APSTEST\Logger::info("Application Instance is created. ID: ".$result['app_instance_id']."; APS resource ID: ".$result['app_resource_id']);

        $offersData = $this->getParam('offersData');
        foreach($offersData as $name=>$offer)
		{
            $offer->aps->type = $this->getTypeId('offers');
            $offerStr = json_encode($offer);
            \APSTEST\Logger::info("Adding offer $offerStr");
            $offers[$name] = $this->createResourceInCollection($result['app_resource_id'], "offers", $offerStr);
        }
        $result['offers'] = $offers;
        return $result;
    }

    public function createRTs($app_id, $instance)
    {   
        $testName = $this->getParam('test_name');

        # Application Service Reference for the Application itself
        $RTs[] = $this->createAppServiceRefRT($testName.' APP REF', $app_id, $instance['app_resource_id']);

        # Application Service Reference for each Brand
        foreach($instance['offers'] as $name => $offer) 
		{
            $billingRT = array
			(
                "Included" => 20.0,
                "RecurringFee" => 0.0,
                "OverusageFee" => 0.0,
                "Maximum" => -1.0,
                "Mesurable" => 0
            );    
            \APSTEST\Logger::debug("BM RT set: ".print_r($billingRT, true));
            $RTs[] = $this->createAppServiceRefRT("$testName $name SRV REF", $app_id, $offer->aps->id, 10, $billingRT);
        }
        # Application Services for 'contexts' and 'environments'
        $RTs[] = $this->createAppServiceRT("$testName SRV context", $app_id, "contexts",1);
        $RTs[] = $this->createAppServiceRT("$testName SRV vpses", $app_id, "vpses",0, 20);
        $billingRT = array
		(
            "Included" => 20000000.0,
            "RecurringFee" => 0.0,
            "OverusageFee" => 0.0,
            "Maximum" => 40000000.0,
            "Mesurable" => 1
        );    
        \APSTEST\Logger::debug("BM RT set: ".print_r($billingRT, true));
        $RTs[] = $this->createAppCounterRT("$testName COUNTER diskspace", $app_id, "contexts", "diskusagetotal", "kb", 20000000, $billingRT);

        return $RTs;
    }

    public function removeApplicationInstance($app_instance)
    {
        foreach ($app_instance->offers as $name => $offer) 
		{
            $this->removeResource($offer); 
        }
        parent::removeApplicationInstance($app_instance);
    }
}
