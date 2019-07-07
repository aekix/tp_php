<?

require('Utilisateur.php');

class Meeting {
    private $debut;
    private $fin;
    private $titre;
    private $description;
    private $id;
    private $organisateurs = array();
    private $participants = array();

    public function __construct($debut, $fin, $description, $titre, $organisateur, $pdo) {
        $this->debut = $debut;
        $this->fin =$fin;
        $this->description = $description;
        $this->titre = $titre;
        $id = 0;
        $this->organisateurs = $organisateur;
        $stmt = $pdo->prepare("INSERT INTO meeting (debut, fin, titre, description) VALUES ($debut,$fin,$titre,$description)");
        $pdo->execute();
        $this->id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO  utilisateur_categorie (id_user, id_meeeting, categorie) VALUES (".$this->getId().",".$id.",organisateur)");
        $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function save(){

    }

    public function addUtilisateur($user, $categorie,$pdo) {
            $stmt = $pdo->prepare("INSERT INTO  utilisateur_categorie (id_user, id_meeeting, categorie) VALUES (".$user->getId().",".$this->getId().",".$categorie.")");
            $stmt->execute();
            $this->organisateurs = $user;
    }
}