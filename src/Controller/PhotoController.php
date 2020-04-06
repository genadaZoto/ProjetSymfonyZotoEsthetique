<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PhotoController extends AbstractController
{
      
    /**
     * @Route("/photo/upload", name="photo_upload")
     */
    public function photoUpload(Request $request)
    {
        $photo = new Photo();

        $formulairePhoto = $this->createForm(
            PhotoType::class, 
            $photo,
        [
            'method'=>"POST",
            'action'=>$this->generateUrl("photo_upload")
        ]);

        $formulairePhoto->handleRequest($request);

        if ($formulairePhoto->isSubmitted() && $formulairePhoto->isValid()){
            $fichier = $photo->getLienImage();
            
            $nomFichierServeur = md5(uniqid()).".".$fichier->guessExtension();
            $fichier->move("dossierFichiers", $nomFichierServeur);
            $photo->setLienImage($nomFichierServeur);

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return new Response("fichier uploaded");

        }
        else{
            return $this->render("/photo/photo_upload.html.twig", ['formulaire'=>$formulairePhoto->createView()]);
        }
        

    }
}
