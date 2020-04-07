<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
       
        $query = $em->createQuery ('SELECT prestation, service, client FROM App\Entity\Prestation prestation JOIN prestation.service service JOIN prestation.client client ORDER BY prestation.datePrestation DESC');
        $prestation = $query->getResult();

        $vars= ['prestations'=>$prestation];
        return $this->render("prestation/prestation_afficher.html.twig", $vars);
    }

    /**
     * @Route("/prestation/delete", name="traitementPrestation_deleteEdit")
     */
    public function prestationDelete(Request $request)
    {
        $valButtonEdit = $request->request->get('edit');
        $valButtonDelete = $request->request->get('delete');

        $id =$valButtonDelete | $valButtonEdit;

        $em = $this->getDoctrine()->getManager();
        $prestation = $em->getRepository(Prestation::class)->findOneBy(array("id"=>$id));

        if($valButtonDelete != null){
            $em->remove($prestation);
            $em->flush();
            return $this->redirectToRoute("prestation_afficher");
        }
        else{
            $vars=['prestation'=>$prestation];
            return $this->render("prestation/prestation_edit.html.twig", $vars);
        }
    }

    /**
     * @Route("/prestation/edit", name="traitement_editPrestation")
     */
    public function prestationEdit(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $prestation = $em->getRepository(Prestation::class)->findOneBy(array("id"=>$id));
        // $prestation->setDatePrestation($request->request->get('datePrestation'));
        $prestation->setCarteBancaire($request->request->get('carteBancaire'));
        $prestation->setPrixService($request->request->get('prixService'));
        $em->flush();
        return $this->redirectToRoute("prestation_afficher");

    }

    /**
     * @Route("/prestation/rechercher")
     */
    public function rechercherPrestation()
    {
        
        return $this->render("prestation/prestation_rechercher.html.twig");

    }


    /**
     * @Route("/prestation/rechercher/traitement", name="prestation_rechercherTraitement")
     */
    public function rechercherPrestationTraitement(Request $request)
    {
        $dateDebut = $request->request->get('dateDebut');
        $dateFin = $request->request->get('dateFin');

        $em = $this->getDoctrine()->getManager();
       
        $query = $em->createQuery ('SELECT prestation, service, client FROM App\Entity\Prestation prestation  JOIN prestation.service service JOIN prestation.client client WHERE prestation.datePrestation >= :dateDebut AND prestation.datePrestation <= :dateFin ORDER BY prestation.datePrestation DESC');
        $query->setParameter('dateDebut', $dateDebut);
        $query->setParameter('dateFin', $dateFin);
        $prestation = $query->getResult();

        $prixTotal = 0;
        //je calcule le total pour la periode recherché
        foreach($prestation as $value ){
            $prixTotal += $value->getPrixService();
        }

        $vars=['prestation'=>$prestation];
        $vars['prix']=$prixTotal;

        return $this->render("prestation/prestation_rechercher_traitement.html.twig", $vars);

    }

    /**
     * @Route("/prestation/recherche/ajax")
     */
    public function prestationRechercheAjax()
    {
        return $this->render("/prestation/prestation_recherche_ajax.html.twig");

    }

    /**
     * @Route("/prestation/recherche/traitement/ajax", name="rechercheTraitementAjax")
     */
    public function rechercheTraitementAjax(Request $request)
    {
        $dateDebut = $request->request->get('dateDebut');
        $dateFin = $request->request->get('dateFin');
        
        $em = $this->getDoctrine()->getManager();
       
        $query = $em->createQuery ('SELECT prestation, service, client FROM App\Entity\Prestation prestation  JOIN prestation.service service JOIN prestation.client client WHERE prestation.datePrestation >= :dateDebut AND prestation.datePrestation <= :dateFin ORDER BY prestation.datePrestation DESC');
        $query->setParameter('dateDebut', $dateDebut);
        $query->setParameter('dateFin', $dateFin);

        $prestations = $query->getArrayResult();
       
        return new JsonResponse($prestations);
    }
}
