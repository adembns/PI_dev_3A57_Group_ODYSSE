<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\Hotel1Type;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Snappy\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;





#[Route('/hotel')]
class HotelController extends AbstractController
{
    #[Route('/hotels', name: 'app_hotel_index', methods: ['GET'])]
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }
    
    

      
    
    #[Route('/cc', name: 'app_hotel_index1', methods: ['GET'])]
    public function indexx(Request $request, HotelRepository $hotelRepository, PaginatorInterface $paginator): Response
    {
        $searchQuery = $request->query->get('q');

        $qb = $hotelRepository->createQueryBuilder('h')
            ->orderBy('h.id', 'ASC'); // default order

        // Add search filter if search query is present
        if ($searchQuery) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('h.name', ':searchQuery'),
                    $qb->expr()->like('h.prix', ':searchQuery'),
                    $qb->expr()->like('h.location', ':searchQuery'),
                    $qb->expr()->like('h.features', ':searchQuery')
                )
            )
                ->setParameter('searchQuery', "%$searchQuery%");
        }

        $pagination=$paginator->paginate(
            $hotelRepository->paginationQuery(),
            $request->query->get('page',1),
            2
         ); 
        

        return $this->render('hotel/index1.html.twig', [
            'pagination' => $pagination,
            'searchQuery' => $searchQuery, // Pass the search query to the template
        ]);
    }

    


    


    #[Route('/new', name: 'app_hotel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(Hotel1Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }
        $errors = $validator->validate($hotel);

        return $this->render('hotel/new.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
            'errors'=> $errors,

        ]);
    }

    #[Route('/{id}', name: 'app_hotel_show', methods: ['GET'])]
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/{id}/admin', name: 'app_hotel_show_admin', methods: ['GET'])]
    public function show_admin(Hotel $hotel): Response
    {
        return $this->render('hotel/show_admin.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hotel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hotel $hotel, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(Hotel1Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }
        $errors = $validator->validate($hotel);

        return $this->render('hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
            'errors'=> $errors,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_hotel_delete', methods: ['POST'])]
    public function delete(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pdf/{id}', name: 'app_hotel_pdf', methods: ['GET'])]
    public function generatePdf(Hotel $programe): Response
    {
        // Créer une nouvelle instance Dompdf
        $dompdf = new Dompdf();

        // Récupérer le contenu de votre page Twig
        $html = $this->renderView('hotel/receipt.html.twig', [
            'hotel' => $programe,
        ]);

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Envoyer le PDF en réponse
        $pdfContent = $dompdf->output();
        
        // Créer une réponse avec le contenu PDF
        $response = new Response($pdfContent);
        
        // Ajouter les en-têtes pour indiquer qu'il s'agit d'un fichier PDF
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="programe_'.$programe->getId().'.pdf"');

        return $response;
    }
    // #[Route('/{id}/pdf', name: 'app_hotel_pdf1', methods: ['GET', 'POST'])]
    // public function generateReceipt(hotel $hotel , Pdf $snappy)
    // {
    
    // // Get the HTML for the receipt
    // $html = $this->renderView('hotel/receipt.html.twig', [
    //     'hotel' => $hotel,
    // ]);
    
    // // Set options for the PDF
    // $snappy->setOption('margin-top', '20mm');
    // $snappy->setOption('margin-right', '20mm');
    // $snappy->setOption('margin-bottom', '20mm');
    // $snappy->setOption('margin-left', '20mm');
    
    
    // // Generate the PDF from the HTML
    // $pdfData =  $snappy->getOutputFromHtml($html);
    
    // // Send the PDF as a response
    // return new Response($pdfData, 200, [
    //     'Content-Type' => 'application/pdf',
    //     'Content-Disposition' => 'attachment; filename="receipt.pdf"',
    // ]);
    // }
}
