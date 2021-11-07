<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idTicket',NumberType::class, array('label'=> 'Id: ',
                'attr' => array('class' => 'form-control',
                'placeholder' => '00',
                'tooltip' => 'Escribe la cédula del usuario',
                'required'   => true)))
            ->add('nombre', TextType::class, array('label'=> 'Nombre: ',
                'attr' => array('class' => 'form-control',
                    'placeholder' => 'Indique un nombre',
                    'tooltip' => 'Escriba un nombre',
                    'required' => true,
                    'maxlength' => 255)))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
