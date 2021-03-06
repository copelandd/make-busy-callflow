<?php
namespace KazooTests\Applications\Callflow\Device;

use KazooTests\Applications\Callflow\DeviceTestCase;
use \MakeBusy\Common\Log;

class CallerIdEmergency extends DeviceTestCase {

    public function main($sip_uri) {
        $target  = self::EMERGENCY_NUMBER .'@'. $sip_uri;
        $channel_a = self::ensureChannel( self::$a_device->originate($target) );
        $channel_b = self::ensureChannel( self::$emergency_resource->waitForInbound(self::EMERGENCY_NUMBER) );
        $a_cidnum = self::$a_device->getCidParam("emergency")->number;
        $a_cidname = self::$a_device->getCidParam("emergency")->name;
        $b_cidnum = urldecode($channel_b->getEvent()->getHeader("Caller-Caller-ID-Number"));
        $b_cidname = urldecode($channel_b->getEvent()->getHeader("Caller-Caller-ID-Name"));
        self::assertEquals($a_cidnum, $b_cidnum, "Emergency Number - " . $a_cidnum . " - " . $b_cidnum);
        self::assertEquals($a_cidname, $b_cidname, "Emergency Name - " . $a_cidname . " - " . $b_cidname);
        self::ensureAnswer($channel_a, $channel_b);
        self::hangupBridged($channel_a, $channel_b);
    }

}