<?php

namespace App\Controller;

use App\Repository\LibroRepository;
use App\Repository\AutorRepository;
use App\Repository\PrestamoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        LibroRepository $libroRepository,
        AutorRepository $autorRepository,
        PrestamoRepository $prestamoRepository
    ): Response
    {
        // Obtener estadísticas para el dashboard
        $totalLibros = count($libroRepository->findAll());
        $totalAutores = count($autorRepository->findAll());
        $totalPrestamos = count($prestamoRepository->findAll());
        
        // Libros disponibles
        $librosDisponibles = count($libroRepository->findBy(['disponible' => true]));
        
        // Préstamos activos (sin fecha de devolución)
        $prestamosActivos = count($prestamoRepository->findBy(['fechaDevolucion' => null]));

        return $this->render('dashboard/index.html.twig', [
            'total_libros' => $totalLibros,
            'total_autores' => $totalAutores,
            'total_prestamos' => $totalPrestamos,
            'libros_disponibles' => $librosDisponibles,
            'prestamos_activos' => $prestamosActivos,
        ]);
    }
}