<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route("/login", name: "bids", methods: "GET")]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $email = $data["email"];
        $user = $userRepository->findOneBy(["email" => $email]);

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");

        if ($user) {
            $response->setContent(json_encode([
                "user_id" => $user->getId()
            ]));
        } else {
            $response->setContent(json_encode([
                "error" => "not found"
            ]));
        }

        return $response;
    }
}
