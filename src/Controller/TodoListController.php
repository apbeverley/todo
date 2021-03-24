<?php

namespace App\Controller;

use App\Entity\TodoList;
use App\Form\TodoListType;
use App\Repository\TodoListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    /**
     * @Route("/", name="todo_list_index")
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
     * @Route("/new", name="todo_list_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $todoListEntity = new TodoList();

        $todoListForm = $this->createForm(TodoListType::class, $todoListEntity);

        $todoListForm->handleRequest($request);

        if ($todoListForm->isSubmitted() && $todoListForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todoListEntity);
            $entityManager->flush();

            return $this->redirectToRoute('todo_list_index');
        }

        return $this->render('todo/form.html.twig', [
            'form' => $todoListForm->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="todo_list_update", methods={"GET", "POST"})
     * @param TodoList $todoListEntity
     * @param Request $request
     * @return Response
     */
    public function edit(TodoList $todoListEntity, Request $request): Response
    {
        if (!$todoListEntity || $todoListEntity->getCompleted() === true) {
            throw $this->createNotFoundException('No task found');
        }

        $form = $this->createForm(TodoListType::class, $todoListEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todo_list_index');
        }

        return $this->render('todo/form.html.twig', [
            'form' => $form->createView(),
            'todoListItem' => $todoListEntity,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="todo_list_delete", methods={"GET"})
     * @param TodoList $todoListEntity
     * @return Response
     */
    public function delete(TodoList $todoListEntity): Response
    {
        if (!$todoListEntity) {
            throw $this->createNotFoundException('No task found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($todoListEntity);
        $em->flush();

        return $this->redirectToRoute('todo_list_index');
    }
}
