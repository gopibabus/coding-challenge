<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function new(Request $request)
    {
        $note = new Note();
        $form = $this->createFormBuilder($note)
            ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('body', TextareaType::class, ['attr' => ['required' => false, 'class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Create', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $note = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_list');
        }

        return $this->render('notes/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route ("/note/{id}", methods={"GET"}, name="note_show")
     */
    public function show(Note $note): Response
    {
        return $this->render('notes/show.html.twig', ['note' => $note]);
    }

    /**
     * @Route ("/note/save", methods={"GET"}, name="note_save")
     */
    public function save(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $note = new Note();
        $note->setTitle('Note one');
        $note->setBody('Body of note 1');
        $entityManager->persist($note);
        $entityManager->flush();

        return new Response('saved note with id of'. $note->getId());
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
    public function edit(Request $request, $id)
    {
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
        $form = $this->createFormBuilder($note)
            ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('body', TextareaType::class, ['attr' => ['required' => false, 'class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Update', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('note_list');
        }

        return $this->render('notes/edit.html.twig', ['form' => $form->createView()]);
    }
}
