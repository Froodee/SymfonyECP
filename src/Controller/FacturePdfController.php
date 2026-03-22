<?php

namespace App\Controller;

use App\Entity\Facture;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class FacturePdfController extends AbstractController
{
    #[Route('/facture/{id}/pdf', name: 'app_facture_pdf')]
    public function pdf(Facture $facture): Response
    {
        // Vérifier que la facture appartient à l'utilisateur connecté
        $utilisateur = $this->getUser()->getUtilisateur();
        if ($facture->getNumCde()?->getIdUser()?->getId() !== $utilisateur?->getId()) {
            throw $this->createAccessDeniedException();
        }

        $html = $this->renderView('facture/pdf.html.twig', [
            'facture'  => $facture,
            'commande' => $facture->getNumCde(),
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="facture-' . $facture->getNumFact() . '.pdf"',
            ]
        );
    }
}
