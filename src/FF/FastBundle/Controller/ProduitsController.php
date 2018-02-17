<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ProduitsController extends Controller
{
    public function indexAction()
    {
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						;
					$listProduits = $repository->findAll();
			

        return $this->render('FFFastBundle:Produits:index.html.twig', array('listProduits' => $listProduits) );
    }

    public function addAction(Request $request)
    {
   	 	$produits = new Produits();					
   		$form = $this->get('form.factory')->create(ProduitsType::class, $produits);
						dump($form);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->persist($produits);
									$em->flush();

				
        $request->getSession()->getFlashBag()->add('notice', 'Produit bien enregistrée.');

        return $this->redirectToRoute('ff_fast_viewp', array('id' => $produits->getId()));
      }

    

        return $this->render('FFFastBundle:Produits:add.html.twig', array(
        	'form' => $form->createView(),
        	));
    }
	

    public function viewAction($id)
      {			
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						;
					$produits = $repository->find($id);
			
				if (null === $produits) {
      throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
					}
						
      return $this->render('FFFastBundle:Produits:view.html.twig', array(
          'produits' => $produits
        ));
    }


    public function editAction($id,Request $request )
    {
    $em = $this->getDoctrine()->getManager();		
    $produits = $em->getRepository('FFFastBundle:Produits')->find($id);
			
			if (null === $produits) 
			{
				throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
			}

   		$form = $this->get('form.factory')->create(ProduitsType::class, $produits);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->flush();

				
			$request->getSession()->getFlashBag()->add('notice', 'Produit bien modifiée.');
		  return $this->redirectToRoute('ff_fast_viewp', array('id' => $produits->getId()));
					
				}
			
			
			
			
			        return $this->render('FFFastBundle:Produits:edit.html.twig', array(
					'produits'=> $produits,			
        	'form' => $form->createView(),
        	));

				
            
    }

	
	public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $produits = $em->getRepository('FFFastBundle:Produits')->find($id);

    if (null === $produits) {
      throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($produits);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le produits a bien été supprimée.");

      return $this->redirectToRoute('ff_fast_homep');
    }
    
    return $this->render('FFFastBundle:Produits:delete.html.twig', array(
      'produits' => $produits,
      'form'   => $form->createView(),
    ));
  }
}