<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request): Response
    {
        $user = new User();

        $data = json_decode($request->getContent());

        $response = new Response();
        $response->setContent(json_encode([
            'data_received' => $data,
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

//        return $this->render('register/index.html.twig', [
//            'controller_name' => 'RegisterController',
//        ]);
    }
}
