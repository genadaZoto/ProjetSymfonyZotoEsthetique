<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
                ->add('prix', MoneyType::class)
                ->add('user', EntityType::class,[
                    'class'=> User::class,
                    'query_builder'=> function (UserRepository $ur){
                        return $ur->createQueryBuilder('u')->select('u');
                    },
                    'choice_label'=> function ($x) {
                        return ($x->getNom());
                    }
                ]);
    }
}