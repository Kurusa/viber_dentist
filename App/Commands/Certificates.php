<?php

namespace App\Commands;

class Certificates extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->viberParser::getMessage() == 'next_cert') {
            $this->viber->sendMessageWithKeyboard($this->text['next_action'], [
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
                    ],[
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'contact_us',
                        'Text' => $this->text['chat']
                    ],[
                        "Columns" => 6,
                        "Rows" => 1,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60,
                        "TextSize" => "large",
                        'ActionBody' => 'service_list',
                        'Text' => $this->text['service_list']
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
            exit();
        }
        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/cert3.jpeg');
        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/cert1.jpeg');
        $this->viber->sendMessage($this->text['good_dentist']);
        $this->viber->sendMessageWithKeyboard($this->text['more_certificates'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    "Columns" => 6,
                    "Rows" => 2,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60,
                    "TextSize" => "large",
                    'ActionBody' => 'next_cert',
                    'Text' => $this->text['next']
                ], [
                    "Columns" => 6,
                    "Rows" => 2,
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