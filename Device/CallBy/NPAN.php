<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class SipNPAN extends DeviceTestCase {

    public function setUp() {
        self::$b_device->setInviteFormat("npan");
    }

    public function tearDown() {
        self::$b_device->setInviteFormat("username");
    }

    public function main($sip_uri) {
        $target = self::B_NUMBER .'@'. $sip_uri;
        $ch_a = self::ensureChannel( self::$a_device->originate($target) );
        $ch_b = self::ensureChannel( self::$b_device->waitForInbound(self::B_NUMBER) );
        self::ensureAnswer($ch_a, $ch_b);
        self::hangupBridged($ch_a, $ch_b);
    }

}