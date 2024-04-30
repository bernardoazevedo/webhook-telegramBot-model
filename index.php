<?php 
require_once 'config.php';
require_once 'bot.class.php';

$request = $_SERVER['REQUEST_URI'];

switch($request){
    case '':
        $bot = new Bot(BOT_NAME);
        $bot->start();
        break;

    case '/':
        $bot = new Bot(BOT_NAME);
        $bot->start();
        break;

    case '/setWebhook':
        $bot = new Bot(BOT_NAME);
        $bot->setWebhook();
        break;
        
    case '/deleteWebhook':
        $bot = new Bot(BOT_NAME);
        $bot->deleteWebhook();
        break;

    default:
        http_response_code(404);
}
