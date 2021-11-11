<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
                'tooltip' => 'Escribe un número',
                'required'   => true)))
            ->add('nombre', TextType::class, array('label'=> 'Nombre: ',
                'attr' => array('class' => 'form-control',
                    'placeholder' => 'Indique un nombre',
                    'tooltip' => 'Escriba un nombre',
                    'required' => true,
                    'maxlength' => 255)))
            ->add('save', SubmitType::class, array('label' => 'Guardar',
                'attr'=>array('class' => 'btn btn-success btn-lg',
                'id' => 'botonGuardar')))
            ->add('reset', ResetType::class, array('label' => 'Cancelar',
                'attr'=>array('class' => 'btn btn-danger btn-lg',
                    'id' => 'botonCancelar')))
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
