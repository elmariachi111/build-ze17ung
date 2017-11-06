<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConferenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class)
            ->add('starts', DateTimeType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'rel' => 'datetimepicker'
                ]
            ])
            ->add('ends', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'rel' => 'datetimepicker'
                ]
            ])
            ->add('url', UrlType::class, [
                'required' => false,
            ])
            ->add('venueName', TextType::class, [
                'required' => false
            ])
            ->add('venueAddress', TextType::class, [
                'required' => false
            ])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn-black btn btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Conference'
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
