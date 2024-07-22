<?php

namespace App\Form\Admin;

use App\Entity\Admin\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parentId')
            ->add('title')
            ->add('description')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Mia' => 'Mia',
                    'Kaju' => 'Kaju',
                    'Vikvik' => 'Vikvik',
                    'Limon' => 'Limon',
                ],
                'attr' => ['class' => 'form-control'],
                'placeholder' => 'Select Category', // İsteğe bağlı: boş seçeneği ekleyebilirsiniz
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
