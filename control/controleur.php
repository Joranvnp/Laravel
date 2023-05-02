<?php
class controleur {
    // use App\Models\Conference;

    //Ajouter une conférence
    // {
    //     "dateHeure": "2023-04-15 09:30:00",
    //     "nom": "Conférence sur les intelligences artificielles",
    //     "lieu": "Centre de conférences de Paris",
    //     "nbPlace": 100
    // }
    
    public function ajouterConference() {
        $donnees = json_decode(file_get_contents("php://input"));
		
        $conference = new Conference;
        $conference->dateHeure = $donnees->dateHeure;
        $conference->nom = $donnees->nom;
        $conference->lieu = $donnees->lieu;
        $conference->nbPlace = $donnees->nbPlace;
        $conference->save();
    }

    //Modifier une conférence 
    // {
    //     "id": 1,
    //     "dateHeure": "2023-04-15 11:00:00",
    //     "nom": "Conférence sur les intelligences artificielles",
    //     "nbPlace": 200
    // }

    public function modifierConference() {
        $donnees = json_decode(file_get_contents("php://input"));
        
        $conference = Conference::find($donnees->id);
        $conference->dateHeure = $donnees->dateHeure;
        $conference->nom = $donnees->nom;
        $conference->nbPlace = $donnees->nbPlace;
        $conference->save();

    }

    //Supprimer une conférence
    // {
    //     "id": 1
    // }
    
    public function supprimerConference() {
        $donnees = json_decode(file_get_contents("php://input"));
        
        Conference::find($donnees->id)->Intervenant()->detach();
        Conference::destroy($donnees->id);
    }

    //Ajouter un intervenant salarie
    // {
    //     "nom": "Dupont",
    //     "prenom": "Jean",
    //     "rue": "2 Rue des Fleurs",
    //     "cp": "75000",
    //     "ville": "Paris",
    //     "tel": "01 23 45 67 89",
    //     "mail": "jean.dupont@gmail.com",
    //     "grade": "Ingénieur",
    //     "service": "Développement",
    //     "dateEmbauche": "2022-01-01",
    // }
    
    // {
    //     "nom": "Rosoft",
    //     "prenom": "Mike",
    //     "rue": "2 Rue des Fleurs",
    //     "cp": "75000",
    //     "ville": "Paris",
    //     "tel": "01 23 45 67 89",
    //     "mail": "Mike.Rosoft@gmail.com",
    //     "dataPremierContrat": "2022-05-01",
    //     "tarifHoraire": 100
    // }
    

    public function ajouterIntervenant() {
        $donnees = json_decode(file_get_contents("php://input"));
        
        $intervenant = new Intervenant;
        $intervenant->nom = $donnees->nom;
        $intervenant->prenom = $donnees->prenom;
        $intervenant->rue = $donnees->rue;
        $intervenant->cp = $donnees->cp;
        $intervenant->ville = $donnees->ville;
        $intervenant->tel = $donnees->tel;
        $intervenant->mail = $donnees->mail;

        $intervenant->save();

        //lier table animer
        // Conference::find($donnees->id)->Intervenant()->attach($intervenant->id, ['nbHeures' => $donnees->nbHeures]);

        if(isset($donnees->grade) && isset($donnees->service) && isset($donnees->dateEmbauche)) {
            $salarie = new Salarie;
            $salarie->idInterv = $intervenant->id;
            $salarie->grade = $donnees->grade;
            $salarie->service = $donnees->service;
            $salarie->dateEmbauche = $donnees->dateEmbauche;
            $salarie->save();
        }
        
        if(isset($donnees->dataPremierContrat) && isset($donnees->tarifHoraire)) {
            $prestataire = new Prestataire;
            $prestataire->idInterv = $intervenant->id;
            $prestataire->dataPremierContrat = $donnees->dataPremierContrat;
            $prestataire->tarifHoraire = $donnees->tarifHoraire;
            $prestataire->save();
        }
    }

    //Modifier un intervenant
    // {
    //     "id": 1,
    //     "nom": "Dupont",
    //     "prenom": "Jean",
    //     "rue": "2 Rue des Fleurs",
    //     "cp": "75000",
    //     "ville": "Paris",
    //     "tel": "01 23 45 67 89",
    //     "mail": "jean.dupont@gmail.com",
    //     "dataPremierContrat": "2022-05-01",
    //     "tarifHoraire": 45
    // }
    
    // {
    //     "id": 1,
    //     "nom": "Dupont",
    //     "prenom": "Jean",
    //     "rue": "2 Rue des Fleurs",
    //     "cp": "75000",
    //     "ville": "Paris",
    //     "tel": "01 23 45 67 89",
    //     "mail": "jean.dupont@gmail.com",
    //     "grade": "Ingénieur",
    //     "service": "Développement",
    //     "dateEmbauche": "2022-01-01",
    // }
    

    //Modifier les données relatives à un intervenant existant
    public function modifierIntervenant() {
        $donnees = json_decode(file_get_contents("php://input"));
        
        $intervenant = Intervenant::find($donnees->id);
        $intervenant->nom = $donnees->nom;
        $intervenant->prenom = $donnees->prenom;
        $intervenant->rue = $donnees->rue;
        $intervenant->cp = $donnees->cp;
        $intervenant->ville = $donnees->ville;
        $intervenant->tel = $donnees->tel;
        $intervenant->mail = $donnees->mail;
        $intervenant->save();

        if(isset($donnees->grade) && isset($donnees->service) && isset($donnees->dateEmbauche)) {
            $salarie = Salarie::find($donnees->id);
            $salarie->grade = $donnees->grade;
            $salarie->service = $donnees->service;
            $salarie->dateEmbauche = $donnees->dateEmbauche;
            $salarie->save();
        }
        
        if(isset($donnees->dataPremierContrat) && isset($donnees->tarifHoraire)) {
            $prestataire = Prestataire::find($donnees->id);
            $prestataire->dataPremierContrat = $donnees->dataPremierContrat;
            $prestataire->tarifHoraire = $donnees->tarifHoraire;
            $prestataire->save();
        }

        //Lier table animer a l'ajout dune conference
         // Conference::find($donnees->id)->Intervenant()->attach($intervenant->id, ['nbHeures' => $donnees->nbHeures]);

    }

    //Modifier la liste d'intervenants d'une conférence
    // {
    //     "id": 1,
    //     "listeIntervenant": [
    //         {
    //             "id": 1,
    //             "nbHeures": 5
    //         }
    //     ]
    // }
    
    

    public function modifierListeIntervenant() {
        $donnees = json_decode(file_get_contents("php://input"));

        $conference  = Conference::find($donnees->id);

        if ($conference) {

            $conference->Intervenant()->detach();

            foreach($donnees->listeIntervenant as $intervenant) {
                if(is_numeric($intervenant->nbHeures)) {
                    Conference::find($donnees->id)->Intervenant()->attach($intervenant->id, ['nbHeures' => $intervenant->nbHeures]);
                }
            }
        } else {
            (new vue)->erreur404();
        }
    }
    
    
    public function supprimerIntervenant() {
        $donnees = json_decode(file_get_contents("php://input"));

        Intervenant::find($donnees->id)->Conference()->detach();

        Salarie::destroy($donnees->id);
        Prestataire::destroy($donnees->id);

        Intervenant::destroy($donnees->id);
    }


    public function listeIntervenant() {

        if(isset($_GET['id'])) {
            $intervenant = Intervenant::find($_GET['id']);
        } else {
            $intervenant = Intervenant::all();
        }

        (new vue)->transformerJson($intervenant);
    }

    public function listeConference() {

        if(isset($_GET['date'])) {
            $conferences = Conference::select('Conference.nom', 'Conference.dateHeure', 'nbPlace', 'Intervenant.prenom', 'nbHeures')
                ->join('Animer', 'Animer.idConf', '=', 'Conference.id')
                ->join('Intervenant', 'Intervenant.id', '=', 'Animer.idInterv')
                ->where('dateHeure', 'like', $_GET['date'].'%')
                ->get();
        } else {
            $conferences = Conference::all();
        }
    
        (new vue)->transformerJson($conferences);
    }
    
}