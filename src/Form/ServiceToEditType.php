<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ServiceToEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class)
                ->add('prix', MoneyType::class)
                ->add('edit', SubmitType::class,['label' =>'Edit'])
                ->add('delete', SubmitType::class, ['label' => 'Delete'])
                ->add('saveAndAdd', SubmitType::class, ['label' =>'Save and Add']);
                
    }

}