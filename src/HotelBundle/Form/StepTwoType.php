<?php

namespace HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CoreBundle\Entity\Client;

class StepTwoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('name', TextType::class, array(
                'label' => 'Imie',
                'required' => true,
                'attr' => array('placeholder' => 'Imie', 'class' => 'form-control'),
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Nazwisko',
                'required' => true,
                'attr' => array('placeholder' => 'Nazwisko', 'class' => 'form-control'),
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'required' => true,
                'attr' => array('placeholder' => 'Email', 'class' => 'form-control'),
            ))
            ->add('roomId', HiddenType::class, array(
                'required' => true,
                'mapped' => false
            ))
            ->add('arrival', HiddenType::class, array(
                'mapped' => false,
                'required' => true
            ))
            ->add('departure', HiddenType::class, array(
                'mapped' => false,
                'required' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Zarezerwuj',
                'attr' => array('class' => 'btn btn-default')
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => Client::class
        ));
    }

    /**
     * @return string
     */
    public function getName() {

        return 'step_two';
    }
}
