<?php

namespace App\Controller\Todo;

use App\Entity\Board;
use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('todo')]
class CreateTodoController extends AbstractController
{
    #[Route('/new/board/{board}', name: 'app_todo_new', methods: ['GET', 'POST'])]
    public function new(Board $board, Request $request, TodoRepository $todoRepository): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todo->setIsDone(false);
            $todo->setBoard($board);
            $todoRepository->save($todo, true);
            $this->addFlash('success', 'Todo ajouté');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }
}
