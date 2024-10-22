<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.changePercentage', 5);
        $this->migrator->add('general.telegramToken');
        $this->migrator->add('general.telegramChatId');
    }

    public function down(): void
    {
        $this->migrator->remove('general.changePercentage');
        $this->migrator->remove('general.telegramToken');
        $this->migrator->remove('general.telegramChatId');
    }
};
