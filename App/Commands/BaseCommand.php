<?php

namespace App\Commands;

use App\ViberHelpers\ViberApi;
use App\ViberHelpers\ViberParser;
use PHPtricks\Orm\Database;

abstract class BaseCommand {

    /**
     * @var Database
     */
    protected $db;

    /**
     * @var ViberParser
     */
    protected $viberParser;

    /**
     * @var ViberApi
     */
    protected $viber;

    protected $userData;
    protected $chatId;
    protected $text;

    private $update;

    function handle(array $update, $par = false)
    {
        $this->db = Database::connect();

        $this->update = $update;
        $this->viber = new ViberApi();
        $this->viberParser = new ViberParser($update);
        $this->viber->chatId = $this->chatId = $update['sender']['id'];

        $data = $this->db->table('userList')->where('viberChatId', $this->chatId)->select()->results();
        $this->userData = $data[0] ? $data[0] : [];
        $this->text = include(SITE_ROOT . '/App/config/lang.php');

        if ($this->userData['isBlockedByBot'] == '1') {
            if ($update['message']['text'] == $this->text['contact_us']) {
                $this->processCommand($par ? $par : '');
            }
            exit;
        }

        $this->processCommand($par ? $par : '');

    }

    function triggerCommand($class, $par = false)
    {
        (new $class())->handle($this->update, $par);
    }

    abstract function processCommand($par = false);

}