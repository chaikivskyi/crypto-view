<?php

namespace App\Filament\Pages;

use App\Services\TelegramBotService;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageApp extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected TelegramBotService $telegramBotService;

    public function __construct()
    {
        $this->telegramBotService = app(TelegramBotService::class);
        static::$title = __('Settings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes(['class' => 'max-w-md '])
            ->columns(1)
            ->schema([
                TextInput::make('changePercentage')
                    ->label('Change Percentage (%)')
                    ->integer()
                    ->helperText('The percentage change threshold that pass the notification message to be sent.')
                    ->required(),
                TextInput::make('telegramToken')
                    ->label('Telegram Bot Token'),
                Select::make('telegramChatId')
                    ->label('Telegram Chat Id')
                    ->options(function (callable $get) {
                        $telegramToken = $get('telegramToken');

                        if (!$telegramToken) {
                            return [];
                        }

                        return array_column(
                            $this->telegramBotService->getChats(),
                            'title',
                            'id'
                        );
                    })
            ]);
    }
}
