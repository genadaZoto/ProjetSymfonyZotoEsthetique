<?php
namespace App\Form;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datePhoto', DateType::class,[
                    'widget'=>'single_text',
                    'format'=>'yyyy-MM-dd'
                ])
                ->add('label', TextType::class)
                ->add('lienImage', FileType::class, ['label'=>"Selectionnez la photo"])
                ->add('client', EntityType::class,[
                    'class'=> Client::class,
                    'query_builder'=> function (ClientRepository $cr){
                        return $cr->createQueryBuilder('u')->select('u');
                    },
                'choice_label'=> function (Client $c) {
                    return $c->getPrenom() . ' ' . $c->getNom();
                }
            ]);

    }

}