<?php

namespace App\Form;

use App\Entity\Power;
use App\Entity\SuperHeros;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('imageName', FileType::class, [
                'mapped' => false,
                'label' => 'Image',
                'constraints' => [
                    new Image()
                ]
            ])
            ->add('alterEgo', TextType::class, [
                'label' => 'Identité'
            ])
            ->add('powerHero', EntityType::class, [
                'class' => Power::class,
                'choice_label' => 'name',
                'label' => 'Pouvoir',
                'placeholder' => 'Selectionner un pouvoir',
            ])
            ->add('available')
            ->add('energyLevel', IntegerType::class, [
                'label' => "Niveau d'énergie"
            ])
            ->add('biography',TextType::class, [
                'label' => 'Biographie'
            ])

            ->add('createdAt', null, [
                'widget' => 'single_text',
                'label' => 'Date de création'
            ])
            // ->add('teamsMembers', EntityType::class, [
            //     'class' => Team::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            ->add('button', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperHeros::class,
        ]);
    }
}
