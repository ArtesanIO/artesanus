<?php

namespace ArtesanIO\ArtesanusBundle\Form\EventListener;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GroupSubscriber implements EventSubscriberInterface
{
    protected $roles;

    public function __construct($roles)
    {
        $this->roles = $roles;
    }

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

        // if($data->getId()){
        //     echo "<pre>";print_r($this->getRoles());exit();
        //     exit('Funciona');
        // }

        $form
            ->add('name')
            //->add('roles')
            ->add('roles','choice', array(
                'choices'   => $this->getRoles(),
                'data'      => $data->getRoles(),
                'expanded'  => true,
                'multiple'  => true
            ))
        ;

    }

    public function getRoles()
    {
        $roles = [];

        foreach($this->roles->findAll() as $role){
            $roles[$role->getRoleKey()] = $role->getRole();
        }

        return $roles;
    }
}

?>
