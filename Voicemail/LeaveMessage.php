<?php
namespace KazooTests\Applications\Callflow;
use \MakeBusy\Common\Log;

//MKBUSY-26
class LeaveMessage extends VoicemailTestCase {

    public function tearDownTest() {
        self::$b_voicemail_box->resetVoicemailBox();
    }

    public function main($sip_uri) {
        $target = self::B_USER_NUMBER . '@' . $sip_uri;
        self::leaveMessage(self::$a_device, self::VM_COMPOSE_B_CODE, "VM-SAMPLE-MESSAGE-1");

        $messages = self::$b_voicemail_box->getMessages();
        self::assertNotNull($messages[0]->media_id);

        $channel_b = self::ensureAnswered(self::$b_device->originate($target, 30), 30);

        self::expectPrompt($channel_b, "VM-ENTER_PASS");
        $channel_b->sendDtmf(self::DEFAULT_PIN);

        self::expectPrompt($channel_b, "VM-YOU_HAVE");
        self::expectPrompt($channel_b, "VM-NEW_MESSAGE");
        self::expectPrompt($channel_b, "VM-MAIN_MENU");

        $channel_b->sendDtmf('1');

        self::expectPrompt($channel_b, "VM-MESSAGE_NUMBER");

        self::expectPrompt($channel_b, "VM-SAMPLE-MESSAGE-1");

        self::expectPrompt($channel_b, "VM-RECEIVED");
        self::expectPrompt($channel_b, "VM-MESSAGE_MENU", 20);

        $channel_b->sendDtmf('7');

        self::expectPrompt($channel_b, "VM-DELETED");

        $channel_b->hangup();
        $channel_b->waitHangup();

        self::$b_voicemail_box->resetVoicemailBox();
        self::$b_voicemail_box->resetVoicemailBoxParam("media");
    }

}