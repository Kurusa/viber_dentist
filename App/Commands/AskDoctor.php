<?php

namespace App\Commands;

class AskDoctor extends BaseCommand {

    function processCommand($par = false)
    {
        if (strpos($this->viberParser::getMessage(), 'ask_doctor') !== false) {
            $explode = explode('_', $this->viberParser::getMessage())[2];

            $this->viber->sendMessageWithKeyboard($this->text['to_doctor_' . $explode], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_1',
                        'Text' => 1
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_2',
                        'Text' => 2
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_3',
                        'Text' => 3
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_4',
                        'Text' => 4
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_5',
                        'Text' => 5
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_6',
                        'Text' => 6
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'faq',
                        'Text' => 'Назад ⬅'
                    ],
                ]
            ]);
        } else {
            $this->viber->sendMessageWithKeyboard($this->text['to_doctor_about'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_1',
                        'Text' => 1
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_2',
                        'Text' => 2
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_3',
                        'Text' => 3
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_4',
                        'Text' => 4
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_5',
                        'Text' => 5
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_doctor_6',
                        'Text' => 6
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'faq',
                        'Text' => 'Назад ⬅'
                    ],
                ]
            ]);
        }
    }

}