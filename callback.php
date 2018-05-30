<?php // callback.php
    define("LINE_MESSAGING_API_CHANNEL_SECRET", 'b2a11f190f42aa183e087d6c29a6dfea');
    define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'D6Z4xq2AuLVdOcFKISGs2TrweRkyGswqentG6FL/QRI9K0c7+JximL1yUM6lftv/40sMUNVyDoMB1QN+708xZOyfVsFjHH3H5dqG87PenA+sgSuOoe2orpDmf+/LyfAKaIBbttboOMJLt3ADaO/G0QdB04t89/1O/w1cDnyilFU=');

    require __DIR__."/vendor/autoload.php";

    $bot = new \LINE\LINEBot(
        new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
        ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
    );

    $signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
    $body = file_get_contents("php://input");

    $events = $bot->parseEventRequest($body, $signature);

    foreach ($events as $event) {
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
            $reply_token = $event->getReplyToken();
            $text = $event->getText();
            $bot->replyText($reply_token, $text);
        }
    }

    echo "OK";
