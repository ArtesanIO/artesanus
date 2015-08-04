<?php

namespace ArtesanIO\ArtesanusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArtesanIO\ACLBundle\Form\Type\GroupFormType;


class GroupController extends Controller
{
    public function groupsAction()
    {
        $grupos = $this->get('fos_user.group_manager')->findGroups();

        return $this->render('ArtesanusBundle:Grupos:grupos.html.twig', array(
            'grupos' => $grupos
        ));
    }

    public function newAction(Request $request)
    {

        $groupManager = $this->get('artesanus.group_manager');

        $group = $groupManager->getClass();

        //$grupo = $this->get('artesanio.grupos_manager')->getClass();

        $grupoForm = $this->createForm('artesanus_group_type', $group)->handleRequest($request);

        if($grupoForm->isValid()){

            $this->get('artesanus.group_manager')->save($group);

            return $this->redirect($this->generateUrl('grupo', array('id' => $group->getId())));
        }

        return $this->render('ArtesanusBundle:Grupos:grupos-crear.html.twig', array(
            'grupo_form' => $grupoForm->createView()
        ));
    }

    public function groupAction(Request $request, $id)
    {
        $groupManager = $this->get('artesanus.group_manager');

        $group = $groupManager->find($id);

        $roles = $this->get('artesanus.roles_manager')->findAll();

        /*
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
        */

        $groupForm = $this->createForm('artesanus_group_type', $group);

        return $this->render('ArtesanusBundle:Grupos:grupo.html.twig', array(
            'grupo'            => $group,
            'grupo_form'       => $groupForm->createView(),
        ));
    }
}
