<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

class Login extends ConferenceTestCase {

    public function main($sip_uri) {
        $target = self::CONF_EXT .'@'. $sip_uri;
        $ch_a = self::ensureChannel( self::$devices["a"]->originate($target) );
        self::ensureEvent( $ch_a->waitPark() );
        self::expectPrompt($ch_a, "CONF-WELCOME");
        self::hangupChannels($ch_a);
    }

}