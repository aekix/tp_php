<?php

class Utilisateur
{
    private $nom;
    private $prenom;
    private $meetingOrganisateur = array();
    private $meetingParticipant = array();
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Utilisateur constructor.
     * @param $nom
     * @param $prenom
     */
    public function __construct($nom, $prenom, $pdo)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom) VALUES ($nom, $prenom)");
        $stmt->execute();
        $this->id = $pdo->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return array
     */
    public function getMeetingOrganisateur()
    {
        return $this->meetingOrganisateur;
    }

    /**
     * @return array
     */
    public function getMeetingParticipant()
    {
        return $this->meetingParticipant;
    }

    public function inscription($meeting, $categorie, $pdo)
    {
        if (!in_array($meeting, $this->meetingOrganisateur, true) && !in_array($meeting, $this->meetingParticipant, true)) {
            $meeting->addUtilisateur($this, $categorie, $pdo);
            $this->meetingParticipant = $meeting;
        }
    }

    public function OrganiseMeeting($debut, $fin, $titre, $description, $pdo)
    {
        $this->meetingOrganisateur = $GLOBALS['factory']->createMeeting($this, $debut, $fin, $titre, $description);

    }

    public function addUtilisateur($meeting, $user, $categorie, $pdo)
    {
        if (in_array($this, $meeting->organisateurs, true)) {
            if ($categorie == "organisateur") {
                if (!in_array($user, $meeting->participant, true)) {
                    $meeting->addUtilisateur($user, $categorie, $pdo);
                }
            } else if ($categorie == "participant") {
                if (!in_array($user, $meeting->organisateurs, true)) {
                    $meeting->addUtilisateur($user, $categorie, $pdo);
                }
            }
        }
    }

    public function supprimerMeeting($meeting, $pdo)
    {
        if (in_array($this, $meeting->organisateurs, true)) {
            $pdo->prepare("DELETE  FROM meeting WHERE id = " . $meeting->getId());
            unset($this->meetingOrganisateur[array_search($meeting, $this->meetingOrganisateur, true)]);
            unset($meeting);
        }
    }
}