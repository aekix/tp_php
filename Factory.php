<?php

class Factory {
    private $meeting = array();
    private $utilisateurs = array();

    public function __construct(){
        $GLOBALS['factory'] = $this;
    }

    public function createMeeting($organisateur, $fin, $debut, $titre, $description, $pdo){
        $meeting = new Meeting($debut, $fin,$description, $titre, $organisateur, $pdo);
        $this->meeting = $meeting;
        return ($meeting);
    }

    public function createUtilisateur($nom, $prenom, $pdo){
        $user = new Utilisateur($nom, $prenom, $pdo);
        $this->utilisateurs = $user;
        return ($user);
    }

    public function fetchBdd($pdo) {

    }
}