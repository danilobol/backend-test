<?php

namespace App\Services\Log;

use Monolog\Handler\TelegramBotHandler;
use Monolog\Handler\Curl\Util;
use RuntimeException;

class LogTelegram extends TelegramBotHandler
{
    public function write(array $record): void
    {
        $message = "[{$record['level_name']}] - data: {$record['datetime']->format('d/m/Y H:i:s')} - message: ".mb_strimwidth($record['message'], 0, 2000, '...'). "";
        if (isset($record['context']['exception'])) {
            $message .= " - File: {$record['context']['exception']->getFile()} - Line: {$record['context']['exception']->getLine()}";
        }
        $record['formatted'] = $message;
        parent::write($record);
    }
}
