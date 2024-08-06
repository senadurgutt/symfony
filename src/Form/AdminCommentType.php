<?php

namespace App\Form;

use App\Entity\AdminComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class AdminCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('author', TextType::class, ['label' => 'Yorum Yapan'])
//            ->add('text', TextareaType::class, ['label' => 'Yorum'])
//            ->add('comment')
//            ->add('userid')
//            ->add('productid')
//            ->add('created_at');

            ->add('comment', TextareaType::class, [
                'label' => 'Yorumunuz',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Yorum Gönder',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdminComment::class,
        ]);
    }
}
