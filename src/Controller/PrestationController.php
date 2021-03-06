<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// Include PhpSpreadsheet required namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
            $prestation,
            [
                'method' => "POST",
                'action' => $this->generateUrl("prestation_insert")
            ]
        );

        $formulairePrestation->handleRequest($request);

        if ($formulairePrestation->isSubmitted() && $formulairePrestation->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prestation);
            $em->flush();

            return $this->redirectToRoute("prestation_afficher");
        } else {
            return $this->render('prestation/prestation_insert.html.twig', ['formulaire' => $formulairePrestation->createView()]);
        }
    }

    /**
     * @Route("/prestation/afficher", name="prestation_afficher")
     */
    public function prestationAfficher(PaginatorInterface $paginator, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery ('SELECT prestation, service, client FROM App\Entity\Prestation prestation JOIN prestation.service service JOIN prestation.client client ORDER BY prestation.datePrestation DESC');
        $prestation = $query->getResult();
        $numeroPage = $request->query->getInt('page', 1);

        $paginationPrestation = $paginator->paginate(
            $prestation,
            $numeroPage,
            12
        );
        return $this->render('prestation/prestation_afficher.html.twig', ['prestations' => $paginationPrestation]);

    }

    /**
     * @Route("/prestation/delete", name="traitementPrestation_deleteEdit")
     */
    public function prestationDelete(Request $request)
    {
      
        $valButtonDelete = $request->request->get('delete');
        dd($valButtonDelete);
        $em = $this->getDoctrine()->getManager();
        $prestation = $em->getRepository(Prestation::class)->findOneBy(array("id" => $valButtonDelete));
        $em->remove($prestation);
        $em->flush();

        return $this->redirectToRoute("prestation_afficher");
        
    }


    ////////////////la methode pour afficher la recherche des prestations sans ajax, remplacé par la methode ajax////////////////////////
    // /**
    //  * @Route("/prestation/rechercher")
    //  */
    // public function rechercherPrestation()
    // {

    //     return $this->render("prestation/prestation_rechercher.html.twig");

    // }

    // ////////la methode pour traiter la recherche des prestations sans ajax, ca marche mais j'ai remplacer par ajax/////////////////
    // /**
    //  * @Route("/prestation/rechercher/traitement", name="prestation_rechercherTraitement")
    //  */
    // public function rechercherPrestationTraitement(Request $request)
    // {
    //     $dateDebut = $request->request->get('dateDebut');
    //     $dateFin = $request->request->get('dateFin');

    //     $em = $this->getDoctrine()->getManager();

    //     $query = $em->createQuery ('SELECT prestation, service, client FROM App\Entity\Prestation prestation  JOIN prestation.service service JOIN prestation.client client WHERE prestation.datePrestation >= :dateDebut AND prestation.datePrestation <= :dateFin ORDER BY prestation.datePrestation DESC');
    //     $query->setParameter('dateDebut', $dateDebut);
    //     $query->setParameter('dateFin', $dateFin);
    //     $prestation = $query->getResult();

    //     $prixTotal = 0;
    //     //je calcule le total pour la periode recherché
    //     foreach($prestation as $value ){
    //         $prixTotal += $value->getPrixService();
    //     }

    //     $vars=['prestation'=>$prestation];
    //     $vars['prix']=$prixTotal;

    //     return $this->render("prestation/prestation_rechercher_traitement.html.twig", $vars);

    // }

    /**
     * @Route("/prestation/recherche/ajax")
     */
    public function prestationRechercheAjax()
    {
        return $this->render("/prestation/prestation_recherche_ajax.html.twig");
    }

    /**
     * @Route("/prestation/recherche/traitement/ajax", options={"expose"=true},name="rechercheTraitementAjax")
     */
    public function rechercheTraitementAjax(Request $request)
    {
        $dateDebut = $request->request->get('dateDebut');
        $dateFin = $request->request->get('dateFin');

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT prestation, service, client FROM App\Entity\Prestation prestation  JOIN prestation.service service JOIN prestation.client client WHERE prestation.datePrestation >= :dateDebut AND prestation.datePrestation <= :dateFin ORDER BY prestation.datePrestation DESC');
        $query->setParameter('dateDebut', $dateDebut);
        $query->setParameter('dateFin', $dateFin);

        $prestations = $query->getArrayResult();
        return new JsonResponse($prestations);
    }

    ///////////////////////create xl file//////////////
    /**
     * @Route("/prestation/xlFile")
     */
    public function xlFile(Request $request)
    {
        ////je récupere les données de la DB
        $dateDebut = $request->request->get("dateDebut");
        $dateFin = $request->request->get('dateFin');

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT prestation, service, client FROM App\Entity\Prestation prestation  JOIN prestation.service service JOIN prestation.client client WHERE prestation.datePrestation >= :dateDebut AND prestation.datePrestation <= :dateFin ORDER BY prestation.datePrestation DESC');
        $query->setParameter('dateDebut', $dateDebut);
        $query->setParameter('dateFin', $dateFin);
        $prestations = $query->getResult();
        //dd($prestations);


        //spredsheet

        $spreadsheet = new Spreadsheet();

        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle($dateDebut."_".$dateFin);

        $sheet->setCellValue('A1', 'Date Service');
        $sheet->setCellValue('B1', 'Nom Service');
        $sheet->setCellValue('C1', 'Nom Client');
        $sheet->setCellValue('D1', 'Carte Bancaire');
        $sheet->setCellValue('E1', 'Prix Service');
        $sheet->setCellValue('F1', 'Total');

        $prixTotal = 0;
        //je calcule le total pour la periode recherché
        foreach ($prestations as $value) {
            $prixTotal += $value->getPrixService();
        }
        $sheet->setCellValue('F2', $prixTotal . ' €');


        $counter = 2;
        foreach ($prestations as $value) {
            $sheet->setCellValue('A' . $counter, date_format($value->getDatePrestation(), 'Y-m-d'));
            $sheet->setCellValue('B' . $counter, ucfirst($value->getService()->getNom()));
            $sheet->setCellValue('C' . $counter, ucfirst($value->getClient()->getPrenom()));
            $sheet->setCellValue('D' . $counter, ($value->getCarteBancaire()) === true ? "Oui" : "Non");
            $sheet->setCellValue('E' . $counter, $value->getPrixService() . ' €');
            $counter++;
        }

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'my_first_excel_symfony4.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    //////////////////////////////////afficher graphe///////////////////////////////////////////
     /**
     * @Route("/prestation/graphe")
     */
    public function afficherGraphe()
    {

        return $this->render('prestation/afficher_graphe.html.twig');
    }


    /**
     * @Route("/prestation/grapheTraitement", options={"expose"=true}, name="afficher_graphe")
     */
    public function afficherGrapheTraitement(Request $request)
    {
    
        $year = $request->request->get('year');

        // creer un array des services
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT service.id, service.nom FROM App\Entity\Service service");
        $resultat = $query->getResult();

        $dateDebut = $year.'-01-01';
        $dateFin = $year.'-12-31';

        // creer l'array avec le montant de chaque service pour un an.
        $montant = [];
        foreach($resultat as $value){
            $query1 = $em->createQuery("SELECT SUM(prestation.prixService) FROM App\Entity\Prestation prestation JOIN prestation.service service WHERE service.id = :idService AND prestation.datePrestation BETWEEN :dateDebut AND :dateFin ");
            $query1->setParameter('dateDebut', $dateDebut);
            $query1->setParameter('dateFin', $dateFin);
            $query1->setParameter('idService', $value['id']);
            $resultat1 = $query1->getArrayResult();
            $montant[$value['nom']] = $resultat1[0][1];
        }
       
        
        // creer l'array avec le nombre de prestations pendant chaque mois d'un an.
        
        $query2 = $em->createQuery("SELECT MONTH(prestation.datePrestation) as mois, COUNT(prestation) as nombres FROM App\Entity\Prestation prestation  WHERE YEAR(prestation.datePrestation) = :year GROUP BY mois");
        $query2->setParameter('year', $year);
        $resultat2 = $query2->getArrayResult();
        $parMois = $resultat2;

        $vars['parMois'] = $parMois;
        $vars['montant'] = $montant;
           
        return new JsonResponse($vars);
    }


}
