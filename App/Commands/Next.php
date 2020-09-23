<?php

namespace App\Commands;

class Next extends BaseCommand {

    function processCommand($par = false)
    {
        switch ($this->userData['mode']) {
            case 'birthday':
                $this->triggerCommand(MainMenu::class);
                break;
        }
    }

}