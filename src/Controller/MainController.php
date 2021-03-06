<?php

namespace App\Controller;

use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('main/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/articles/{id}', name: 'app_articles_id')]
    public function getArticlesByid($id, ArticleRepository $articleRepository, Request $request,UserRepository $userRepository, ManagerRegistry $managerRegistry)
    {
        $article = $articleRepository->find($id);
    
        $commentaireForm = $this->createForm(CommentaireType::class);

        $commentaireForm->handleRequest($request);
        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {

            $commentaire = $commentaireForm->getData();
            $commentaire->setDate(new \DateTime());
            $commentaire->setPublie(false);
            $commentaire->setArticle($article);
            $user = $this->getUser();
            $commentaire->setUser($user);

            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
            $this->addFlash("success", "Votre commentaire a bien été enregistré. En attente de validation." );
        }

        return $this->render('main/article.html.twig', [
            "article" => $article,
            "commForm" => $commentaireForm->createView()
            
        ]);
    }
   
}
