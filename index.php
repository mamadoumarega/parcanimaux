<?php
session_start();
    //http:localhost/...
    //https:monsite.com/...
    define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http").
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

    require_once "controllers/front/API.controller.php";
    require_once "controllers/back/admin.controller.php";
    require_once "controllers/back/familles.controller.php";
    require_once "controllers/back/animaux.controller.php";

    $apiController = new APIController();
    $adminController = new AdminController();
    $famillesController = new FamillesController();
    $animauxController = new AnimauxController();

    try {
        if(empty($_GET['page']))
        {
            throw new Exception("La page demandée n'existe pas !!!");
        }else{
            // $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
            $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
            if( empty($url[0]) || empty($url[1])) throw new Exception("La page n'existe pas !!!");

            switch ($url[0]) {
                case "front":
                    switch($url[1]){
                        case "animaux": 
                            if (!isset($url[2]) || !isset($url[3])) {
                                $apiController->getAnimaux(-1,-1);
                            }else{
                                $apiController->getAnimaux((int)$url[2],(int)$url[3]);
                            }
                        break;
                        case "animal":
                            if(empty($url[2])) throw new Exception("L'identifiant de l'animal est manquant");  
                            $apiController->getAnimal($url[2]);
                        break;
                        case "continents": $apiController->getContinents();
                        break;
                        case "familles": $apiController->getFamilles();
                        break;
                        case "sendMessage": $apiController->sendMessage();
                        break;
                        default: throw new Exception("La page demandée n'existe pas ");
                    }

                break;
                
                case "back":
                    switch($url[1]){
                        case "login" :  $adminController->getPageLogin();
                        break;
                        case "connexion" :  $adminController->getConnexion();
                        break;
                        case "deconnexion" :  $adminController->getDeconnexion();
                        break;
                        case "admin" :  $adminController->getAcceuilAdmin();
                        break;
                        case "familles" : 
                            switch($url[2])
                            {
                                case 'visualisation': $famillesController->visualisation();
                                break;
                                case 'validationSuppression':  $famillesController->suppression();
                                break;
                                case 'validationModification':  $famillesController->modification();
                                break;
                                case 'creation':   $famillesController->creationTemplate() ;
                                break;
                                case 'creationValidation':   $famillesController->creationValidation() ;
                                break;
                                
                                default: throw new Exception("La page demandée n'existe pas ");
                            }
                        break;
                        case "animaux" : 
                            switch($url[2])
                            {
                                case 'visualisation': $animauxController->visualisation();
                                break;    
                                default: throw new Exception("La page demandée n'existe pas ");
                            }
                        break;
                        default: throw new Exception("La page demandée n'existe pas ");
                    }
                break;
                
                default: throw new Exception("La page demandée n'existe pas ");
               
            }
            
        }
    } catch (Exception $e) {
        $msg = $e->getMessage();
        echo $msg;
        echo "<a href='".URL."back/login'>login</a>";
    }