<?php

namespace App\Controller\Api;

use App\Entity\CheckList;
use App\Form\CheckListFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CheckListController
 * @package App\Controller\Api
 * @Route("/api/check_list")
 */
class CheckListApi extends AbstractController {
    private SerializerInterface $serializer;
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;

    /**
     * CheckListController constructor.
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator) {
        $this->serializer = $serializer;
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @return JsonResponse
     * @Route("/get", name="get_check_list", methods={"GET","HEAD"})
     */
    public function getCheckList(): JsonResponse {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'checkLists' => $this->serializer->serialize(
                $this->em->getRepository(CheckList::class)->findAll(),'json', ['groups'=>'get_user'])]);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Route("/get/{id}", name="get_the_check_list", methods={"GET","HEAD"})
     */
    public function getTheCheckList($id): JsonResponse {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'checkList' => $this->serializer->serialize(
                $this->em->getRepository(CheckList::class)->find($id),'json', ['groups'=>'get_user'])]);
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @Route("/post", name="post_the_check_list", methods={"POST"})
     */
    public function postCheckList(Request $request, ValidatorInterface $validator): JsonResponse {
        try {
            $list = $this->serializer->deserialize($request->getContent(), CheckList::class, 'json');

            $errors = $validator->validate($list);
            if (count($errors) > 0) {
                return $this->json(['status' => 400, 'message' => $errors[0]->getMessage()], 400);
            }
            $list->setUser($this->getUser());
            $this->em->persist($list);
            $this->em->flush();
            return $this->json(['status' => 201, 'message' => 'The check list is correctly save'], 201);
        }catch (NotEncodableValueException $e){
            $this->addFlash('success', $e->getMessage());
            return $this->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @Route("/put/{id}", name="put_the_check_list", methods={"PUT"})
     */
    public function editTheChecklist($id, Request $request): JsonResponse {
        $list = $this->em->getRepository(CheckList::class)->findOneById($id);
        if (!$list) throw $this->createNotFoundException('No product found for id '.$id);

        $data = json_decode($request->getContent(), true);

        if (empty($data['title'])) {
            return $this->json(["message" => "The title can not to be null"], 400);
        }
        if (empty($data['colorHexa'])) { $data['colorHexa'] = "#ffe333"; }

        try {
            $form = $this->createForm(CheckListFormType::class, $list);
            $form->submit($data);

            $errors = $this->validator->validate($list);
            if (count($errors) > 0) {
                return $this->json([ 'message' => $errors[0]->getMessage() ], 400);
            }

            $this->em->persist($list);
            $this->em->flush();

        } catch (NotEncodableValueException $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }
        return $this->json(['message' => 'The check list is correctly updated']);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Route("/delete/{id}", name="delete_the_check_list", methods={"DELETE"})
     */
    public function deleteTheCheckList($id): JsonResponse {
        $list = $this->em->getRepository(CheckList::class)->find($id);
        if (!$list) throw $this->createNotFoundException('No product found for id '.$id);
        try{
            $this->em->remove($list);
            $this->em->flush();
            return $this->json(['status' => 200, 'message' => 'The check list is correctly deleted']);
        }catch (NotEncodableValueException $e){
            return $this->json(['status' => 400,'message' => $e->getMessage()], 400);
        }
    }
}
