<?php

namespace App\Commands\ServiceList;

use App\Commands\BaseCommand;

class TeethAlignment extends BaseCommand {

    function processCommand($par = false)
    {
        switch ($this->viberParser::getMessage()) {
            case '1':
                //Send action list
                $this->viber->sendMessageWithKeyboard($this->text['service_list_1'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'brec',
                            'Text' => 'Брекеты'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'ele',
                            'Text' => 'Элайнеры'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'plast',
                            'Text' => 'Пластины'
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
            case 'brec':
            case 'ele':
            case 'plast':
                //First action list
                switch ($this->viberParser::getMessage()) {
                    //Брекеты
                    case 'brec':
                        $this->viber->sendMessageWithKeyboard($this->text['braces'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracPhoto',
                                    'Text' => $this->text['which_photos']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracCost',
                                    'Text' => $this->text['cost_notion'] //Принцип оплаты💰
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracTempl',
                                    'Text' => $this->text['work_templates']
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
                    //Элайнеры
                    case 'ele':
                        $this->viber->sendMessageWithKeyboard($this->text['eliners_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'eleTempl',
                                    'Text' => $this->text['work_templates']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'eleCost',
                                    'Text' => $this->text['eliners_cost']
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
                    //Пластины
                    case 'plast':
                        $this->viber->sendMessageWithKeyboard($this->text['plates_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'platTempl',
                                    'Text' => $this->text['work_templates']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'platPhoto',
                                    'Text' => $this->text['which_photos']
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
                break;

            case 'platPhoto':
            case 'platTempl':
                switch ($this->viberParser::getMessage()) {
                    //Какие снимки нужны?🎞
                    case 'platPhoto':
                        $this->viber->sendMessageWithKeyboard($this->text['plates_photos'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'platTempl',
                                    'Text' => $this->text['work_templates']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'open-url',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'http://www.3dcenter.com.ua/adresa',
                                    'Text' => $this->text['planmeca_address']
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
                    //Примеры работ📸
                    case 'platTempl':
                        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/plates_temp0.jpeg');
                        $this->viber->sendMessageWithKeyboard($this->text['plates_temp'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 2,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'platPhoto',
                                    'Text' => $this->text['which_photos']
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
                break;
            case 'eleTempl':
            case 'eleCost':
                switch ($this->viberParser::getMessage()) {
                    //Стоимость элайнеров💰
                    case 'eleCost':
                        $this->viber->sendMessageWithKeyboard($this->text['eliners_cost_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 2,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'eleTempl',
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
                    //Примеры работ📸
                    case 'eleTempl':
                        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/eliners_temp0.jpeg');
                        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/eliners_temp1.jpeg');

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
                                    'ActionBody' => 'eleCost',
                                    'Text' => $this->text['eliners_cost']
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
                break;

            case 'bracPhoto':
            case 'bracTempl':
            case 'bracConsultCost': // цена консультации
            case 'bracPrinc': // принцип оплати
                switch ($this->viberParser::getMessage()) {
                    //Какие снимки нужны
                    case 'bracPhoto':
                        $this->viber->sendMessageWithKeyboard($this->text['bracAs_0'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'open-url',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'http://www.3dcenter.com.ua/adresa',
                                    'Text' => $this->text['planmeca_address']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracConsultCost',
                                    'Text' => $this->text['braces_cost'] // Цена консультации
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracTempl',
                                    'Text' => $this->text['work_templates']
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
                    //цена консультации
                    case 'bracConsultCost':
                        $this->viber->sendMessageWithKeyboard($this->text['braces_cost_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'open-url',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'http://www.3dcenter.com.ua/adresa',
                                    'Text' => $this->text['planmeca_address']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracPrinc',
                                    'Text' => $this->text['cost_notion'] // принцип оплати
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 1,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracTempl',
                                    'Text' => $this->text['work_templates']
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
                    case 'bracPrinc':
                        $this->viber->sendMessageWithKeyboard($this->text['cost_about'], [
                            'Type' => 'keyboard',
                            'DefaultHeight' => true,
                            'Buttons' => [
                                 [
                                    "Columns" => 6,
                                    "Rows" => 2,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracPhoto',
                                    'Text' => $this->text['about_cost'] // о консультации
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 2,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracTempl',
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
                    case 'bracTempl':
                        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/braces_temp0.jpeg');
                        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/braces_temp1.jpeg');
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
                                    'ActionBody' => 'bracPhoto',
                                    'Text' => $this->text['which_photos']
                                ], [
                                    "Columns" => 6,
                                    "Rows" => 2,
                                    'ActionType' => 'reply',
                                    'BgColor' => '#D1EDF2',
                                    "TextOpacity" => 60, "TextSize" => "large",
                                    'ActionBody' => 'bracPhoto',
                                    'Text' => $this->text['about_cost']
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
                break;
        }
    }

}