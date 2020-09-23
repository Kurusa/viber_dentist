<?php

namespace App\Commands;

class Contacts extends BaseCommand {

    function processCommand($par = false)
    {
        $this->triggerCommand(MainMenu::class, $this->text['about_contact_us']);
    }
}