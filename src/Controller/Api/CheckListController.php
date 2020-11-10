<?php

namespace App\Controller\Api;

use App\Entity\CheckList;
use App\Entity\Color;
use App\Form\CheckListFormType;
use App\Repository\CheckListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckListController
 * @package App\Controller\Api
 * @Route("/api/check_list")
 */
class CheckListController extends AbstractController {
    /**
     * @var CheckListRepository
     */
    protected $repoList;
    /**
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CheckListController constructor.
     * @param $repoList
     * @param $serializer
     */
    public function __construct(CheckListRepository $repoList, SerializerInterface $serializer, EntityManagerInterface $em) {
        $this->repoList = $repoList;
        $this->serializer = $serializer;
        $this->em = $em;
    }


    /**
     * @return JsonResponse
     * @Route("/get", name="get_check_list", methods={"GET","HEAD"})
     */
    public function getCheckList(): JsonResponse {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'checkLists' => $this->serializer->serialize(
                $this->repoList->findAll(),'json', ['groups'=>'get_user'])], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Route("/get/{id}", name="get_the_check_list", methods={"GET","HEAD"})
     */
    public function getTheCheckList($id): JsonResponse {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'checkLists' => $this->serializer->serialize(
                $this->repoList->find($id),'json', ['groups'=>'get_user'])], 200);
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @Route("/post", name="post_the_check_list", methods={"POST"})
     */
    public function postCheckList(Request $request, SerializerInterface $serializer): JsonResponse {
        try {
            $list = $serializer->deserialize($request->getContent(), CheckList::class, 'json');
            foreach (json_decode($request->getContent(), true) as $relation => $value) {
                if ($relation==='color'){
                    $getColor = $this->em->getRepository(Color::class)->find($value);
                    if(!$getColor) throw $this->createNotFoundException('No Color found for '. $value);
                    $list->setColor($getColor);
                }
            }
            $this->em->persist($list);
            $this->em->flush();
            return $this->json(['status' => 201, 'message' => 'THe check list is correctly save'], 201);
        }catch (NotEncodableValueException $e){
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
        $list = $this->repoList->find($id);
        if (!$list) throw $this->createNotFoundException('No product found for id '.$id);

        try {
            $form = $this->createForm(CheckListFormType::class, $list);
            $form->submit(json_decode($request->getContent(), true));

            if ($form->isValid()){
                $this->em->persist($list);
                $this->em->flush();
                return $this->json(['status' => 202, 'message' => 'The check list is correctly updated'], 202);
            }
        }catch (NotEncodableValueException $e){
            return $this->json(['status' => 400,'message' => $e->getMessage()], 400);
        }
        return $this->json(null, 204);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Route("/delete/{id}", name="delete_the_check_list", methods={"DELETE"})
     */
    public function deleteTheCheckList($id): JsonResponse {
        $list = $this->repoList->find($id);
        if (!$list) throw $this->createNotFoundException('No product found for id '.$id);
        try{
            $this->em->remove($list);
            $this->em->flush();
            return $this->json(['status' => 202, 'message' => 'The check list is correctly deleted'], 202);
        }catch (NotEncodableValueException $e){
            return $this->json(['status' => 400,'message' => $e->getMessage()], 400);
        }
    }
}
