<?php

namespace App\Commands\ServiceList;

use App\Commands\BaseCommand;
use App\TgHelpers\TelegramKeyboard;

class Prosthesis extends BaseCommand {

    function processCommand($par = false)
    {
        $this->viber->sendMessageWithKeyboard($this->text['prosthesis_about'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    "Columns" => 6,
                    "Rows" => 2,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'mapp',
                    'Text' => $this->text['mapp']
                ], [
                    "Columns" => 6,
                    "Rows" => 2,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'service_list',
                    'Text' => $this->text['back_to_service_list']
                ],
            ]
        ]);
    }

}