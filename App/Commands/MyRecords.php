<?php

namespace App\Commands;

use App\ViberHelpers\GoogleClient;
use App\ViberHelpers\TelegramApi;

class MyRecords extends BaseCommand {

    private $recordId;

    function processCommand($par = false)
    {
        $action = $this->viberParser::getMessage();
        switch ($action) {
            case 'cancel_record':
                $recordId = $this->userData['recordId'];
                $data = $this->db->table('recordList')->where('id', $recordId)->select()->results();
                $this->viber->sendMessageWithKeyboard($this->text['cancel_confirm'] . $data[0]['exact_date'] . '?', [
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
                            'ActionBody' => 'cancel_confirm',
                            'Text' => 'Да, отменять'
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => 'change_record_time',
                            'Text' => $this->text['change_record_time']
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => 'my_records',
                            'Text' => $this->text['back']
                        ]
                    ]
                ]);
                exit();
            case 'change_record_time':
                $this->recordId = $this->userData['recordId'];
                $this->db->table('recordList')->where('id', $this->recordId)->update(['edit' => 1, 'done' => 0]);
                $this->selectHowLong();
                exit();
            case 'cancel_confirm':
                $recordId = $this->userData['recordId'];
                $data = $this->db->table('recordList')->where('id', $recordId)->select()->results();
                $googleClient = new GoogleClient();
                $googleClient->delete($data[0]['event_id']);
                $this->db->query('DELETE FROM recordListProcedures WHERE recordId = ' . $recordId);
                $this->db->query('DELETE FROM recordList WHERE id = ' . $recordId);
                $this->db->table('recordCancelsList')->insert(['chatId' => $this->chatId, 'date' => date('c', time())]);
                $this->viber->sendMessageWithKeyboard($this->text['after_cancel'], [
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
                            'ActionBody' => 'mapp',
                            'Text' => $this->text['mapp']
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => 'contact_us',
                            'Text' => $this->text['contact_us']
                        ], [
                            "Columns" => 6,
                            "Rows" => 1,
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60,
                            "TextSize" => "large",
                            'ActionBody' => 'main_menu',
                            'Text' => $this->text['main_menu']
                        ]
                    ]
                ]);
                $count = $this->db->query('SELECT COUNT(*) AS count FROM recordCancelsList WHERE DATE(date) = CURDATE() AND chatId = "' . $this->chatId . '"');
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['recordId' => 0, 'mode' => 'done']);

                if ($count[0]['count'] == 3) {
                    $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['isBlockedByBot' => 1]);
                    $this->viber->sendMessageWithKeyboard($this->text['too_many_cancels'], [
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
                                'ActionBody' => 'contact_us',
                                'Text' => $this->text['contact_us']
                            ]
                        ]
                    ]);
                }
                $adminText = 'Вайбер' . "\n";
                $adminText .= 'Отмена записи ❌' . "\n";
                $adminText .= 'ФИО: ' . $this->userData['fullName']
                    . "\n" . 'Телефон: ' . $this->userData['phoneNumber'];
                (new TelegramApi())->sendMessage($adminText, 205187375);
                exit();
            case 'dont_remember':
                $this->triggerCommand(MainMenu::class, $this->text['dont_remember_reply']);
                exit();
        }

        switch ($this->userData['mode']) {
            case 'how_long_time_rec':
                $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['how_long' => $this->viberParser::getMessage()]);
                $this->selectDay();
                exit();
            case 'how_long_rec':
                $this->selectHowLong(true);
                exit();
            case 'select_day_rec':
                $this->selectDay(true);
                exit();
            case 'select_time_rec':
                $this->selectTime(true);
                exit();
            case 'my_record':
                $recordId = intval($this->viberParser::getMessage());
                if ($recordId > 20) {
                    $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['recordId' => $recordId]);
                    $data = $this->db->table('recordList')->where('id', $recordId)->select()->results();
                    $this->viber->sendMessageWithKeyboard($this->text['your_record'] . ': ' .
                        $this->getProcedureTitle($data[0]) . ' ' . $data[0]['exact_date'] . '                                                             ' .
                        $this->text['your_record_info'], [
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
                                'ActionBody' => 'cancel_record',
                                'Text' => $this->text['cancel_record']
                            ], [
                                "Columns" => 6,
                                "Rows" => 1,
                                'ActionType' => 'reply',
                                'BgColor' => '#D1EDF2',
                                "TextOpacity" => 60,
                                "TextSize" => "large",
                                'ActionBody' => 'change_record_time',
                                'Text' => $this->text['change_record_time']
                            ], [
                                "Columns" => 6,
                                "Rows" => 1,
                                'ActionType' => 'reply',
                                'BgColor' => '#D1EDF2',
                                "TextOpacity" => 60,
                                "TextSize" => "large",
                                'ActionBody' => 'my_records',
                                'Text' => $this->text['back']
                            ]
                        ]
                    ]);
                } elseif ($this->viberParser::getMessage() == 'my_records') {
                    $this->sendList();
                } else {
                    $this->triggerCommand(MainMenu::class);
                }
                exit();
        }

        $this->sendList();
    }

    private function sendList()
    {
        $data = $this->db->table('recordList')->where('chatId', $this->chatId)->orWhere('chatId', $this->userData['chatId'])->where('done', 1)->orderBy('exact_date')->select()->results();
        $buttonList = [];
        if ($data[0]) {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'my_record']);
            foreach ($data as $item) {
                $buttonList[] = [
                    "Columns" => 2,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60,
                    "TextSize" => "large",
                    'ActionBody' => $item['id'],
                    'Text' => $this->getProcedureTitle($item) . ' ' . $item['exact_date']
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
            $this->viber->sendMessageWithKeyboard($this->text['your_records'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => $buttonList
            ]);
        } else {
            $this->triggerCommand(MainMenu::class, $this->text['no_records']);
        }
    }

    private function selectHowLong($check = false)
    {
        if ($check) {
            $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['how_long_type' => $this->viberParser::getMessage() == 'Ближайшее время' ? 1 : 0]);
            $this->howLongTime();
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'how_long_rec']);
            $this->viber->sendMessageWithKeyboard($this->text['how_long'], [
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
                        'ActionBody' => 'Ближайшее время',
                        'Text' => 'Ближайшее время'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'На месяц вперед',
                        'Text' => 'На месяц вперед'
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

    private function howLongTime()
    {
        $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'how_long_time_rec']);
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
            "Rows" => 1,
            'ActionType' => 'reply',
            'BgColor' => '#D1EDF2',
            "TextOpacity" => 60,
            "TextSize" => "large",
            'ActionBody' => 'dont_remember',
            'Text' => $this->text['dont_remember']
        ];

        $this->viber->sendMessageWithKeyboard($this->text['select_how_long'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => $buttonList
        ]);
    }

    private function selectDay($check = false)
    {
        if ($check) {
            switch ($this->viberParser::getMessage()) {
                case 'Будний день':
                    $selected_day = 0;
                    $date = date('c', min(date(strtotime('next Thursday', time())), date(strtotime('next Tuesday', time()))));
                    if (date('l', time()) == 'Tuesday' || date('l', time()) == 'Thursday') {
                        $date = date('c', time());
                    }
                    $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['start_search_date' => $date, 'selected_day' => $selected_day]);
                    $this->selectTime();
                    break;
                case 'Суббота':
                    $selected_day = 1;
                    $date = date('c', (date('l', time()) == 'Saturday' ? time() : strtotime('next Saturday', time())));
                    $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['start_search_date' => $date, 'selected_day' => $selected_day]);
                    $this->selectTime();
                    break;
                case 'Неважно🏳':
                    $selected_day = 2;
                    $date = date('c', min(date(strtotime('next Tuesday', time())), date(strtotime('next Thursday', time())), date(strtotime('next Saturday', time()))));
                    $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['start_search_date' => $date, 'selected_day' => $selected_day, 'selected_time' => 4]);
                    $this->getFreeRecords();
                    break;
            }
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'select_day_rec']);
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

    private function selectTime($check = false)
    {
        if ($check) {
            switch ($this->viberParser::getMessage()) {
                case 'Утро🌄':
                    $date = 1;
                    break;
                case 'День🏙':
                    $date = 2;
                    break;
                case 'Вечер🌇':
                    $date = 3;
                    break;
                case 'Неважно🏳':
                    $date = 4;
                    break;
            }
            if ($date) {
                $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['selected_time' => $date]);
                $this->getFreeRecords();
            }
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'select_time_rec']);
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
                        'ActionBody' => 'Утро🌄',
                        'Text' => 'Утро🌄'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'День🏙',
                        'Text' => 'День🏙'
                    ], [
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'Вечер🌇',
                        'Text' => 'Вечер🌇'
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

    private function getFreeRecords()
    {
        $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'selecting_rec_time']);
        $google = new GoogleClient();
        $data = $this->db->table('recordList')->where('id', $this->userData['recordId'])->select()->results();
        if ($data[0]['how_long_type'] === '0') {
            $this->db->table('recordList')->where('id', $this->userData['recordId'])->update(['start_search_date' => date('c', strtotime($data[0]['start_search_date'] . ' + 31 days'))]);
        }
        $data = $this->db->table('recordList')->where('id', $this->userData['recordId'])->select()->results();
        $list = $google->getRecords($data[0]['start_search_date'], date('c', strtotime($data[0]['start_search_date'] . ' + 21 days')), $data);

        if (!$list) {
            $this->db->table('recordList')->where('id', $this->userData['recordId'])->where('edit', 1)->update(['selected_time' => 4]);
            $list = $google->getRecords($data[0]['start_search_date'], date('c', strtotime($data[0]['start_search_date'] . ' + 21 days')), $data);
        }

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
            'ActionBody' => 'main_menu',
            'Text' => $this->text['cancel']
        ];

        $this->viber->sendMessageWithKeyboard($this->text['free_time'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => $buttonList
        ]);
    }

    private
    function getProcedureTitle($data)
    {
        $procedureTitle = '';
        if ($data['procedure_id'] === '0' || $data['procedure_id']) {
            foreach ($this->text['few_services'] as $service) {
                if ($service['id'] == $data['procedure_id']) {
                    $procedureTitle = mb_strtolower($service['no_title']) . ', ';
                }
            }
        } else {
            $proceduresIdList = $this->db->table('recordListProcedures')->where('recordId', $data['id'])->select()->results();
            foreach ($this->text['few_services'] as $key => $item) {
                foreach ($proceduresIdList as $procedureId) {
                    if ($item['id'] == $procedureId['procedureId']) {
                        $procedureTitle .= mb_strtolower($this->text['few_services'][$key]['no_title']) . ', ';
                    }
                }
            }
        }
        return $procedureTitle;
    }

}