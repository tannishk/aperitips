<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Auth\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @Route("/profil/{slug}", name="user_index", requirements={
     *     "slug": "[a-zA-Z0-9\-._=]+"
     * })
     * @Method("GET")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string                                    $slug
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, string $slug): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBySlug($slug);

        if (!$user) {
            throw $this->createNotFoundException($this->get('translator')->trans('user.not_found'));
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profil/settings", name="user_account_settings")
     * @Method({"GET", "POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request): Response
    {
        $user = $this->getUser();

        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if ($editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', $this->get('translator')->trans('form.user.edit_success', [], 'form'));

                return $this->redirectToRoute('user_account_settings');
            }

            $this->addFlash('error', $this->get('translator')->trans('form.user.edit_error', [], 'form'));
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $editForm->createView(),
        ]);
    }

    /**
     * @param \AppBundle\Entity\Auth\User $user
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(User $user): Form
    {
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('user_account_settings'),
            'method' => Request::METHOD_POST,
        ]);

        return $form;
    }
}
