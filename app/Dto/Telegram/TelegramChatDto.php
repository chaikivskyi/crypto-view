<?php

namespace App\Dto\Telegram;

class TelegramChatDto
{
    public function __construct(
        public int $id,
        public string $type,
        public string $title,
    ) {
    }
}
