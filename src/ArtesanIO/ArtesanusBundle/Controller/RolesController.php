<?php

namespace ArtesanIO\ArtesanusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RolesController extends Controller
{
    public function rolesAction()
    {
        $roles = $this->get('artesanio.roles_manager')->findAll();

        return $this->render('ArtesanusBundle:Roles:roles.html.twig', array(
            'roles' => $roles
        ));
    }

    public function crearAction(Request $request)
    {
        $role = $this->get('artesanio.roles_manager')->getClass();

        $roleForm = $this->createForm('artesanio_acl_roles', $role)->handleRequest($request);

        if($roleForm->isValid()){

            $this->get('artesanio.roles_manager')->save($role);

            return $this->redirect($this->generateUrl('role', array('id' => $role->getId())));
        }

        return $this->render('ArtesanusBundle:Roles:roles-crear.html.twig', array(
            'role_form' => $roleForm->createView()
        ));
    }

    public function roleAction(Request $request, $id)
    {
        $role = $this->get('artesanio.roles_manager')->find($id);

        $roleForm = $this->createForm('artesanio_acl_roles', $role)->handleRequest($request);

        if($roleForm->isValid()){

            $this->get('artesanio.roles_manager')->update();

            return $this->redirect($this->generateUrl('role', array('id' => $role->getId())));
        }

        return $this->render('ArtesanusBundle:Roles:role.html.twig', array(
            'role' => $role,
            'role_form' => $roleForm->createView(),
        ));
    }
}
