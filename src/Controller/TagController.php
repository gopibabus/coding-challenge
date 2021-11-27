<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag_list")
     */
    public function index(): Response
    {
        $tags = $this->getDoctrine()->getRepository(Tag::class)->getTagNames();

        return $this->render('tag/index.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * @Route ("/tag/delete/{name}", methods={"DELETE"}, name="tag_delete")
     */
    public function delete(string $name): Response
    {
        $this->getDoctrine()->getRepository(Tag::class)->deleteTagsByName($name);
        return new JsonResponse(['success' => "tags with {$name} successfully deleted!!"]);
    }
}
