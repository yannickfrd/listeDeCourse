<?php

namespace App\Controller\Api;

use App\Entity\Element;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class ElementApi
 * @package App\Controller\Api
 * @Route("/api/element")
 */
class ElementApi extends AbstractController {
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Route("/get/{id}", name="get_element", methods={"GET"})
     */
    public function show($id): JsonResponse
    {
        $elements = $this->em->getRepository(Element::class)->findBy(['checkList' => $id]);

        if (!$elements){
            return $this->json(['message' => 'This CheckList do not exist!!'], 400);
        }

        return $this->json([
            'elements' => $this->serializer->serialize($elements,  'json', ['groups' => 'show_element'])
        ]);
    }
    /**
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * @Route("/post", name="post_element", methods={"POST"})
     */
    public function add(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $element = $serializer->deserialize($request->getContent(), Element::class, 'json');
        dd($element);
        return $this->json([], 200);
    }

}