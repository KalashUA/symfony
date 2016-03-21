<?php

namespace AppBundle\Controller;

use AppBundle\Entity\test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TestController extends Controller
{
  /**
   * @Route("/ ", name="test_page")
   */
  public function listAction()
  {
    $test = $this->getDoctrine()->getRepository('AppBundle:test')->findAll();
    // replace this example code with whatever you need
    return $this->render('test/index.html.twig', array('test' => $test));
  }

  /**
   * @Route("/create", name="test_create")
   */
  public function createAction(Request $request)
  {
    $test = new test();
//    $task->setTask('Write a blog post');
//    $task->setDueDate(new \DateTime('tomorrow'));

    $form = $this->createFormBuilder($test)
      ->add('name', TextType::class, array('attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('category', TextType::class,  array('attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('description', TextareaType::class,  array('attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal'), 'attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('date', DateTimeType::class,  array('attr' => array ('class' =>'form-control', 'style' => 'height:auto')))
      ->add('save', SubmitType::class, array('label' => 'Create Article', 'attr' =>array('class' => 'btn btn-primary', 'style' => 'margin-top:15px')))
      ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $name = $form['name']->getData();
      $category = $form['category']->getData();
      $description = $form['description']->getData();
      $priority = $form['priority']->getData();
      $date = $form['date']->getData();

      $now = new\DateTime('now');
      $test->SetName($name);
      $test->SetCategory($category);
      $test->SetDescription($description);
      $test->SetPriority($priority);
      $test->SetDate($date);
      $test->setCreateDate($now);

      $em = $this ->getDoctrine()->getManager();
      $em->persist($test);
      $em->flush();

      $this->addFlash('notice', 'Article Created');
      return $this->redirectToRoute('test_page');
    }
    // replace this example code with whatever you need1
    return $this->render('test/create.html.twig', array(
      'form'=> $form->createView(),
    ));
  }

  /**
   * @Route("/test/edit/{id}", name="test_edit")
   */
  public function editAction($id, Request $request)
  {
    $test = $this->getDoctrine()->getRepository('AppBundle:test')->find($id);
    // replace this example code with whatever you need

//    $task->setTask('Write a blog post');
//    $task->setDueDate(new \DateTime('tomorrow'));
    $now = new\DateTime('now');

    $em = $this ->getDoctrine()->getManager();
    $test = $em->getRepository('AppBundle:test')->find($id);
    $test->SetName($test->getName());
    $test->SetCategory($test->getCategory());
    $test->SetDescription($test->getDescription());
    $test->SetPriority($test->getPriority());
    $test->SetDate($test->getDate());
    $test->setCreateDate($now);

    $form = $this->createFormBuilder($test)
      ->add('name', TextType::class, array('attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('category', TextType::class,  array('attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('description', TextareaType::class,  array('attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal'), 'attr' => array ('class' =>'form-control', 'style' => 'margin-bottpm:15px')))
      ->add('date', DateTimeType::class,  array('attr' => array ('class' =>'form-control', 'style' => 'height:auto')))
      ->add('save', SubmitType::class, array('label' => 'Update Article', 'attr' =>array('class' => 'btn btn-primary', 'style' => 'margin-top:15px')))
      ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $name = $form['name']->getData();
      $category = $form['category']->getData();
      $description = $form['description']->getData();
      $priority = $form['priority']->getData();
      $date = $form['date']->getData();

      $em->flush();

      $this->addFlash('notice', 'Article Updated');
      return $this->redirectToRoute('test_page');
    }
    return $this->render('test/edit.html.twig', array('test' => $test, 'form' => $form->createView()));
  }

  /**
   * @Route("/test/details/{id}", name="test_details")
   */
  public function detailsAction($id)
  {
    $test = $this->getDoctrine()->getRepository('AppBundle:test')->find($id);
    // replace this example code with whatever you need
    return $this->render('test/details.html.twig', array('test' => $test));
  }

  /**
   * @Route("/test/delete/{id}", name="test_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $test = $this->getDoctrine()->getRepository('AppBundle:test')->find($id);
    $em->remove($test);
    $em->flush();
    $this->addFlash('notice', 'Article Removed');
    return $this->redirectToRoute('test_page');
  }
}
