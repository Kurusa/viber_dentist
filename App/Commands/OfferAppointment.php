<?php

namespace App\Commands;

use App\ViberHelpers\GoogleClient;

class OfferAppointment extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->viberParser::getMessage() == 'another_days') {
            $this->writeFullName();
            exit();
        }
        switch ($this->viberParser::getMessage()) {
            case '0o':
            case '3o':
            case '4o':
            case '6o':
            case '7o':
            case '8o':
            case '9o':
            case '10o':
            case '11o':
                $this->db->table('recordList')->insert(['chatId' => $this->chatId, 'procedure_id' => rtrim($this->viberParser::getMessage(), 'o')]);
                $this->writeFullName();
                break;
            //Выравнивание
            case '1o':
                $this->viber->sendMessageWithKeyboard($this->text['select_procedure'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => '6o',
                            'Text' => 'Брекеты'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => '7o',
                            'Text' => 'Элайнеры'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => '8o',
                            'Text' => 'Пластины'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'main_menu',
                            'Text' => $this->text['back']
                        ],
                    ]
                ]);
                exit();
                break;
            //Эстетическая стоматология
            case '2o':
                $this->viber->sendMessageWithKeyboard($this->text['select_procedure'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => '9o',
                            'Text' => 'Отбеливание'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => '10o',
                            'Text' => 'Реставрация'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => '11o',
                            'Text' => 'Виниры'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'app_back',
                            'Text' => $this->text['back']
                        ],
                    ]
                ]);
                exit();
                break;
        }

        $action = $this->viberParser::getMessage();
        if ($action == 'how_long') {
            $this->db->table('recordList')->where('chatId', $this->chatId)->orWhere('chatId', $this->userData['chatId'])->where('done', 0)->update(['how_long' =>
                $this->viberParser::getMessage()]);
            $this->selectDay(false);
        } elseif ($action == 'dont_remem') {
            $this->viber->sendMessageWithKeyboard($this->text['dont_remember_reply'], [[$this->text['cancel']]]);
        } else {
            switch ($this->userData['mode']) {
                case 'full_name':
                    $this->writeFullName(true);
                    break;
                case 'phone_number':
                    $this->writePhoneNum(true);
                    break;
                case 'select_day':
                    if ($this->viberParser::getMessage() == 'Посмотреть другие дни недели⬇') {
                        $this->writeFullName();
                    } else {
                        $this->selectDay(true);
                    }
                    break;
                case 'select_time':
                    if ($this->viberParser::getMessage() == 'Посмотреть другие дни недели⬇') {
                        $this->writeFullName();
                    } else {
                        $this->selectTime(true);
                    }
                    break;
                case 'how_long_time':
                    $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['how_long' => $this->viberParser::getMessage()]);
                    $this->selectDay();
                    break;
                case 'how_long':
                    $this->selectHowLong(true);
                    break;
                default:
                    foreach ($this->text['service_list_actions'] as $item) {
                        $buttonList[] = [
                            "Columns" => 3,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => $item['id'] . 'o',
                            'Text' => $item['title']
                        ];
                    }
                    $buttonList[] = [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ];
                    if ($action == 'app_back') {
                        $data = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
                        if ($data[0]) {
                            $this->db->query('DELETE FROM recordListProcedures WHERE recordId = ' . $data[0]['id']);
                            $this->db->query('DELETE FROM recordList WHERE chatId = "' . $this->chatId . '" AND done = 0');
                        }
                    }
                    $this->viber->sendMessage($this->text['procedure_start']);
                    $this->viber->sendMessageWithKeyboard($this->text['select_procedure'], [
                        'Type' => 'keyboard',
                        'DefaultHeight' => true,
                        'Buttons' => $buttonList
                    ]);

                    break;
            }
        }
    }

    private function writeFullName($check = false)
    {
        if ($this->userData['fullName']) {
            $this->writePhoneNum();
        } else {
            if ($check) {
                $fio = $this->viberParser::getMessage();
                if (strlen($fio) > 5) {
                    $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['fullName' => $fio]);
                    $this->writePhoneNum();
                }
            } else {
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'full_name']);
                $this->viber->sendMessageWithKeyboard($this->text['write_full_name'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [[
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'app_back',
                        'Text' => $this->text['back']
                    ]]
                ]);
            }
        }
    }

    private function writePhoneNum($check = false)
    {
        if ($this->userData['phoneNumber']) {
            $this->selectDay(false, true);
        } else {
            if ($check) {
                $phoneNumber = $this->viberParser::getMessage();
                if (strlen($phoneNumber) > 5) {
                    $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['phoneNumber' => $phoneNumber]);
                    $this->selectDay();
                }
            } else {
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'phone_number']);
                $this->viber->sendMessageWithKeyboard($this->text['write_phone_number'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [[
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'app_back',
                        'Text' => $this->text['back']
                    ]]
                ]);
            }
        }
    }

    //день недели
    private function selectDay($check = false, $need = false)
    {
        if ($need) {
            $this->selectHowLong();
            exit;
        }
        if ($check) {
            switch ($this->viberParser::getMessage()) {
                case 'Будний день':
                    $selected_day = 0;
                    $tuesday = date(strtotime('next Tuesday', time()));
                    $thursday = date(strtotime('next Thursday', time()));
                    $date = date('c', min($tuesday, $thursday));
                    if (date('l', time()) == 'Tuesday' || date('l', time()) == 'Thursday') {
                        $date = date('c', date(strtotime('today', time())));
                    }
                    $this->db->table('recordList')->where('chatId', $this->chatId)->orWhere('chatId', $this->userData['chatId'])->where('done', 0)->update(['start_search_date' => $date, 'selected_day' => $selected_day]);
                    $this->selectTime();
                    break;
                case 'Суббота':
                    $selected_day = 1;
                    $date = date('c', (date('l', time()) == 'Saturday' ? time() : strtotime('next Saturday', time())));
                    $this->db->table('recordList')->where('chatId', $this->chatId)->orWhere('chatId', $this->userData['chatId'])->where('done', 0)->update(['start_search_date' => $date, 'selected_day' => $selected_day]);
                    $this->selectTime();
                    break;
                case 'Неважно🏳':
                    $selected_day = 2;
                    $tuesday = date(strtotime('next Tuesday', time()));
                    $thursday = date(strtotime('next Thursday', time()));
                    $saturday = date(strtotime('next Saturday', time()));
                    $date = date('c', min($tuesday, $thursday, $saturday));

                    $this->db->table('recordList')->where('chatId', $this->chatId)->orWhere('chatId', $this->userData['chatId'])->where('done', 0)->update(['start_search_date' => $date, 'selected_day' => $selected_day, 'selected_time' => 4]);
                    $this->getFreeRecords();
                    break;
            }
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'select_day']);
            $this->viber->sendMessageWithKeyboard($this->text['select_day'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Будний день',
                        'Text' => 'Будний день'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Суббота',
                        'Text' => 'Суббота'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Неважно🏳',
                        'Text' => 'Неважно🏳'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ],
                ]
            ]);
        }
    }

    //сколько недель
    private function selectHowLong($check = false)
    {
        if ($check) {
            $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['how_long_type' => $this->viberParser::getMessage() == 'Ближайшее время' ? 1 : 0]);
            $this->howLongTime();
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'how_long']);
            $this->viber->sendMessageWithKeyboard($this->text['how_long'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 6,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'На месяц вперед',
                        'Text' => 'На месяц вперед'
                    ], [
                        "Columns" => 6,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Ближайшее время',
                        'Text' => 'Ближайшее время'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ],
                ]
            ]);
        }
    }

    //продолжительность приема
    private function howLongTime()
    {
        $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'how_long_time']);
        $buttonList = [];
        foreach ($this->text['how_long_list'] as $item) {
            $buttonList[] = [
                "Columns" => 2,
                "Rows" => 1,
                'ActionType' => 'reply',
                'BgColor' => '#D1EDF2',
                "TextOpacity" => 60,
                "TextSize" => "large",
                'ActionBody' => $item['id'],
                'Text' => $item['title']
            ];
        }
        $buttonList[] = [
            "Columns" => 6,
            "Rows" => 2,
            'ActionType' => 'reply',
            'BgColor' => '#D1EDF2',
            "TextOpacity" => 60,
            "TextSize" => "large",
            'ActionBody' => 'dont_remember',
            'Text' => $this->text['dont_remember']
        ];
        $previous = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 1)->select()->results();
        if ($previous[0] || $this->userData['oldUser'] == '1') {
            $text = $this->text['select_how_long'];
        } else {
            $text = $this->text['select_how_long_new'];
        }
        $this->viber->sendMessageWithKeyboard($text, [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => $buttonList
        ]);
    }

    //часть дня
    private function selectTime($check = false)
    {
        if ($check) {
            switch ($this->viberParser::getMessage()) {
                case 'Утро':
                    $date = 1;
                    break;
                case 'День':
                    $date = 2;
                    break;
                case 'Вечер':
                    $date = 3;
                    break;
                case 'Неважно':
                    $date = 4;
                    break;
            }
            if ($date) {
                $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['selected_time' => $date]);
                $this->getFreeRecords();
            }
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'select_time']);
            $this->viber->sendMessageWithKeyboard($this->text['select_time'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Утро',
                        'Text' => 'Утро🌄'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'День',
                        'Text' => 'День🏙'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Вечер',
                        'Text' => 'Вечер🌇'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Неважно',
                        'Text' => 'Неважно🏳'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ],
                ]
            ]);
        }
    }

    private function getFreeRecords()
    {
        $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'selecting_rec_time']);

        $google = new GoogleClient();
        $data = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
        if ($data[0]['how_long_type'] === '0') {
            $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['start_search_date' => date('c', strtotime($data[0]['start_search_date'] . ' + 21 days'))]);
        }
        $data = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
        $list = $google->getRecords($data[0]['start_search_date'], date('c', strtotime($data[0]['start_search_date'] . ' + 21 days')), $data);

        if ($list) {
            $buttonList = [];
            foreach ($list as $item) {
                $buttonList[] = [
                    "Columns" => 2,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60,
                    "TextSize" => "large",
                    'ActionBody' => $item['id'],
                    'Text' => $item['title']
                ];
            }
            $buttonList[] = [
                "Columns" => 6,
                "Rows" => 1,
                'ActionType' => 'reply',
                'BgColor' => '#D1EDF2',
                "TextOpacity" => 60,
                "TextSize" => "large",
                'ActionBody' => 'another_days',
                'Text' => $this->text['another_days']
            ];
            $buttonList[] = [
                "Columns" => 6,
                "Rows" => 1,
                'ActionType' => 'reply',
                'BgColor' => '#D1EDF2',
                "TextOpacity" => 60,
                "TextSize" => "large",
                'ActionBody' => 'main_menu',
                'Text' => $this->text['main_menu']
            ];

            $this->viber->sendMessageWithKeyboard($this->text['free_time'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => $buttonList
            ]);
        } else {
            $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['selected_time' => 4]);
            $list = $google->getRecords($data[0]['start_search_date'], date('c', strtotime($data[0]['start_search_date'] . ' + 21 days')), $data);

            if ($list) {
                $buttonList = [];
                foreach ($list as $item) {
                    $buttonList[] = [
                        "Columns" => 2,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => $item['id'],
                        'Text' => $item['title']
                    ];
                }
                $buttonList[] = [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60,
                    "TextSize" => "large",
                    'ActionBody' => 'another_days',
                    'Text' => $this->text['another_days']
                ];
                $buttonList[] = [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60,
                    "TextSize" => "large",
                    'ActionBody' => 'main_menu',
                    'Text' => $this->text['main_menu']
                ];

                $this->viber->sendMessageWithKeyboard($this->text['free_time'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => $buttonList
                ]);
            } else {
                $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['selected_time' => 4]);
                $list = $google->getRecords($data[0]['start_search_date'], date('c', strtotime($data[0]['start_search_date'] . ' + 21 days')), $data);
                if ($list) {
                    $buttonList = [];
                    foreach ($list as $item) {
                        $buttonList[] = [
                            "Columns" => 2,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => $item['id'],
                            'Text' => $item['title']
                        ];
                    }
                    $buttonList[] = [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'another_days',
                        'Text' => $this->text['another_days']
                    ];
                    $buttonList[] = [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ];

                    $this->viber->sendMessageWithKeyboard($this->text['no_free_timec'], [
                        'Type' => 'keyboard',
                        'DefaultHeight' => true,
                        'Buttons' => $buttonList
                    ]);
                } else {
                    $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)
                        ->update(['start_search_date' => date('c', strtotime($data[0]['start_search_date'] . ' + 21 days'))]);
                    $data = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
                    $list = $google->getRecords($data[0]['start_search_date'], date('c', strtotime($data[0]['start_search_date'] . ' + 21 days')), $data);
                    $buttonList = [];
                    foreach ($list as $item) {
                        $buttonList[] = [
                            "Columns" => 2,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => $item['id'],
                            'Text' => $item['title']
                        ];
                    }
                    $buttonList[] = [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'another_days',
                        'Text' => $this->text['another_days']
                    ];
                    $buttonList[] = [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ];

                    $this->viber->sendMessageWithKeyboard($this->text['no_free_time'], [
                        'Type' => 'keyboard',
                        'DefaultHeight' => true,
                        'Buttons' => $buttonList
                    ]);
                }
            }
        }
    }


}