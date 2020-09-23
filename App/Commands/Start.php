<?php

namespace App\Commands;

class Start extends BaseCommand {

    private $mode = 'start';

    function processCommand($par = false)
    {
        if (empty($this->userData)) {
            $this->db->table('userList')->insert(['viberChatId' => $this->chatId, 'userName' => $this->viberParser::getUserName(), 'mode' => $this->mode]);
            $this->viber->sendMessageWithKeyboard($this->text['hello'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [[
                    "Columns" => 6,
                    "Rows" => 2,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'start',
                    'Text' => $this->text['click_here']
                ]]
            ]);
        } else {
            $this->triggerCommand(MainMenu::class);
        }
    }
}

