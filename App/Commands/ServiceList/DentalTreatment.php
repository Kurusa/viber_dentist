<?php

namespace App\Commands\ServiceList;

use App\Commands\BaseCommand;

class DentalTreatment extends BaseCommand {

    function processCommand($par = false)
    {
        switch ($this->viberParser::getMessage()) {
            case '0':
                $this->viber->sendMessageWithKeyboard($this->text['service_list_0'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'c0',
                            'Text' => $this->text['cost']
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'teml_0',
                            'Text' => $this->text['work_templates']
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
                break;
            case 'c0':
                $this->viber->sendMessageWithKeyboard($this->text['service_list_0_cost'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 2,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'teml_0',
                            'Text' => $this->text['work_templates']
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
                break;
            case 'teml_0':
                $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/service_list_0_temp0.jpeg');

                $this->viber->sendMessageWithKeyboard($this->text['work_templates'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 2,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'c0',
                            'Text' => $this->text['cost']
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
                break;
        }
    }

}