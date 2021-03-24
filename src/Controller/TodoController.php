<?php

namespace App\Controller;

use App\Entity\TodoList;
use App\Form\TodoType;
use App\Repository\TodoListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo_index")
     * @param TodoListRepository $todoListRepo
     * @return Response
     */
    public function index(TodoListRepository $todoListRepo): Response
    {
        return $this->render('todo/index.html.twig', [
            'todoItems' => $todoListRepo->fetchLiveTodoItems()
        ]);
    }

    /**
     * @Route("/new", name="todo_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $todoListEntity = new TodoList();
        //create form
        $todoListForm = $this->createForm(TodoType::class, $todoListEntity);

        $todoListForm->handleRequest($request);

        if ($todoListForm->isSubmitted() && $todoListForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todoListEntity);
            $entityManager->flush();

            return $this->redirectToRoute('todo_index');
        }

        return $this->render('todo/new.html.twig', [
            'form' => $todoListForm->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="todo_list_update", methods={"GET","POST"})
     * @param Request $request
     * @param TodoList $todoList
     * @return Response
     */
    public function edit(Request $request, TodoList $todoList): Response
    {
        $form = $this->createForm(TodoListType::class, $todoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todo_index');
        }

        return $this->render('todo/update.html.twig', [
            'todo_list' => $todoList,
            'form' => $form->createView(),
        ]);
    }
}
