<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    // #[Route('/app', name: 'app_app')]
    // public function index(): Response
    // {
    //     return $this->render('app/index.html.twig', [
    //         'controller_name' => 'AppController',
    //     ]);
    // }

    #[Route("/", name:"home")]
public function home()
{

 return $this->render('app/index.html.twig', [

]);
}


#[Route('/app/vehicules', name: 'app_vehicules')]
public function vehicules(VehiculeRepository $repo)
{
    $vehicules = $repo->findAll();
    return $this->render('app/vehicules.html.twig', [
        'vehicules' => $vehicules,
    ]);
}
#[Route('/app/show/{id}', name: 'app_show')]
public function show(VehiculeRepository $repo, $id)
{
    $vehicule = $repo->find($id);
    // Il faut set le prix total à la main: prixVoiture * difference heureDépart et heureFin
    // Il faut set la date d'enregistrement
    // Il faut set le vehicule ($vehicule)
    // Il faut set le user connecté grâce à $this->getUser()
    return $this->render('app/show.html.twig', [
        'vehicule'=> $vehicule,
 
    ]);
}



}
