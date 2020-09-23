<?php

namespace App\Commands;

use App\ViberHelpers\GoogleClient;
use App\ViberHelpers\TelegramApi;
use App\ViberHelpers\TelegramKeyboard;

class CreateAppointment extends BaseCommand {

    function processCommand($par = false)
    {
        $adminText = 'Вайбер' . "\n";
        $adminText .= 'Новая запись✅' . "\n";
        $google = new GoogleClient();
        $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['exact_date' => $this->viberParser::getMessage()]);
        $data = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
        if ($data[0]['edit'] == '1') {
            $adminText = 'Вайбер' . "\n" . 'Перенос записи 🗓' . "\n";
            $google->delete($data[0]['event_id']);
        }
        $procedureTitle = '';
        $discount = false;
        if ($data[0]['procedure_id']) {
            foreach ($this->text['few_services'] as $service) {
                if ($data[0]['procedure_id'] == 3) {
                    $discount = true;
                }
                if ($service['id'] == $data[0]['procedure_id']) {
                    $procedureTitle = mb_strtolower($service['no_title']);
                    break;
                }
            }
        } else {
            $proceduresIdList = $this->db->table('recordListProcedures')->where('recordId', $data[0]['id'])->select()->results();
            foreach ($this->text['few_services'] as $key => $item) {
                foreach ($proceduresIdList as $procedureId) {
                    if ($procedureId['procedureId'] == 3) {
                        $discount = true;
                    }
                    if ($item['id'] == $procedureId['procedureId']) {
                        $procedureTitle .= mb_strtolower($this->text['few_services'][$key]['no_title']) . ', ';
                    }
                }
            }

        }
        if ($discount) {
            if (date('m-d', strtotime(date('') . '+ 14 days')) >= date('m-d', strtotime($this->userData['birthday']))) {
                $adminText = 'Новая запись по акции - 20% на чистку✅' . "\n";
                $this->db->table('recordList')->where('id', $data[0]['id'])->update(['discount' => 1]);
            }
        }
        $adminText .= 'ФИО: ' . $this->userData['fullName']
            . "\n" . 'Телефон: ' . $this->userData['phoneNumber']
            . "\n" . 'Название услуги: ' . $procedureTitle;

        TelegramKeyboard::addButton('Отменить запись', ['a' => 'admin_cancel_confirm0', 'id' => $data[0]['id']]);
        (new TelegramApi())->sendMessageWithInlineKeyboard($adminText, TelegramKeyboard::get(), 205187375);


        $newUser = false;
        $previous = $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->select()->results();
        if ($previous[0] || $this->userData['oldUser'] == '1') {
            $newUser = true;
        }
        $eventId = $google->create($this->userData['fullName'] . ' - ' . $this->userData['phoneNumber'],
            date('c', strtotime($data[0]['exact_date'])), date('c', strtotime($data[0]['exact_date'] . ' + ' . $data[0]['how_long'] . ' minutes')),
            false, $newUser);
        $this->db->table('recordList')->where('chatId', $this->chatId)->where('done', 0)->update(['done' => 1, 'edit' => 0, 'event_id' => $eventId]);
        $this->triggerCommand(MainMenu::class, 'Вы записаны на ' . $procedureTitle . ' ' . $data[0]['exact_date'] . '✅.
Если вдруг у Вас что-то поменяется или будете задерживаться, пожалуйста предупредите, так как запись очень плотная.
Хорошего дня!');
    }

}