<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function __construct(
        private string $botToken = '',
        private string $chatId = ''
    ) {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId   = config('services.telegram.chat_id');
    }

    public function sendMessage(string $html): void
    {
        if (!$this->botToken || !$this->chatId) return;

        Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $html,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ])->throw();
    }

    /**
     * Kirim foto dengan upload file (multipart). Bisa jalan di localhost.
     */
    public function sendPhoto(string $absoluteFilePath, string $captionHtml = ''): void
    {
        if (!$this->botToken || !$this->chatId) return;
        if (!is_file($absoluteFilePath)) return;

        $url = "https://api.telegram.org/bot{$this->botToken}/sendPhoto";

        Http::attach(
            'photo',
            file_get_contents($absoluteFilePath),
            basename($absoluteFilePath)
        )->post($url, [
            'chat_id' => $this->chatId,
            'caption' => $captionHtml,
            'parse_mode' => 'HTML',
        ])->throw();
    }
}
