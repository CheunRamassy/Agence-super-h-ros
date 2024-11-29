<?php

namespace App\Form;

use App\Entity\Power;
use App\Entity\SuperHeros;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('imageNameFile', VichFileType::class, [
                'label' => false,
                'download_uri' => false,
                'delete_label' => "Remplacer l'image actuel",
                'required' => false,
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
            ->add('available', CheckboxType::class, [
                'label' => "Disponible",
                'required' => false,
            ])
            ->add('energyLevel', IntegerType::class, [
                'label' => "Niveau d'énergie"
            ])
            ->add('biography',TextareaType::class, [
                'label' => 'Biographie',
                'empty_data' => ''
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
