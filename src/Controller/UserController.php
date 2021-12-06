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

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/new_user", name="register")
     */
    public function new_user(Request $request): Response
    {
        $serializer = $this->getSerializer();

        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getSerializer(): Serializer
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/user", name="get_user")
     */
    public function get_user(Request $request, UserRepository $userRepository): Response
    {
        $response = new Response();

        $email = json_decode($request->getContent(), true);
        $userModel = $userRepository->findOneBy(['email' => $email]);

        $serializer = $this->getSerializer();

        $user = $serializer->serialize($userModel, 'json');

        if ($user) {
            $response->setContent($user);
        } else {
            $response->setContent(json_encode([
                "user" => "not found"
            ]));
        }

        return $response;
    }
}
