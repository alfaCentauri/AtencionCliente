<?php


namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @var Ticket
     */
    private $ticket;

    /**
     * @var array
     */
    private $colaAtencion1;

    /**
     * @var array
     */
    private $colaAtencion2;

    /**
     * @Route("/{pag}", name="ticket_index", methods={"GET","POST"}, requirements={"pag"="\d+"})
     * @param Request $request
     * @param int $pag
     * @return Response
     */
    public function index(Request $request, int $pag = 1 ): Response
    {
        $paginas = 0;

        return $this->render('default/index.html.twig', [
            'colaAtencion1' => $this->colaAtencion1,
            'colaAtencion2' => $this->colaAtencion2,
            'paginaActual' => $pag,
            'total' => $paginas,
        ]);
    }

    /**
     * @Route("/new", name="ticket_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request ): Response
    {
        $this->ticket = new Ticket();
        $this->ticket->setId($request->request->get("id",0));
        $this->ticket->setNombre($request->request->get("nombre",""));

        return $this->renderForm('default/formulario.html.twig', array());
    }
}