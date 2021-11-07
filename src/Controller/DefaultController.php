<?php


namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\ColaAtencion;
use App\Repository\ColaAtencionRepository;
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
     * @var ColaAtencion
     */
    private $informacionAtencion;

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
     * @param ColaAtencionRepository $informacionAtencionRepository
     * @return Response
     */
    public function index(Request $request, int $pag = 1, ColaAtencionRepository $informacionAtencionRepository ): Response
    {
        $palabra = $request->request->get('buscar', null);
        $inicio = ($pag-1)*10;
        $totalTicketsCola1 = $informacionAtencionRepository->countAllByNumberCola(1);
        $totalTicketsCola2 = $informacionAtencionRepository->countAllByNumberCola(2);
        $this->colaAtencion1 = $informacionAtencionRepository->paginarColaAtencion($inicio, 10, 1);
        $this->colaAtencion2 = $informacionAtencionRepository->paginarColaAtencion($inicio, 10, 2);
        $paginasCola1 = $this->calcularPaginasTotalesAMostrar($totalTicketsCola1);
        $paginasCola2 = $this->calcularPaginasTotalesAMostrar($totalTicketsCola2);

        $tiempoEsperaColas = $this->comprobarColas();
        return $this->render('default/index.html.twig', [
            'colaAtencion1' => $this->colaAtencion1,
            'colaAtencion2' => $this->colaAtencion2,
            'paginaActual' => $pag,
            'totalPaginasCola1' => $paginasCola1,
            'totalPaginasCola2' => $paginasCola2,
            'tiemposEsperasColas' => $tiempoEsperaColas
        ]);
    }

    /**
     * @param int $total
     * @return int Regresa la cantidad de páginas a mostrar en el paginador.
     */
    private function calcularPaginasTotalesAMostrar(int $total): int
    {
        $paginasTotales = 0;
        if($total > 10){
            $paginasTotales = ceil( $total/10 );
        }
        return $paginasTotales;
    }

    /**
     * @Route("/new", name="ticket_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request ): Response
    {
        return $this->renderForm('default/formulario.html.twig', array());
    }

    /**
     * @Route("/save", name="ticket_save", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function save(Request $request ): Response
    {
        $this->processDataForm($request);
        $tiempoEsperaColas = $this->comprobarColas();
        if($tiempoEsperaColas[0] <= $tiempoEsperaColas[1])
        {
            $this->colaAtencion1 []= $this->ticket;
            $this->addTicketToCola(1);
        }
        else
        {
            $this->colaAtencion2 []= $this->ticket;
            $this->addTicketToCola(2);
        }
        $this->savingColaAtencion();
        $this->addFlash('success','El ticket fue guardado con exito.');
        return $this->redirectToRoute('ticket_index', array());
    }

    /**
     * @param Request $request
     */
    private function processDataForm(Request $request): void
    {
        $this->ticket = new Ticket();
        $this->ticket->setId($request->request->get("id",0));
        $this->ticket->setNombre($request->request->get("nombre",""));
    }

    /**
     * @return array Arreglo con el estado de los tiempos de colas.
     */
    private function comprobarColas():array
    {
        $tiempoEsperaCola = array();
        if(!isset($this->colaAtencion1))
            $this->colaAtencion1 = array();

        if(!isset($this->colaAtencion2))
            $this->colaAtencion2 = array();

        $entityManager = $this->getDoctrine()->getManager();
        $totalTicketsCola1 = $entityManager->getRepository(ColaAtencion::class)->countAllByNumberCola(1);
        $tiempoEsperaCola []= $totalTicketsCola1*2;
        $totalTicketsCola2 = $entityManager->getRepository(ColaAtencion::class)->countAllByNumberCola(2);
        $tiempoEsperaCola []= $totalTicketsCola2*3;
        return $tiempoEsperaCola;
    }

    /**
     * Guarda datos el ticket en la base de datos.
     * @param int $numeroCola
     */
    private function addTicketToCola(int $numeroCola): void
    {
        if(!isset($this->informacionAtencion))
            $this->informacionAtencion = new ColaAtencion();

        $this->informacionAtencion->setIdTicket($this->ticket->getId());
        $this->informacionAtencion->setNombre($this->ticket->getNombre());
        $this->informacionAtencion->setNumeroCola($numeroCola);
    }

    /**
     * Persistiendo la información en la base de datos.
     */
    private function savingColaAtencion():void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->informacionAtencion);
        $entityManager->flush();
    }
}