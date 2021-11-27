<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route ("/", methods={"GET"},  name="note_list")
     */
    public function index(): Response
    {
        $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();
        return $this->render('notes/index.html.twig', ['notes' => $notes]);
    }

    /**
     * @Route ("/note/new", methods={"GET", "POST"},  name="note_new")
     */
    public function new(Request $request): Response
    {
        return $this->render('notes/new.html.twig', ['tags' => ['personal', 'family', 'job', 'work']]);
    }

    /**
     * @Route ("/note/create", methods={"POST"},  name="note_create")
     */
    public function createNote(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $note = new Note();
        $note->setTitle($request->request->get('note-input'));
        $note->setBody($request->request->get('note-body'));

        $noteTags = $request->request->get('note-tag');
        foreach ($noteTags as $tag) {
            $noteTag = new Tag();
            $noteTag->setName($tag);
            $note->addTag($noteTag);
        }
        $entityManager->persist($note);
        $entityManager->flush();

        return $this->redirectToRoute('note_list');
    }

    /**
     * @Route ("/note/{id}", methods={"GET"}, name="note_show")
     */
    public function show(Note $note): Response
    {
        return $this->render('notes/show.html.twig', ['note' => $note]);
    }

    /**
     * @Route ("/note/delete/{id}", methods={"DELETE"}, name="note_delete")
     */
    public function delete(Note $note): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($note);
        $entityManager->flush();

        return new Response('Note with id of'. $note->getId(). 'got deleted');
    }

    /**
     * @Route ("/note/edit/{id}", methods={"GET", "POST"},  name="note_edit")
     */
    public function edit(Request $request, $id): Response
    {
        /**
         * @var Note
         */
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);

        return $this->render('notes/edit.html.twig', [
            'note' => $note,
            'tags' => ['personal', 'family', 'job', 'work'],
            'selectedTags' => $note->getTagNames()
        ]);
    }

    /**
     * @Route ("/note/save", methods={"POST"},  name="note_save")
     */
    public function saveNote(Request $request): Response
    {
        $note = $this->getDoctrine()->getRepository(Note::class)->find($request->request->get('note-id'));
        $entityManager = $this->getDoctrine()->getManager();
        $note->setTitle($request->request->get('note-input'));
        $note->setBody($request->request->get('note-body'));

        $note->removeAllTags();
        $noteTags = $request->request->get('note-tag');
        foreach ($noteTags as $tag) {
            $noteTag = new Tag();
            $noteTag->setName($tag);
            $note->addTag($noteTag);
        }
        $entityManager->persist($note);
        $entityManager->flush();

        return $this->redirectToRoute('note_show', ['id' => $note->getId()]);
    }
}
