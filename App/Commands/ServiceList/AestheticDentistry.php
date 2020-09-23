<?php

namespace App\Commands\ServiceList;

use App\Commands\BaseCommand;
use App\TgHelpers\TelegramKeyboard;

class AestheticDentistry extends BaseCommand {

    function processCommand($par = false)
    {
        switch ($this->viberParser::getMessage()) {
            case '2':
                //Send action list
                $this->viber->sendMessageWithKeyboard($this->text['service_list_2'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'otbel',
                            'Text' => 'Отбеливание'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'restavr',
                            'Text' => 'Реставрация'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'vinir',
                            'Text' => 'Виниры'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'service_list',
                            'Text' => $this->text['back_to_service_list']
                        ],
                    ]
                ]);
                break;
            case 'vinir':
            case 'restavr':
            case 'otbel':
                //First action list
                switch ($this->viberParser::getMessage()) {
                    //Отбеливание
                    case 'otbel':
                        $this->viber->sendMessageWithKeyboard($this->text['whitening_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'mapp',
                                    'Text' => $this->text['mapp']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'otbelTempl',
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
                    //Виниры
                    case 'vinir':
                        $this->viber->sendMessageWithKeyboard($this->text['venees_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [[
                                "Columns" => 6,
                                "Rows" => 4,
                                'ActionType' => 'reply',
                                'BgColor' => '#D1EDF2',
                                "TextOpacity" => 60, "TextSize" => "large",
                                'ActionBody' => 'service_list',
                                'Text' => $this->text['back_to_service_list']
                            ]]
                        ]);
                        break;
                    //Реставрация
                    case 'restavr':
                        $this->viber->sendMessageWithKeyboard($this->text['restoration_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'contact_us',
                                    'Text' => $this->text['send_photo']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'restavrTempl',
                                    'Text' => $this->text['work_templates']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 2,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'service_list',
                                    'Text' => $this->text['back_to_service_list']
                                ]
                            ]
                        ]);
                        break;
                }
                break;
            case 'otbelTempl':
                //Примеры работ📸
                $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/aesthetic_0_temp0.jpeg');
                $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/aesthetic_0_temp1.jpeg');
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
                break;
            case 'restavrTempl':
                //Примеры работ📸
                $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/restoration_temp_2.jpeg');
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
                            'ActionBody' => 'contact_us',
                            'Text' => $this->text['send_photo']
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