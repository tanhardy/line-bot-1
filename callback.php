<?php // callback.php
    define("LINE_MESSAGING_API_CHANNEL_SECRET", 'eae07454071e6665a3066fa7e1aea240');
    define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'VXdNfb6gCuFsxYvfjvSIP0eO/Vt+6I6vy5Fy+kSkTyh5/lDJxgWe2LJWnZ2bD0HKK0ensLVlYgQgZgjY4tMb8ENo/gvJZXUfi2dGF9DGNgq38+4EIV8HF4Myi3msvqOroJXBppZYoiL38MWhAU3QUwdB04t89/1O/w1cDnyilFU=');

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