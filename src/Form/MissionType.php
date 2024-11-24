<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'titre'])
            ->add('description', TextType::class, [
                'label' => 'Description'])
            ->add('location')
            ->add('dangerLevel')
            ->add('status')
            ->add('assignedTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
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
