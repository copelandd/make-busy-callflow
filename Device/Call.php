<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class UserName extends DeviceTestCase {

    public function main($sip_uri) {
        $target = self::B_EXT .'@'. $sip_uri;
        $channel_a = self::ensureChannel( self::$a_device->originate($target) );
        $channel_b = self::ensureChannel( self::$b_device->waitForInbound() );

        self::ensureAnswer($channel_a, $channel_b);
        self::ensureEvent($channel_a->waitPark());
        self::ensureTwoWayAudio($channel_a, $channel_b);
        self::hangupBridged($channel_a, $channel_b);
    }

}