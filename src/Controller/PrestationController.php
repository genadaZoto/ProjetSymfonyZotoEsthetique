<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrestationController extends AbstractController
{
    /**
     * @Route("/prestation/insert", name="prestation_insert")
     */
    public function prestationInsert(Request $request)
    {
        $prestation = new Prestation();

        $formulairePrestation = $this->createForm(
            PrestationType::class,
            $prestation,[
                'method'=>"POST",
                'action'=>$this->generateUrl("prestation_insert")
                ]
            );

            $formulairePrestation->handleRequest($request);

            if($formulairePrestation->isSubmitted() && $formulairePrestation->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($prestation);
                $em->flush();

                return $this->redirectToRoute("prestation_afficher");
            }
            else{
                return $this->render('prestation/prestation_insert.html.twig',['formulaire'=>$formulairePrestation->createView()]);
            }
    }

    /**
     * @Route("/prestation/afficher", name="prestation_afficher")
     */
    public function prestationAfficher(){
        $em = $this->getDoctrine()->getManager();
        $prestationRepo = $em->getRepository(Prestation::class);
        $prestation = $prestationRepo->findAll();
        $vars = ['prestations'=>$prestation];

        return $this->render("prestation/prestation_afficher.html.twig", $vars);
    }
}
