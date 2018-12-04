<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\User;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Displays a form to edit an existing Users.
     * @Security("has_role('ROLE_MODERATEUR')")
     */
    public function edituserAction(Request $request, $id)
    {

		$em = $this->get('fos_user.user_manager');
		
		$advert = $em->findUserBy(
			array('id' => $id), // Critere
			array('date' => 'desc'),  // Tri
			50,                       // Limite
			0                         // debut
		);

		if (null === $advert) {
		  throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}
		
		$form = $this->get('form.factory')->create(\AppBundle\Form\RegistrationType::class, $advert);

        $form->remove('roles');

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->updateUser($advert);

		}

        return $this->render('edituser.html.twig', array(
            'article' => $id,
            'edit_form' => $form->createView(),

        ));
		
	} 
	
	// modifier son profile
	public function edituseractiveAction(Request $request)
    {
		
		$em = $this->get('fos_user.user_manager');
				
		// récupérer l'utilisateur courant
		$user=$this->getUser();
		$advert = $em->findUserBy(array('id' => $user->getId()));

		if (null === $advert) {
		  throw new NotFoundHttpException("L'annonce n'existe pas.");
		}
		
		$form = $this->get('form.factory')->create(\AppBundle\Form\RegistrationType::class, $advert);

        $form->remove('roles');

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->updateUser($advert);

		}

        return $this->render('edituser.html.twig', array(
            'article' => $user->getId(),
            'edit_form' => $form->createView(),

        ));
		
	} 
	
	/**
     * Displays a form to edit an existing Users.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edituseradminAction(Request $request, $id)
    {

		$em = $this->get('fos_user.user_manager');
		
		$advert = $em->findUserBy(
			array('id' => $id), // Critere
			array('date' => 'desc'),  // Tri
			50,                       // Limite
			0                         // debut
		);

		if (null === $advert) {
		  throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}
		
		$form = $this->get('form.factory')->create(\AppBundle\Form\RegistrationType::class, $advert);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->updateUser($advert);

		}

        return $this->render('edituser.html.twig', array(
            'article' => $id,
            'edit_form' => $form->createView(),

        ));
		
	}
}