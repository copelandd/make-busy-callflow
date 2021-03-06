<?php
namespace KazooTests\Applications\Callflow\Device;

use KazooTests\Applications\Callflow\DeviceTestCase;
use \MakeBusy\Common\Log;

class Milliwatt extends DeviceTestCase {

    public function main($sip_uri) {
        $target = self::MILLIWATT_NUMBER . '@' . $sip_uri;
        $channel = self::ensureChannel( self::$no_device->originate($target) );
        $this->hangupChannels($channel);
   }

}