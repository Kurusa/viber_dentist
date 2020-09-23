<?php

namespace App\Commands;

class AskPhonenumber extends BaseCommand {

    private $mode = 'phonenumber';

    function processCommand($par = false)
    {
        if ($this->userData['mode'] == $this->mode) {
            $msg = $this->viberParser::getMessage();
            $data = $this->db->table('userList')->where('phoneNumber', $msg)->select()->results();
            if (!empty($data[0])) {
                $this->db->query('DELETE FROM userList WHERE viberChatId = "' . $this->chatId . '"');
                $this->db->table('userList')->where('phoneNumber', $msg)->update(['viberChatId' => $this->chatId]);
                $this->triggerCommand(MainMenu::class);
            } else {
                $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['phoneNumber' => $msg]);
                $this->triggerCommand(AskBirthday::class);
            }
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => $this->mode]);
            $this->viber->sendMessage($this->text['write_phone_number']);
        }
    }
}