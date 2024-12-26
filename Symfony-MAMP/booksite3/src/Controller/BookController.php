<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    #[Route('/', name: 'app_book')]
    public function index(EntityManagerInterface $em)
    {
        $books = $em->getRepository(Book::class)->findAll();
        return $this->render("booksite/index.html.twig", ["books" => $books]);
    }
    #[Route("/create", name: "create_book")]

    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $title = trim($request->get("title"));
        $author = trim($request->get("author"));
        $publishing_year = trim($request->get("publishing_year"));
        $genre = trim($request->get("genre"));
        $description = trim($request->get("description"));

        if (empty($title)) {
            return $this->redirectToRoute("app_book");
        }
        $entityManager = $doctrine->getManager();
        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setPublishingYear($publishing_year);
        $book->setGenre($genre);
        $book->setDescription($description);
        $entityManager->persist($book); //perpares for saving in database
        $entityManager->flush(); //saving is done by thins line in db (insert)
        return $this->redirectToRoute("app_book");
    }
   /* #[Route(`/update/{id}`, name: "update_book", methods:["PUT"])]
    public function update($id, ManagerRegistry $doctrine)
    {
        $entityManger = $doctrine->getManager();
        $book = $entityManger->getRepository(Book::class)->find($id);
        $book->setTitle(!$book->getTitle());
        $book->setAuthor(!$book->getAuthor());
        $book->setPublishingYear(!$book->getPublishingYear());
        $book->setGenre(!$book->getGenre());
        $book->setDescription(!$book->getDescription());
        $entityManger->flush();
        return $this->redirectToRoute("app_book");
    }*/

    #[Route('/delete/{id}', name: "delete_book")]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $entityManger = $doctrine->getManager();
        $id = $entityManger->getRepository(Book::class)->find($id);
        $entityManger->remove($id);
        $entityManger->flush();
        return $this->redirectToRoute("app_book");
    }

     /*#[Route("/update/{id}", name: "update_book", methods: ["POST", "GET"])]
    public function update(Request $request, Book $book, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()
                ->flush();

            return $this->redirectToRoute("app_book");
        }

        return $this->render("booksite/index.html.twig", [
            "book" => $book,
            "form" => $form->createView(),
        ]);
    }*/

    #[Route(`/update/{id}`, name: "update_book")]
    public function update(Request $request, Book $book, int $id, EntityManagerInterface $em)
    {
        
        $book = $this->$em->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->$em->persist($book);
            $this->$em->flush();
            return $this->redirectToRoute("app_book");
        }
        return $this->render("booksite/index.html.twig", [
            "form" =>$form->createView()
        ]);
      
    }
   
}
