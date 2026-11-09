<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    // Listar y buscar equipos
    public function index(Request $request)
    {
        $busqueda = trim($request->input('buscar', ''));

        $equipos = Equipo::with('cliente')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('tipo_equipo', 'like', "%{$busqueda}%")
                        ->orWhere('marca', 'like', "%{$busqueda}%")
                        ->orWhere('modelo', 'like', "%{$busqueda}%")
                        ->orWhere('numero_serie', 'like', "%{$busqueda}%")
                        ->orWhereHas('cliente', function ($cliente) use ($busqueda) {
                            $cliente->where('nombre_completo', 'like', "%{$busqueda}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('equipos.index', compact('equipos', 'busqueda'));
    }

    // Formulario para registrar equipo
    public function create()
    {
        $clientes = Cliente::orderBy('nombre_completo')->get();

        return view('equipos.create', compact('clientes'));
    }

    // Guardar equipo
    public function store(Request $request)
    {
        $datos = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_equipo' => 'required|string|max:100',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'numero_serie' => 'nullable|string|max:150',
        ]);

        Equipo::create($datos);

        return redirect()
            ->route('admin.equipos.index')
            ->with('success', 'Equipo registrado correctamente.');
    }

    // Mostrar detalles
    public function show(Equipo $equipo)
    {
        $equipo->load(['cliente', 'solicitudes']);

        return view('equipos.show', compact('equipo'));
    }

    // Formulario para editar
    public function edit(Equipo $equipo)
    {
        $clientes = Cliente::orderBy('nombre_completo')->get();

        return view('equipos.edit', compact('equipo', 'clientes'));
    }

    // Actualizar equipo
    public function update(Request $request, Equipo $equipo)
    {
        $datos = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_equipo' => 'required|string|max:100',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'numero_serie' => 'nullable|string|max:150',
        ]);

        // Evitar cambiar el propietario si ya tiene solicitudes
        if (
            $equipo->cliente_id != $datos['cliente_id']
            && $equipo->solicitudes()->exists()
        ) {
            return back()
                ->withErrors([
                    'cliente_id' => 'No puedes cambiar el cliente de un equipo que ya tiene solicitudes registradas.'
                ])
                ->withInput();
        }

        $equipo->update($datos);

        return redirect()
            ->route('admin.equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }
}
