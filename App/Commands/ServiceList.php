<?php

namespace App\Commands;

use App\Commands\ServiceList\AestheticDentistry;
use App\Commands\ServiceList\DentalTreatment;
use App\Commands\ServiceList\Hygiene;
use App\Commands\ServiceList\Prosthesis;
use App\Commands\ServiceList\TeethAlignment;

class ServiceList extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->userData['mode'] == 'service_list') {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'done']);
            switch ($this->viberParser::getMessage()) {
                //Лечение зубов
                case '0':
                    $this->triggerCommand(DentalTreatment::class);
                    break;
                //Выравнивание
                case '1':
                    $this->triggerCommand(TeethAlignment::class);
                    break;
                //Эстетическая стоматология
                case '2':
                    $this->triggerCommand(AestheticDentistry::class);
                    break;
                //Гигиена
                case '3':
                    $this->triggerCommand(Hygiene::class);
                    break;
                //Протезирование
                case '4':
                    $this->triggerCommand(Prosthesis::class);
                    break;
            }
            exit;
        } else {
            $this->db->table('userList')->where('viberChatId', $this->chatId)->update(['mode' => 'service_list']);
            $buttonList = [];
            foreach ($this->text['service_list_actions'] as $item) {
                $buttonList[] = [
                    "Columns" => $item['id'] == 4 ? 6 : 3,
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
                'Text' => $this->text['main_menu']
            ];

            $this->viber->sendMessageWithKeyboard($this->text['see_more'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => $buttonList
            ]);
        }
    }

}