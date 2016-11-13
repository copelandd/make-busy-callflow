<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class NoSubstitute extends DeviceTestCase {

    public function setUp() {
        self::$b_device->resetCfParams(self::C_EXT);
        self::$b_device->setCfParam("substitute", FALSE);
    }

    public function tearDown() {
        self::$b_device->resetCfParams();
    }

    public function main($sip_uri) {
        $target  = self::B_EXT .'@'. $sip_uri;

        $ch_a = self::ensureChannel( self::$a_device->originate($target) );
        $ch_b = self::ensureChannel( self::$b_device->waitForInbound() );
        $ch_c = self::ensureChannel( self::$c_device->waitForInbound() );
        
        self::ensureAnswer($ch_a, $ch_c);
        self::hangupBridged($ch_a, $ch_c);
    }

}