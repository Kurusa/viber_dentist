<?php

namespace App\Commands\ServiceList;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\TgHelpers\TelegramKeyboard;

class Hygiene extends BaseCommand {

    function processCommand($par = false)
    {
        switch ($this->viberParser::getMessage()) {
            case '3':
                //Send action list
                $this->viber->sendMessageWithKeyboard($this->text['service_list_3'], [
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
                            'ActionBody' => 'get_notification',
                            'Text' => $this->text['get_notification']
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
            case 'get_notification':
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['notification' => 1]);
                $this->triggerCommand(MainMenu::class, $this->text['ready_notification']);
                break;
        }
    }

}