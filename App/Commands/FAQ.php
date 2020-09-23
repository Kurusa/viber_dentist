<?php

namespace App\Commands;

use App\TgHelpers\TelegramKeyboard;

class FAQ extends BaseCommand {

    function processCommand($par = false)
    {
        $this->viber->sendMessageWithKeyboard($this->text['faq_about'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    "Columns" => 3,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'to_doctor',
                    'Text' => $this->text['to_doctor']
                ], [
                    "Columns" => 3,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'another_questions',
                    'Text' => $this->text['another_questions']
                ], [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'main_menu',
                    'Text' => $this->text['main_menu']
                ],
            ]
        ]);
    }

}