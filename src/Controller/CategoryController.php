<?php

namespace App\Controller;

use App\Entity\Bids;
use App\Entity\Category;
use App\Repository\BidsRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api', name: 'api')]
class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category', methods: 'POST')]
    public function index(Request $request): Response
    {
        $serializer = $this->getSerializer();

        $category = $serializer->deserialize($request->getContent(), Category::class, 'json');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
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

    #[Route('/category', name: 'category', methods: 'GET')]
    public function get_category(Request $request, CategoryRepository $categoryRepository): Response
    {
        $response = new Response();

        $id = json_decode($request->getContent(), true);
        $categoryModel = $categoryRepository->findOneBy(['product' => $id]);

        $serializer = $this->getSerializer();

        $bids = $serializer->serialize($categoryModel, 'json');

        if ($bids) {
            $response->setContent($bids);
        } else {
            $response->setContent(json_encode([
                "bids" => "not found"
            ]));
        }

        return $response;
    }
}
