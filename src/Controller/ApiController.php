<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\ColaAtencion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Class ApiController, for 
 *
 * @author Ingeniero en computación: Ricardo Presilla.
 * @version 1.0.
 */
class ApiController extends AbstractController
{
    /**
     * @var ColaAtencion
     */
    private $informacionAtencion;
    
    /**
     * @var array
     */
    private $colaAtencion;
    
    /**
     * @Route("/api/{numeroCola}/{pag}", name="api_cola", 
     * methods={"GET","POST"}, requirements={"pag"="\d+", "numeroCola"="\d+"})
     * @param Request $request
     * @param int $pag Entero con el número de página a mostrar.
     * @param int $numeroCola Entero con el número de cola a buscar.
     * @return Response Regresa un JSon al cliente de la api.
     */
    public function index(Request $request, int $pag = 1, int $numeroCola = 1) {
        $result = array();
        $inicio = ($pag-1)*10;
        $entityManager = $this->getDoctrine()->getManager();
        $totalTicketsCola = $entityManager->getRepository(ColaAtencion::class)->countAllByNumberCola($numeroCola);
        $this->colaAtencion = $entityManager->getRepository(ColaAtencion::class)->paginarColaAtencion($inicio, 10, $numeroCola);
        $paginasCola = $this->calcularPaginasTotalesAMostrar($totalTicketsCola);
        $tiempoEsperaCola = $this->checkQueue($numeroCola);
        $result = $this->buildJsonResponse($paginasCola, $tiempoEsperaCola);
        //Response
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
     * @return array Arreglo con el estado de los tiempos de colas.
     */
    private function checkQueue(int $numeroCola = 1):int
    {
        $tiempoEsperaCola = 0;
        $entityManager = $this->getDoctrine()->getManager();
        $totalTicketsCola = $entityManager->getRepository(ColaAtencion::class)->countAllByNumberCola($numeroCola);
        if($numeroCola == 1)
        {
            $tiempoEsperaCola = $totalTicketsCola*2;
        }
        else
        {
            $tiempoEsperaCola = $totalTicketsCola*3;
        }
        return $tiempoEsperaCola;
    }
    
    /**
     * Build the json response.
     * @param int $paginasCola Entero con el número de página actual.
     * @param int $tiempoEsperaCola Entero con el tiempo de espera total de la cola.
     * @return array Arreglo con el resultado.
     */
    private function buildJsonResponse(int $paginasCola, int $tiempoEsperaCola): array 
    {
        $result = array();
        $cola = array();
        try{    
            //Preparando respuesta para la vista
            foreach ($this->colaAtencion as $node)
            {
                $ticket = array();
                $ticket['idTicket'] = $node->getIdTicket();
                $ticket['nombre'] = $node->getNombre();
                $cola []= $ticket;
            }
            $result ['colaAtencion'] = $cola;
            $result ['paginasCola'] = $paginasCola;
            $result ['tiempoEsperaCola'] = $tiempoEsperaCola;
        }catch (Exception $exception) {
            $result = [
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(), ];
        }
        return $result;
    }
}
