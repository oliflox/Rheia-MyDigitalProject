<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', null, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Prénom',
                'required' => 'required',
            ],
        ])
        ->add('lastname', null, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Nom',
                'required' => 'required',
            ],
        ])
        ->add('email', null, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Adresse e-mail',
                'required' => 'required',
            ],
        ])
        ->add('object', null, [
            'label' => false,
            ])
        ->add('message', TextareaType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Message',
                'rows' => 8,
                'resize' => 'none',
            ],
        ])
        ->add('school', ChoiceType::class, [
            'choices' => [
                'Oui' => 'oui',
                'Non' => 'non',
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'Vous êtes personnel enseignant et souhaitez-vous inscrire au concours inter-écoles ?',
            'required' => true,
            'label_attr' => [
                'class' => 'hidden',
            ],
        ])
        ->add('envoyer', SubmitType::class, [
            'attr' => [
                'value' => 'Envoyer',
            ],
        ]);
        
        

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'theme' => 'contact_theme.html.'
            // Configure your form options here
        ]);
    }
}
