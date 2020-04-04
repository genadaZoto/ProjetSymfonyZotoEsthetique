<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('adresse', TextType::class)
                ->add('contact', TextType::class)
                ->add('email', TextType::class)
                ->add('idCard', TextType::class)
                ->add('commentaires', TextareaType::class);

    }

}