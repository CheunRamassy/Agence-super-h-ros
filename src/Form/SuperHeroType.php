<?php

namespace App\Form;

use App\Entity\SuperHeros;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name'
            ])
            ->add('alterEgo', TextType::class)
            ->add('available')
            ->add('energyLevel')
            ->add('biography',TextType::class)
            ->add('imageName')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            // ->add('teamsMembers', EntityType::class, [
            //     'class' => Team::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            ->add('button', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperHeros::class,
        ]);
    }
}
