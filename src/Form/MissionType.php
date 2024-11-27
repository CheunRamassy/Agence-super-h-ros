<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\MissionStatus;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'empty_data' => ''
                ])
            ->add('location', CountryType::class, [
                'label' => 'Localisation',
                'placeholder' => 'Selectionner un pays',
            ])
            ->add('dangerLevel', IntegerType::class, [
                'label' => 'Niveau de danger',
            ])
            ->add('status', EnumType::class, [
                'class' => MissionStatus::class,
                'placeholder' => 'Selectionner un status',
                'label' => 'Etat'
            ])
            ->add('assignedTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'placeholder' => 'Selectionner une équipe',
                'label' => 'Associer une équipe'
            ])
            ->add('startAt', null, [
                'widget' => 'single_text',
                'label' => 'Date de début'
            ])
            ->add('endAt', null, [
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('button', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
