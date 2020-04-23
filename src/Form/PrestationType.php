<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Service;
use App\Repository\ClientRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('datePrestation', DateType::class,[
                    'widget'=>'single_text',
                    'format'=>'yyyy-MM-dd'
                ])
                ->add('carteBancaire', ChoiceType::class,[
                    'choices'=>[
                        'Yes'=> true,
                        'No' =>false,
                    ],
                ])
                ->add('prixService', MoneyType::class)
                ->add('client', EntityType::class,[
                    'class'=> Client::class,
                    'query_builder'=> function (ClientRepository $cr){
                        return $cr->createQueryBuilder('u')->select('u');
                    },
                    'choice_label'=> function (Client $x) {
                        return $x->getPrenom(). ' '. $x->getNom() ;
                    }
                ])
                ->add('service', EntityType::class,[
                    'class'=> Service::class,
                    'query_builder'=> function (ServiceRepository $sr){
                        return $sr->createQueryBuilder('u')->select('u');
                    },
                    'choice_label'=> function ($x){
                        return ($x->getNom());
                    }
                ]);
    }
}