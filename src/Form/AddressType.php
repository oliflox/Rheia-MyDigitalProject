<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de l\'adresse',
                ],
            ])
            ->add('firstname', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])
            ->add('lastname', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('company', null, [
                'label' => false,
                'attr' => [
                    'required' => false,
                    'placeholder' => 'Nom de la société',
                ],
            ])
            ->add('adress', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse',
                ],
            ])
            ->add('postalcode', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal',
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Pays',
                    'style' => 'width: 151px;',
                ],
                'preferred_choices' => ['FR'],
            ])
            ->add('phone', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone',
                ],
            ])
            ->add('city', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                ],
            ])
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
