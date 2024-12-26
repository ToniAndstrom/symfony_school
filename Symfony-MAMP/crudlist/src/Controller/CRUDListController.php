<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class CRUDListController extends AbstractController
{
    #[Route('/crud', name: "app_crud_list")]
    public function index(EntityManagerInterface $em)
    {
        $tasks = $em->getRepository(Task::class)->findAll(); //findBy([], ["id" => "DESC"]);
        return $this->render("crudlist/index.html.twig", ["tasks" => $tasks]);
    }
    #[Route('/create', name: "create_task", methods: ["POST"])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $title = trim($request->get("title"));
        if (empty($title)) {
            return $this->redirectToRoute("app_crud_list");
        }
        $entityManager = $doctrine->getManager();
        $task = new Task();
        $task->setTitle($title);
        $entityManager->persist($task); //perpares for saving in database
        $entityManager->flush(); //saving is done by thins line in db (insert)
        return $this->redirectToRoute("app_crud_list");
    }
    #[Route('/update/{id}', name: "update_task")]
    public function update($id, ManagerRegistry $doctrine)
    {
        $entityManger = $doctrine->getManager();
        $task = $entityManger->getRepository(Task::class)->find($id);
        $task->setStatus(!$task->getStatus());
        $entityManger->flush();
        return $this->redirectToRoute("app_crud_list");
    }
    #[Route('/delete/{id}', name: "delete_task")]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $entityManger = $doctrine->getManager();
        $id = $entityManger->getRepository(Task::class)->find($id);
        $entityManger->remove($id);
        $entityManger->flush();
        return $this->redirectToRoute("app_crud_list");
    }
}
