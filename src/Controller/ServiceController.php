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
     * @Route("/service/afficher", name="service_afficher")
     */
    public function serviceAfficher(){
        $em = $this->getDoctrine()->getManager();
        $serviceRepo = $em->getRepository(Service::class);
        $services = $serviceRepo->findAll();
        $vars = ['services'=>$services];

        return $this->render("service/service_afficher.html.twig", $vars);

    }

    /**
     * @Route("/service/delete", name="traitement_deleteEdit")
     */
    public function serviceDelete(Request $request){

        $buttonEdit = $request->request->get('edit');
        $buttonDelete = $request->request->get('delete');


        if($buttonDelete != null){
            $id = substr($buttonDelete,6);
            $em = $this->getDoctrine()->getManager();
            $unService= $em->getRepository(Service::class)->findOneBy(array("id"=>$id));
            $em->remove($unService);
            $em->flush();
            return $this->redirectToRoute("service_afficher");

        }else{
            
            $id = substr($buttonEdit,4);

            $em = $this->getDoctrine()->getManager();
            $service= $em->getRepository(Service::class)->findOneBy(array("id"=>$id));
            $vars= ['service'=>$service];

            return $this->render("service/service_edit.html.twig", $vars);
     
        }
    }

    /**
     * @Route("/service/edit", name="traitement_editService")
     */
    public function serviceEdit(Request $request){

    
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $service= $em->getRepository(Service::class)->findOneBy(array("id"=>$id));
        $service->setNom($request->request->get('nom'));
        $service->setPrix($request->request->get('prix'));
        $em->flush();
        
        return $this->redirectToRoute("service_afficher");
    }
}
