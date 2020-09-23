<?php

namespace App\ViberHelpers;

class ViberApi {

    public $result;
    public $chatId;
    public $curl;

    public $API = 'https://chatapi.viber.com/pa/';
    public $TOKEN = '4b0ecae85a27dc12-8aae49292d764687-22ddd8db4212bd01';

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function api($method, $params)
    {
        $url = $this->API . $method;

        return $this->do($url, $params);
    }

    private function do(string $url, array $params = []): ?array
    {
        $params = json_encode($params);

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($params),
            'X-Viber-Auth-Token: ' . $this->TOKEN,
        ]);

        $this->result = json_decode(curl_exec($this->curl), TRUE);
        return $this->result;
    }

    public function sendMessage($text, $chatId = null)
    {
        $this->api('send_message', [
            'text' => $text,
            'receiver' => $chatId ? $chatId : $this->chatId,
            'type' => 'text',
            'sender' => [
                'name' => 'Dentist'
            ],
        ]);
    }

    public function sendMessageWithKeyboard($text, $keyboard, $chatId = null)
    {
        $this->api('send_message', [
            'text' => $text,
            'receiver' => $chatId ? $chatId : $this->chatId,
            'type' => 'text',
            'sender' => [
                'name' => 'Dentist'
            ],
            "keyboard" => $keyboard
        ]);
    }

    public function sendImage($text, $imageUrl, $chatId = null)
    {
        $this->api('send_message', [
            'text' => $text,
            'receiver' => $chatId ? $chatId : $this->chatId,
            'type' => 'picture',
            'sender' => [
                'name' => 'Dentist'
            ],
            "media" => $imageUrl
        ]);
    }

    public function __destruct()
    {
        $this->curl = curl_close($this->curl);
    }

}