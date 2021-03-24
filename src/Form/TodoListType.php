<?php

namespace App\Form;

use App\Entity\TodoList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'Task Description',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '128',
                    'required' => 'true'
                ]
            ])
            ->add('important', CheckboxType::class, [
                'label' => 'Important?',
                'required' => false,
                'attr' => [
                    'value' => '1'
                ]
            ])
            ->add('completed', CheckboxType::class, [
                'label' => 'Completed?',
                'required' => false,
                'attr' => [
                    'value' => '1'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-success submit']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TodoList::class,
        ]);
    }
}
