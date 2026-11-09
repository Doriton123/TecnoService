<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $buscar = trim($request->input('buscar', ''));

        $solicitudes = Solicitud::with(['cliente', 'equipo'])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('numero_solicitud', 'like', "%{$buscar}%")
                        ->orWhereHas('cliente', function ($c) use ($buscar) {
                            $c->where('nombre_completo', 'like', "%{$buscar}%");
                        })
                        ->orWhereHas('equipo', function ($e) use ($buscar) {
                            $e->where('marca', 'like', "%{$buscar}%")
                                ->orWhere('modelo', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($request->filled('estado'), function ($query) use ($request) {
                $query->where('estado', $request->estado);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('solicitudes.index', compact('solicitudes', 'buscar'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre_completo')->get();

        $equipos = Equipo::orderBy('marca')
            ->orderBy('modelo')
            ->get();

        return view('solicitudes.create', compact('clientes', 'equipos'));
    }

    public function store(Request $request)
    {
        $datos = $this->validarDatos($request);

        DB::transaction(function () use ($datos) {
            // Serializar la generación del número mediante un bloqueo
            // de una fila estable de la tabla users.
            DB::table('users')
                ->orderBy('id')
                ->lockForUpdate()
                ->first();

            $ultimoId = Solicitud::max('id') ?? 0;

            // El número usa un UUID para garantizar unicidad incluso
            // si se eliminan registros o hay solicitudes concurrentes.
            $numero = 'SOL-' . strtoupper(substr(
                str_replace('-', '', (string) \Illuminate\Support\Str::uuid()),
                0,
                12
            ));

            Solicitud::create([
                ...$datos,
                'numero_solicitud' => $numero,
                'estado' => 'Pendiente',
            ]);
        });

        return redirect()
            ->route('solicitudes.index')
            ->with('success', 'Solicitud registrada correctamente.');
    }


    public function show(Solicitud $solicitud)
    {
        $solicitud->load([
            'cliente',
            'equipo',
            'historialEstados.usuario'
        ]);

        return view('solicitudes.show', compact('solicitud'));
    }



    public function edit(Solicitud $solicitud)
    {
        abort_unless(
            auth()->user()->hasRole('Administrador'),
            403
        );

        if ($solicitud->estado === 'Finalizada') {
            return redirect()
                ->route('solicitudes.show', $solicitud)
                ->with('error', 'No puedes editar una solicitud finalizada.');
        }

        $clientes = Cliente::orderBy('nombre_completo')->get();

        $equipos = Equipo::orderBy('marca')
            ->orderBy('modelo')
            ->get();

        return view('solicitudes.edit', compact(
            'solicitud',
            'clientes',
            'equipos'
        ));
    }



    public function update(Request $request, Solicitud $solicitud)
    {
        abort_unless(
            auth()->user()->hasRole('Administrador'),
            403
        );

        if ($solicitud->estado === 'Finalizada') {
            return redirect()
                ->route('solicitudes.show', $solicitud)
                ->with('error', 'No puedes modificar una solicitud finalizada.');
        }

        $datos = $this->validarDatos($request);

        $solicitud->update($datos);

        return redirect()
            ->route('solicitudes.show', $solicitud)
            ->with('success', 'Solicitud actualizada correctamente.');
    }


    private function validarDatos(Request $request): array
    {
        return $request->validate([
            'cliente_id' => [
                'required',
                'exists:clientes,id',
            ],
            'equipo_id' => [
                'required',
                Rule::exists('equipos', 'id')
                    ->where('cliente_id', $request->cliente_id),
            ],
            'fecha_recepcion' => 'required|date',
            'tipo_servicio' => [
                'required',
                Rule::in(['Mantenimiento', 'Reparación']),
            ],
            'descripcion_problema' => 'required|string|max:5000',
            'observaciones' => 'nullable|string|max:5000',
        ], [
            'equipo_id.exists' => 'El equipo seleccionado no pertenece al cliente indicado.',
        ]);
    }
}
