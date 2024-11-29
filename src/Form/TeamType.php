<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\SuperHeros;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'])
            ->add('leader', EntityType::class, [
                'class' => SuperHeros::class,
                'choice_label' => 'name',
                'placeholder' => 'Selectionner un héro',
            ])
            ->add('members', EntityType::class, [
                'class' => SuperHeros::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Membres',
                'placeholder' => 'Selectionner un ou plusieurs héros',
            ])
            ->add('currentMission', EntityType::class, [
                'class' => Mission::class,
                'choice_label' => 'title',
                'label' => 'Mission en cours',
                'placeholder' => 'Selectionner une mission',
                'required' => false,
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'label' => 'Date de création'
            ])
            ->add('active')
            ->add('button', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
