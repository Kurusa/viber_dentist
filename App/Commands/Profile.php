<?php

namespace App\Commands;

class Profile extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->viberParser::getMessage() == 'change_fio') {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'full_name_profile']);
            $this->viber->sendMessageWithKeyboard($this->text['write_full_name'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [[
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['cancel']
                    ]]
                ]
            );
            exit;
        }
        if ($this->viberParser::getMessage() == 'change_phone_number') {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'phone_number_profile']);
            $this->viber->sendMessageWithKeyboard($this->text['write_phone_number'], [
                    'Type' => 'keyboard',
                    'DefaultHeight' => true,
                    'Buttons' => [[
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['cancel']
                    ]]
                ]
            );
            exit;
        }

        if ($this->userData['mode'] == 'full_name_profile') {
            $fio = $this->viberParser::getMessage();
            if (strlen($fio) > 5) {
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['fullName' => $fio]);
                $this->triggerCommand(MainMenu::class, $this->text['change_fio_success']);
            } else {
                $this->viber->sendMessage($this->text['wrong_full_name']);
            }
            exit;
        }
        if ($this->userData['mode'] == 'phone_number_profile') {
            $phoneNumber = $this->viberParser::getMessage();
            if (strlen($phoneNumber) > 5) {
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['phoneNumber' => $phoneNumber]);
                $this->triggerCommand(MainMenu::class, $this->text['change_phone_number_success']);
            } else {
                $this->viber->sendMessage($this->text['wrong_phone_number']);
            }
            exit;
        }

        $text = '';
        if ($this->userData['fullName']) {
            $text .= "\n" . 'Ваше ФИО: ' . $this->userData['fullName'];
        } else {
            $text .= "\n" . 'Вы пока что не указали свое ФИО.';
        }
        if ($this->userData['phoneNumber']) {
            $text .= "\n" . 'Ваш номер телефона: ' . $this->userData['phoneNumber'];
        } else {
            $text .= "\n" . 'Вы пока что не указали свой номер телефона.';
        }
        $this->viber->sendMessageWithKeyboard($this->text['here_you_can_change'] . $text, [
            [$this->text['change_fio'], $this->text['change_phone_number']],
            [$this->text['cancel']]
        ]);
        $this->viber->sendMessageWithKeyboard($this->text['here_you_can_change'] . $text, [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 3,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'change_fio',
                        'Text' => $this->text['change_fio']
                    ], [
                        "Columns" => 3,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'change_phone_number',
                        'Text' => $this->text['change_phone_number']
                    ], [
                        "Columns" => 6,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'main_menu',
                        'Text' => $this->text['main_menu']
                    ],
                ]
            ]
        );
    }

}