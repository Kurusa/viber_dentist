<?php

namespace App\Commands;

class MainMenu extends BaseCommand {

    function processCommand($par = false)
    {
        $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'done', 'recordId' => 0]);
        $data = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
        if ($data[0]) {
            $this->db->query('DELETE FROM recordListProcedures WHERE recordId = ' . $data[0]['id']);
            $this->db->query('DELETE FROM recordList WHERE chatId = "' . $this->chatId . '" AND done = 0');
        }

        $this->viber->sendMessageWithKeyboard($par ? $par : $this->text['main_menu'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    "Columns" => 3,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'mapp',
                    'Text' => $this->text['mapp']
                ], [
                    "Columns" => 3,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60,
                    "TextSize" => "large",
                    'ActionBody' => 'my_records',
                    'Text' => $this->text['my_records']
                ], [
                    "Columns" => 3,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'contact_us',
                    'Text' => $this->text['contact_us']
                ], [
                    "Columns" => 3,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'profile',
                    'Text' => $this->text['profile']
                ], [
                    "Columns" => 2,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'faq',
                    'Text' => $this->text['faq']
                ], [
                    "Columns" => 2,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'how_to_drive',
                    'Text' => $this->text['how_to_drive']
                ], [
                    "Columns" => 2,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'service_list',
                    'Text' => $this->text['service_list']
                ], [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'about_doctor',
                    'Text' => $this->text['about_doctor']
                ],
            ]
        ]);
    }

}