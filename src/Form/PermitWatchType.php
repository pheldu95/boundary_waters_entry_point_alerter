<?php

namespace App\Form;

use App\Entity\PermitWatch;
use App\Entity\EntryPoint;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermitWatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entryPoint', EntityType::class, [
                'class' => EntryPoint::class,
                'choice_label' => function(EntryPoint $entryPoint) {
                    return $entryPoint->getNumber() . ' - ' . $entryPoint->getName();
                },
                'placeholder' => 'Choose an Entry Point',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white'
                ],
                'label' => 'Entry Point',
                'label_attr' => [
                    'class' => 'block mb-2 text-sm font-medium text-white'
                ]
            ])
            ->add('targetDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white'
                ],
                'label' => 'Select a date',
                'label_attr' => [
                    'class' => 'block mb-2 text-sm font-medium text-white'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'w-full text-gray-900 bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PermitWatch::class,
        ]);
    }
}