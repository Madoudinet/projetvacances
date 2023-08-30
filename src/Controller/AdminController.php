<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeformType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion')]
    public function gestion(VehiculeRepository $repo): Response
    {
        $vehicules = $repo->findAll();
        return $this->render('admin/gestion.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }


    #[Route('/modify/{id}', name: 'app_modify')]
    #[Route('/ajout', name: 'app_ajout')]
    public function form(Request $request, EntityManagerInterface $manager, Vehicule $vehicule = null): Response
    {
        if($vehicule == null)
        {
            $vehicule = new Vehicule;
            $vehicule->setDateEnregistrement(new \DateTime);

        }
        $form = $this->createForm(VehiculeformType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($vehicule);
            $manager->flush();
            return $this->redirectToRoute('app_gestion');
        }

        return $this->render('admin/formvehicule.html.twig', [
            'form' => $form,
            'editMode' => $vehicule->getId() !== null,
        ]);
    }

    #[Route('/delete/{id}', name:'admin_delete')]
    public function delete(Vehicule $vehicule, EntityManagerInterface $manager)
    {
        $manager->remove($vehicule);
        $manager->flush();
        return $this->redirectToRoute('app_gestion');

    }

}
