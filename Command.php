<?php

    class Command {
        public function list(): void {
            $manager = new ContactManager((new DBConnect())->getPDO());
            $contacts = $manager->findAll();
    //affiche les contact
        foreach ($contacts as $contact) {
            echo $contact . "\n";
        }
    }
    //affiche un contact précis par son ID
        public function detail(int $id): void {
            $manager = new ContactManager((new DBConnect())->getPDO());
            $contact = $manager->findById($id);

            if ($contact) {
                echo $contact . "\n";
            } else {
                echo "Aucun contact trouvé avec l'id $id\n";
            }
        }
    // Commande CREATE : crée un nouveau contact
        public function create(string $name, string $email, string $phone): void {
            $manager = new ContactManager((new DBConnect())->getPDO());
            $manager->create($name, $email, $phone);
            echo "Contact créé avec succès !\n";
        }
      // Commande DELETE : supprime un contact par son ID        
        public function delete(int $id): void {
            $manager = new ContactManager((new DBConnect())->getPDO());
            $manager->delete($id);
            echo "Contact avec id $id supprimé.\n";
        }
}
