<?php

namespace App\Form;

use App\Entity\Facture;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => Client::class, 
                'choice_label' => 'name', 
                'label' => 'Client',
                'placeholder' => 'Sélectionnez un client', 
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
            ])
            ->add('dateEnvoie', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
            ])
            ->add('statut', TextType::class, [
                'label' => 'Statut',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                    'placeholder' => 'Entrez le statut de la facture'
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
            ])
            ->add('montant', NumberType::class, [
                'label' => 'Montant',
                'attr' => [
                    'class' => 'mt-2 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-orange-500 placeholder:text-gray-500',
                    'placeholder' => 'Entrez le montant de la facture'
                ],
                'label_attr' => [
                    'class' => 'text-white text-left font-semibold mb-2'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}