<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 19/07/18
 * Time: 21:29
 */

namespace App\Service;


use Maknz\Slack\Client;
use App\Helper\LoggerTrait;

class SlackClient
{
    use LoggerTrait;

    private $slack;

    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    public function sendMessage(string $from, string $message)
    {

        $this->logInfo('Beaming a message to Slack!', [
            'message' => $message
        ]);

        $slackMessage = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message)
        ;

        $this->slack->sendMessage($slackMessage);
    }
}