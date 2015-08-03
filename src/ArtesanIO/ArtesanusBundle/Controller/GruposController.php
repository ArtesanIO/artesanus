<?php

namespace ArtesanIO\ArtesanusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArtesanIO\ACLBundle\Form\Type\GroupFormType;


class GruposController extends Controller
{
    public function gruposAction()
    {
        //$grupos = $this->get('artesanio.grupos_manager')->findAll();

        $grupos = $this->get('fos_user.group_manager')->findGroups();

        return $this->render('ArtesanusBundle:Grupos:grupos.html.twig', array(
            'grupos' => $grupos
        ));
    }

    public function crearAction(Request $request)
    {
        $grupo = $this->get('artesanio.grupos_manager')->getClass();

        $grupoForm = $this->createForm('artesanio_acl_grupos', $grupo)->handleRequest($request);

        if($grupoForm->isValid()){

            $this->get('artesanio.grupos_manager')->save($grupo);

            return $this->redirect($this->generateUrl('grupo', array('id' => $grupo->getId())));
        }

        return $this->render('ArtesanusBundle:Grupos:grupos-crear.html.twig', array(
            'grupo_form' => $grupoForm->createView()
        ));
    }

    public function grupoAction(Request $request, $id)
    {
        $grupoManager = $this->get('fos_user.group_manager');

        $grupo = $grupoManager->findGroupByName($id);

        // $formFactory = $this->get('fos_user.group.form.factory');
        //
        // $grupoForm = $formFactory->createForm();
        // $grupoForm->setData($grupo);

        $roles = $this->get('artesanio.roles_manager')->findAll();

        $grupoForm = $this->createForm(new GroupFormType($grupo, $roles), $grupo);

        $grupoForm->handleRequest($request);

        if($grupoForm->isValid()){

            $grupo->setRoles(array());
            foreach($grupoForm->get('roles')->getData() as $role){
                $grupo->addRole($role);
            }

            $grupoManager->updateGroup($grupo);
            return $this->redirect($this->generateUrl('grupo', array('id' => $grupo->getName())));

        }

        return $this->render('ArtesanusBundle:Grupos:grupo.html.twig', array(
            'grupo'            => $grupo,
            'grupo_form'       => $grupoForm->createView(),
        ));
    }
}
