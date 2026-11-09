<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReporteController extends Controller
{
    private function validarFiltros(Request $request): array
    {
        return $request->validate([
            'estado' => [
                'nullable',
                Rule::in(['Pendiente', 'En proceso', 'Finalizada']),
            ],
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
    }

    private function consultarSolicitudes(array $filtros)
    {
        return Solicitud::with(['cliente', 'equipo'])
            ->when(
                !empty($filtros['estado']),
                fn($q) => $q->where('estado', $filtros['estado'])
            )
            ->when(
                !empty($filtros['fecha_inicio']),
                fn($q) => $q->whereDate(
                    'fecha_recepcion',
                    '>=',
                    $filtros['fecha_inicio']
                )
            )
            ->when(
                !empty($filtros['fecha_fin']),
                fn($q) => $q->whereDate(
                    'fecha_recepcion',
                    '<=',
                    $filtros['fecha_fin']
                )
            )
            ->orderBy('fecha_recepcion')
            ->orderBy('id');
    }

    public function index(Request $request)
    {
        $filtros = $this->validarFiltros($request);

        $solicitudes = $this->consultarSolicitudes($filtros)
            ->paginate(10)
            ->withQueryString();

        $total = $this->consultarSolicitudes($filtros)->count();

        return view('reportes.index', compact(
            'solicitudes',
            'filtros',
            'total'
        ));
    }

    public function pdf(Request $request)
    {
        $filtros = $this->validarFiltros($request);

        $solicitudes = $this->consultarSolicitudes($filtros)->get();

        $resumen = [
            'total' => $solicitudes->count(),
            'pendientes' => $solicitudes->where('estado', 'Pendiente')->count(),
            'en_proceso' => $solicitudes->where('estado', 'En proceso')->count(),
            'finalizadas' => $solicitudes->where('estado', 'Finalizada')->count(),
        ];

        $pdf = Pdf::loadView('reportes.pdf', [
            'solicitudes' => $solicitudes,
            'filtros' => $filtros,
            'resumen' => $resumen,
            'fechaGeneracion' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download(
            'Reporte_TecnoService_' . now()->format('Ymd_His') . '.pdf'
        );
    }
}
