<?php

namespace App\Commands;

class Address extends BaseCommand {

    function processCommand($par = false)
    {
        if ($this->viberParser::getMessage() == 'public_transport') {
            $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/pub_transport0.jpeg');
            $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/pub_transport1.jpeg');
            $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/pub_transport2.jpeg');

            $this->viber->sendMessageWithKeyboard($this->text['public_transport_about'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 6,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'car_transport',
                        'Text' => $this->text['car_transport']
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
            ]);
            exit;
        } elseif ($this->viberParser::getMessage() == 'car_transport') {
            $this->viber->sendMessageWithKeyboard($this->text['car_transport_about'], [
                'Type' => 'keyboard',
                'DefaultHeight' => true,
                'Buttons' => [
                    [
                        "Columns" => 6,
                        "Rows" => 2,
                        'ActionType' => 'reply',
                        'BgColor' => '#D1EDF2',
                        "TextOpacity" => 60, "TextSize" => "large",
                        'ActionBody' => 'public_transport',
                        'Text' => $this->text['public_transport']
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
            ]);
            exit;
        }

        $this->viber->sendImage('', 'https://' . getenv('HTTP_HOST') . '/src/map.jpeg');
        $this->viber->sendMessageWithKeyboard($this->text['address'], [
            'Type' => 'keyboard',
            'DefaultHeight' => true,
            'Buttons' => [
                [
                    "Columns" => 3,
                    "Rows" => 2,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'public_transport',
                    'Text' => $this->text['public_transport']
                ], [
                    "Columns" => 3,
                    "Rows" => 2,
                    'ActionType' => 'reply',
                    'BgColor' => '#D1EDF2',
                    "TextOpacity" => 60, "TextSize" => "large",
                    'ActionBody' => 'car_transport',
                    'Text' => $this->text['car_transport']
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
        ]);
    }

}