<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Chargement de l'autoloader
require("vendor/autoload.php");
// Chargez ici vos fichiers modèles...
require('model/Conference.php');
require('model/Intervenant.php');
require('model/Prestataire.php');
require('model/Salarie.php');

require('view/vue.php');

require('control/controleur.php');

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

$capsule = new Capsule;
$connexionBDD = include 'config/database.php';
$capsule->addConnection($connexionBDD);
$capsule->setAsGlobal();
$capsule->bootEloquent();


if(isset($_GET["action"])) {
	switch($_GET["action"]) {
		case "conference":
			switch($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					(new controleur)->listeConference();
					break;
				case "POST":
					(new controleur)->ajouterConference();
					break;
				case "PUT":
                    (new controleur)->modifierConference();
					break;
				case "DELETE":
                    (new controleur)->supprimerConference();
					break;
				default:
					(new controleur)->erreur404();
					break;
			}
			break;
		case "intervenant":
			switch($_SERVER["REQUEST_METHOD"]) {
				case "GET":
                    (new controleur)->listeIntervenant();
					break;
				case "POST":
                    (new controleur)->ajouterIntervenant();
					break;
				case "PUT":
                    (new controleur)->modifierIntervenant();
					break;
				case "PATCH":
					(new controleur)->modifierListeIntervenant();
					break;
				case "DELETE":
                    (new controleur)->supprimerIntervenant();
					break;
				default:
					(new controleur)->erreur404();
					break;
				}
				break;
		default:
			(new controleur)->erreur404();
			break;
	}
}
else {
	(new controleur)->erreur404();
}