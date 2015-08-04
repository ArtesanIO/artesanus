<?php

namespace ArtesanIO\ArtesanusBundle\Form\EventListener;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Doctrine\ORM\EntityRepository;

class UserSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
          FormEvents::PRE_SET_DATA => 'preSetData',

        );
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        if($data->getId()){
            $form
                ->add('enabled')
                ->add('name')
                ->add('email')
                ->add('username')
                ->add('groups', 'entity', array(
                    'class' => 'ArtesanusBundle:Group',
                    'property' => 'name',
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true,
                    'empty_value' => '--Seleccione un Grupo--',
                ))
                ->add('current_password', 'password', array(
                    'label' => 'form.current_password',
                    'translation_domain' => 'FOSUserBundle',
                    'mapped' => false,
                    'constraints' => new UserPassword(),
                ))
            ;
        }else{
            $form
                ->add('enabled')
                ->add('name')
                ->add('email')
                ->add('username')
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
                ->add('groups', 'entity', array(
                    'class' => 'ArtesanusBundle:Group',
                    'property' => 'name',
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true,
                    'empty_value' => '--Seleccione un Grupo--',
                ))
                ->add('current_password', 'password', array(
                    'label' => 'form.current_password',
                    'translation_domain' => 'FOSUserBundle',
                    'mapped' => false,
                    'constraints' => new UserPassword(),
                ))
            ;
        }
    }
}

?>
