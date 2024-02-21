<?php

namespace App\Controller;

use App\Entity\BlogArticle;
use App\Entity\BlogComment;
use App\Form\BlogArticleType;
use App\Form\BlogCommentType;
use App\Repository\BlogArticleRepository;
use App\Repository\BlogCommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/blog/article')]
class BlogArticleController extends AbstractController
{
    #[Route('/', name: 'app_blog_article_index', methods: ['GET'])]
    public function index(BlogArticleRepository $blogArticleRepository): Response
    {
        return $this->render('blog_article/afficher_article.html.twig', [
            'blog_articles' => $blogArticleRepository->findAll(),
        ]);
    }

    #[Route('/all', name: 'app_blog_article_all', methods: ['GET'])]
    public function allArticle(BlogArticleRepository $blogArticleRepository): Response
    {
        return $this->render('blog_article/index.html.twig', [
            'blog_articles' => $blogArticleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_blog_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blogArticle = new BlogArticle();
        $form = $this->createForm(BlogArticleType::class, $blogArticle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                # $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $slugger = new AsciiSlugger();
                $safeFilename = $slugger->slug($originalFilename);


                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }

                $blogArticle->setImage($newFilename);
            }
            $entityManager->persist($blogArticle);
            $entityManager->flush();

            $this->addFlash('notice', 'Submitted successfuly!!');

            return $this->redirectToRoute('app_blog_article_index');
        }

        return $this->render('blog_article/new.html.twig', [
            'blog_article' => $blogArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_article_show', methods: ['GET','POST'])]
    public function show(BlogArticle $blogArticle,Request $request, EntityManagerInterface $entityManager,BlogCommentRepository $blogCommentRepository): Response
    {
        $comments = $blogCommentRepository->findByBlogArticle($blogArticle);
        $blogComment = new BlogComment();
        $form = $this->createForm(BlogCommentType::class, $blogComment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $blogComment->setBlogArticle($blogArticle);
            $entityManager->persist($blogComment);
            $entityManager->flush();
            return $this->redirectToRoute('app_blog_article_index');
        }
        return $this->render('blog_article/show.html.twig', [
            'blogArticle' => $blogArticle,
            'comments' => $comments,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blog_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BlogArticle $blogArticle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogArticleType::class, $blogArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                # $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $slugger = new AsciiSlugger();
                $safeFilename = $slugger->slug($originalFilename);


                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }

                $blogArticle->setImage($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_article/edit.html.twig', [
            'blog_article' => $blogArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_blog_article_delete')]
    public function delete(Request $request, BlogArticle $blogArticle, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($blogArticle);
        $entityManager->flush();

        $this->addFlash('notice', 'Deleted successfuly!!');

        return $this->redirectToRoute('app_blog_article_index');
    }
}
