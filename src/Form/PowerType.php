<?php

namespace App\Form;

use App\Entity\Power;
use App\Entity\SuperHeros;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'empty_data' => ''
                ])
            ->add('level')
            ->add('powerHero', EntityType::class, [
                'class' => SuperHeros::class,
                'choice_label' => 'name',
                'label' => 'Héros',
                'placeholder' => 'Selectionner le héro (Optionnel)',
                'empty_data' => null,
                'required' => false,
                
            ])
            ->add('button', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Power::class,
        ]);
    }
}
