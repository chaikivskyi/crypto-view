<?php

namespace App\Services;

use App\Dto\Telegram\TelegramChatDto;
use Exception;
use NotificationChannels\Telegram\TelegramUpdates;

class TelegramBotService
{
    /**
     * @return TelegramChatDto[]
     */
    public function getChats(): array
    {
        $chats = [];

        try {
            $updates = TelegramUpdates::create()->get();

            if(isset($updates['ok']) && $updates['ok']) {
                foreach ($updates['result'] as $update) {
                    $chats[$update['message']['chat']['id']] = new TelegramChatDto(
                        $update['message']['chat']['id'],
                        $update['message']['chat']['type'],
                        $update['message']['chat']['title']
                    );
                }
            }
        } catch (Exception $e) {
        }

        return array_values($chats);
    }
}
