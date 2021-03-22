<?php

namespace App\Controller;

use App\Entity\TodoList;
use App\Form\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        //create form
        $todoListForm = $this->createForm( TodoType::class);

        $todoListForm->handleRequest($request);

        if ($todoListForm->isSubmitted() && $todoListForm->isValid())
        {
            $data = $todoListForm->getData();
        }

        return $this->render('todo/index.html.twig', [
            'form' => $todoListForm->createView(),
        ]);
    }
}
