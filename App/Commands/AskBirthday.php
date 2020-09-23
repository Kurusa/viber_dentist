<?php

namespace App\Commands;

class AskBirthday extends BaseCommand {

    private $mode = 'birthday';

    function processCommand($par = false)
    {
        if ($this->userData['mode'] == $this->mode) {
            $msg = $this->viberParser::getMessage();
            if ($msg == 'enter_birthday') {
                $this->viber->sendMessageWithKeyboard($this->text['birthday_rule'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [
                        [
                            'ActionType' => 'reply',
                            'BgColor' => '#D1EDF2',
                            "TextOpacity" => 60, "TextSize" => "large",
                            'ActionBody' => 'main_menu',
                            'Text' => $this->text['skip']
                        ],
                    ]
                ]);
            } elseif (preg_match("^\\d{1,2}.\\d{2}.\\d{4}^", $msg)) {
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['birthday' => $msg]);
                $this->viber->sendMessage($this->text['thank_for_birthday']);
                $this->viber->sendMessage($this->text['about_discount']);
                $this->triggerCommand(MainMenu::class);
            }
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => $this->mode]);
            $this->viber->sendMessageWithKeyboard($this->text['ask_birthday'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'enter_birthday',
                        'Text' => $this->text['enter_birthday']
                    ], [
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['skip']
                    ],
                ]
            ]);
        }
    }
}