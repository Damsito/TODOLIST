<?php

namespace App\Controller\Board;

use App\Entity\Board;
use App\Form\BoardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateBoardController extends AbstractController
{
    #[Route('/create/board', name: 'app_create_board')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $board = new Board();

        $form = $this->createForm(BoardType::class, $board);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($board);
            $em->flush();
            $this->addFlash('success', 'Board ajouté');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('create_board/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
