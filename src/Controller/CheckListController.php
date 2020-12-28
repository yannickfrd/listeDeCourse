<?php

namespace App\Controller;

use App\Form\CheckListFormType;
use App\Form\ElementType;
use App\Repository\CheckListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckListController
 * @package App\Controller
 * @Route("/check_list")
 */
class CheckListController extends AbstractController
{
    /**
     * @param CheckListRepository $checkListRepository
     * @return Response
     * @Route("/", name="check_list")
     */
    public function index(CheckListRepository $checkListRepository): Response
    {
        $checklistForm = $this->createForm(CheckListFormType::class);

        return $this->render('check_list/index.html.twig', [
            'checklists' => $checkListRepository->findBy([], ['createdAt' => 'desc']), // par "date" + à - récente
            'checklistForm' => $checklistForm->createView()
        ]);
    }

    /**
     * @param $id
     * @param CheckListRepository $checkListRepository
     * @return Response
     * @Route("/{id}", name="check_list_add_products")
     */
    public function addProducts($id, CheckListRepository $checkListRepository): Response
    {
        $form = $this->createForm(ElementType::class);
        $list = $checkListRepository->find($id);
        if (!$list) return $this->redirectToRoute('check_list');

        return $this->render('check_list/add.html.twig', [
            'list' => $list,
            'form' => $form->createView()
        ]);
    }
}
