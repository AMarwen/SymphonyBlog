<?php

namespace Lynda\MagazineBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Lynda\MagazineBundle\Entity\Publication;
use Lynda\MagazineBundle\Form\PublicationType;

/**
 * Publication controller.
 *
 * @Route("/publication")
 */
class PublicationController extends Controller
{

    /**
     * Lists all Publication entities.
     *
     * @Route("/", name="publication")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        //1-get and store the entity manger in a Variable
        $em = $this->getDoctrine()->getManager();
       //2-get all entities of a specific repository
        $entities = $em->getRepository('LyndaMagazineBundle:Publication')->findAll();
       //3-send entity  returned by step 2 to the view
        return array(
            'entities' => $entities,
        );
    }
    //1-@Method : specify the method that the form will use
    //@Template : specify the View that will be used instead of default one ex(create.html.twig)
    /**
     * Creates a new Publication entity.
     *
     * @Route("/", name="publication_create")
     * @Method("POST")
     * @Template("LyndaMagazineBundle:Publication:new.html.twig")
     */
    //2-getting the Form HTTP request through first parameter to acces to user inputs
    public function createAction(Request $request)
    {
        //3-create an entity object and store it in var
        $entity = new Publication();
        //4-a new form that match the structure of the entity will be created
        $form = $this->createCreateForm($entity);
        //5-form receives the HTTP request through first parameter
        $form->handleRequest($request);
       //6-if the form inputs is valid
        if ($form->isValid()) {
            //get and store the entity manger in a Variable
            $em = $this->getDoctrine()->getManager();
            //make instance managed , persistence
            $em->persist($entity);
            //execute the query  against the database.
            $em->flush();
            //redirect browser to new location
            return $this->redirect($this->generateUrl('publication_show', array('id' => $entity->getId())));
        }
       //7-otherwise if form is not valid send this data to the new.html.twig view
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Publication entity.
     *
     * @param Publication $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Publication $entity)
    {
        $form = $this->createForm(new PublicationType(), $entity, array(
            'action' => $this->generateUrl('publication_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Publication entity.
     *
     * @Route("/new", name="publication_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Publication();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Publication entity.
     *
     * @Route("/{id}", name="publication_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        //1-get and store the entity manger in a Variable
        $em = $this->getDoctrine()->getManager();
        //2-get all entities of a specific repository
        $entity = $em->getRepository('LyndaMagazineBundle:Publication')->find($id);
        //3-if user enter an Entity id that deosn't exist in DB this erro will be thrown
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        //3-send entity  returned by step 2 to the view
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Publication entity.
     *
     * @Route("/{id}/edit", name="publication_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LyndaMagazineBundle:Publication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Publication entity.
    *
    * @param Publication $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Publication $entity)
    {
        $form = $this->createForm(new PublicationType(), $entity, array(
            'action' => $this->generateUrl('publication_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Publication entity.
     *
     * @Route("/{id}", name="publication_update")
     * @Method("PUT")
     * @Template("LyndaMagazineBundle:Publication:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LyndaMagazineBundle:Publication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('publication_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Publication entity.
     *
     * @Route("/{id}", name="publication_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LyndaMagazineBundle:Publication')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publication entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publication'));
    }

    /**
     * Creates a form to delete a Publication entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
