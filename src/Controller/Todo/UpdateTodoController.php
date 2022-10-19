<?php

namespace App\Controller\Todo;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('todo')]
class UpdateTodoController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_todo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        $form = $this->createForm(TodoType::class, $todo, ['update' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoRepository->save($todo, true);
            $this->addFlash('success', 'Todo modifié');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    #[Route('/state/{id}', name: 'app_todo_toggle_state', methods: ['POST'])]
    public function changeState(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        $todo->setIsDone(!$todo->isIsDone());
        $todoRepository->save($todo, true);
        $this->addFlash('success', 'Todo modifié');
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
