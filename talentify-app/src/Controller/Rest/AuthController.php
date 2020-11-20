<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return View
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $userEmail = $request->request->get('_email');
        $password = $request->request->get('_password');

        $user = new User();
        $user->setEmail($userEmail);
        $user->setPassword($encoder->encodePassword($user, $password));

        $em->persist($user);
        $em->flush();

        return View::create(
            ['message' => sprintf('User %s successfully created', $user->getUsername())],
            Response::HTTP_CREATED
        );
    }
}
