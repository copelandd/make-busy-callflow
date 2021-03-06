<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

// MKBUSY-23
// Changing owner assignmnets.
class OwnerChange extends UserTestCase {

    public function setUpTest() {
        self::$b_device_2->setDeviceParam('owner_id', self::$c_user->getId());
        self::$b_device_2->getGateway()->register();
    }

    public function tearDownTest() {
        self::$b_device_2->setDeviceParam('owner_id', self::$b_user->getId());
        self::$b_device_2->getGateway()->register();
    }

    public function main($sip_uri) {
        $target = self::B_NUMBER .'@'. $sip_uri;
        $channel_a = self::ensureChannel( self::$a_device_1->originate($target) );
        $channel_b_1 = self::ensureChannel( self::$b_device_1->waitForInbound() );
        self::assertEmpty( self::$b_device_2->waitForInbound() );
        self::hangupChannels($channel_a, $channel_b_1);

        $target = self::C_NUMBER .'@'. $sip_uri;
        $channel_a = self::ensureChannel( self::$a_device_1->originate($target) );
        $channel_b_2 = self::ensureChannel( self::$b_device_2->waitForInbound() );
        self::hangupChannels($channel_a, $channel_b_2);
    }

}