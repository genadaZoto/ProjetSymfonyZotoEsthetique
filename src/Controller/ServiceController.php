<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service/insert", name="service_insert")
     */
    public function serviceInsert(Request $request)
    {
       $service = new Service();

       $formulaireService = $this->createForm(
           ServiceType::class,
           $service,[
               'method'=> "POST",
               'action'=> $this->generateUrl("service_insert")
           ]
        );

        $formulaireService ->handleRequest($request);

        if($formulaireService->isSubmitted() && $formulaireService->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->render('service/service_insert_traitement.html.twig');

        }
        else{
            return $this->render('service/service_insert.html.twig', ['formulaire'=>$formulaireService->createView()]);
        }


    }

    /**
     * @Route("/service/afficher")
     */
    public function serviceAfficher(){
        $em = $this->getDoctrine()->getManager();
        $serviceRepo = $em->getRepository(Service::class);
        $services = $serviceRepo->findAll();
        $vars = ['services'=>$services];

        return $this->render("service/service_afficher.html.twig", $vars);

    }
}
