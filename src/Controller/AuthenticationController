<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Persistence\ManagerRegistry;


#[Route("/authentication", name: "authentication")]
class AuthenticationController extends AbstractController
{
    #[Route("/login", name: "login")]
    public function login(Request $request, UserRepository $userRepository): Response
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

    #[Route("/register", name: "register")]
    public function register(Request $request, UserRepository $userRepository, ManagerRegistry $doctrine): Response
    {
        $serializer = $this->getSerializer();

        $user = $serializer->deserialize($request->getContent(), User::class, "json");

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $response = new Response();

        $response->headers->set("Content-Type", "application/json");
        return $response;
    }

    public function getSerializer(): Serializer
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }
}
