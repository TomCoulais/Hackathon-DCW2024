<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                    'placeholder' => 'Entrez le nom du client'
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                    'placeholder' => 'Entrez l\'email du client'
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
            ])
            ->add('entreprise', TextType::class, [
                'label' => 'Entreprise',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                    'placeholder' => 'Entrez le nom de l\'entreprise'
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}