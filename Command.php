<?php
// Command.php

class Command {
    public function list(): void {
        $manager = new ContactManager((new DBConnect())->getPDO());
        $contacts = $manager->findAll();

        foreach ($contacts as $contact) {
            echo $contact->__toString() . "\n";
        }
    }
}
