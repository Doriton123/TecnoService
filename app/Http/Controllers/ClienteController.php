<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    // Listar y buscar clientes
    public function index(Request $request)
    {
        $busqueda = trim($request->input('buscar', ''));

        $clientes = Cliente::query()
            ->when($busqueda, function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre_completo', 'like', "%{$busqueda}%")
                        ->orWhere('nit', 'like', "%{$busqueda}%")
                        ->orWhere('correo_electronico', 'like', "%{$busqueda}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('clientes.index', compact('clientes', 'busqueda'));
    }

    // Formulario de registro
    public function create()
    {
        return view('clientes.create');
    }

    // Guardar cliente
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'nit' => 'required|string|max:20|unique:clientes,nit',
            'correo_electronico' => 'required|email|max:150',
        ]);

        Cliente::create($datos);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    // Mostrar información
    public function show(Cliente $cliente)
    {
        $cliente->load('equipos');

        return view('clientes.show', compact('cliente'));
    }

    // Formulario de edición
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar información
    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'nit' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clientes', 'nit')->ignore($cliente->id),
            ],
            'correo_electronico' => 'required|email|max:150',
        ]);

        $cliente->update($datos);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }
}
