<?php

namespace App\Commands;

class AnotherQuestions extends BaseCommand {

    function processCommand($par = false)
    {
        if (strpos($this->viberParser::getMessage(), 'ask_another') !== false) {
            $explode = explode('_', $this->viberParser::getMessage())[2];
            if ($explode == 1) {
                $this->triggerCommand(Address::class);
                exit;
            }

            $this->viber->sendMessageWithKeyboard($this->text['another_questions_' . $explode], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_1',
                        'Text' => 1
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_2',
                        'Text' => 2
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_3',
                        'Text' => 3
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_4',
                        'Text' => 4
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_5',
                        'Text' => 5
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_6',
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
            $this->viber->sendMessage($this->text['another_questions_before']);
            $this->viber->sendMessageWithKeyboard($this->text['another_questions_about'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_1',
                        'Text' => 1
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_2',
                        'Text' => 2
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_3',
                        'Text' => 3
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_4',
                        'Text' => 4
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_5',
                        'Text' => 5
                    ], [
                        "Columns" => 1,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'ask_another_6',
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