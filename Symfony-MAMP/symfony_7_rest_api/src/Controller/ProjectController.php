<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;


#[Route('/api', name: 'api_')]
class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'project_index', methods: ['get'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {

        $products = $entityManager
            ->getRepository(Project::class)
            ->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
            ];
        }

        return $this->json($data);
    }


    #[Route('/projects', name: 'project_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;

        $project = new Project();
        $project->setName($name);
        $project->setDescription($description);

       

        $entityManager->persist($project);
        $entityManager->flush();

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
        ];

        return $this->json($data);
    }


    #[Route('/projects/{id}', name: 'project_show', methods: ['get'])]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {

            return $this->json('No project found for id ' . $id, 404);
        }

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
        ];

        return $this->json($data);
    }

    #[Route('/projects/{id}', name: 'project_update', methods: ['put', 'patch'], requirements: ["id"=> "\d+"])]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id ' . $id, 404);
        }
        $content = $request->getContent();
        $data = json_decode($content, true);
        
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;

        $project->setName($name);
        $project->setDescription($description);
        $entityManager->flush();

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
        ];

        return $this->json($data);
    }

    #[Route('/projects/{id}', name: 'project_delete', methods: ['delete'])]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id ' . $id, 404);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json('Deleted a project successfully with id ' . $id);
    }
}
