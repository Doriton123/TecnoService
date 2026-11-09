<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Solicitud;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Cliente::count();
        $totalEquipos = Equipo::count();
        $totalUsuarios = User::count();
        $totalSolicitudes = Solicitud::count();

        $pendientes = Solicitud::where('estado', 'Pendiente')->count();

        $enProceso = Solicitud::where('estado', 'En proceso')->count();

        $finalizadas = Solicitud::where('estado', 'Finalizada')->count();

        $ultimasSolicitudes = Solicitud::with(['cliente', 'equipo'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClientes',
            'totalEquipos',
            'totalUsuarios',
            'totalSolicitudes',
            'pendientes',
            'enProceso',
            'finalizadas',
            'ultimasSolicitudes'
        ));
    }
}
