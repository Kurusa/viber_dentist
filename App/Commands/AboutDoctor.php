<?php

namespace App\Commands;

class AboutDoctor extends BaseCommand {

    function processCommand($par = false)
    {
        $this->viber->sendImage($this->text['doctor_name'], 'https://' . getenv('HTTP_HOST') . '/src/doctor.jpeg');

        $this->viber->sendMessageWithKeyboard($this->text['about_doctor_name'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'certificates',
                    'Text' => $this->text['certificates']
                ], [
                    "Columns" => 6,
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
                    'ActionBody' => 'mapp',
                    'Text' => $this->text['mapp']
                ], [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'contact_us',
                    'Text' => $this->text['chat']
                ], [
                    "Columns" => 6,
                    "Rows" => 1,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'main_menu',
                    'Text' => $this->text['main_menu']
                ],
            ]
        ]);
    }

}