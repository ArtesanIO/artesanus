<?php

namespace ArtesanIO\ArtesanusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsuariosController extends Controller
{
    public function usuariosAction()
    {

        $users = $this->get('fos_user.user_manager')->findUsers();

        //$usuarios = $this->get('artesanio.usuarios_manager')->findAll();

        return $this->render('ArtesanusBundle:Usuarios:usuarios.html.twig', array(
            'usuarios' => $users
        ));
    }

    public function crearAction(Request $request)
    {
        $usuario = $this->get('artesanio.usuarios_manager')->getClass();

        $usuarioForm = $this->createForm('artesanio_acl_usuarios', $usuario)->handleRequest($request);

        if($usuarioForm->isValid()){

            $this->get('artesanio.usuarios_manager')->save($usuario);

            $this->get('artesanio.flashers')->add('success','Usuarios creado');

            return $this->redirect($this->generateUrl('usuario', array('id' => $usuario->getId())));
        }

        return $this->render('ACLBundle:Usuarios:usuarios-crear.html.twig', array(
            'usuario_form' => $usuarioForm->createView()
        ));
    }

    public function usuarioAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($id);

        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if($form->isValid()){

            $userManager->updateUser($user);
            return $this->redirect($this->generateUrl('usuario', array('id' => $user->getUsername())));
        }

        $formFactory = $this->get('fos_user.change_password.form.factory');

        $usuarioPasswordForm = $formFactory->createForm();
        $usuarioPasswordForm->setData($user);

        $usuarioPasswordForm->handleRequest($request);

        if ($usuarioPasswordForm->isValid()) {
            $userManager->updateUser($user);
            return $this->redirect($this->generateUrl('usuario', array('id' => $user->getUsername())));
        }

        return $this->render('ACLBundle:Usuarios:usuario.html.twig', array(
            'usuario_form' => $form->createView(),
            'usuario_password_form' => $usuarioPasswordForm->createView()
        ));
    }
}
