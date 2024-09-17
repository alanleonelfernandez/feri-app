<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar una lista de productos con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = Producto::with('categoria');

        //Aplicar filtros en index
        if ($request->filled('sku')) {
            $query->where('sku', 'like', '%' . $request->sku . '%');
        }

        if ($request->filled('descripcion')) {
            $query->where('descripcion', 'like', '%' . $request->descripcion . '%');
        }

        if ($request->filled('id_categoria')) {
            $query->where('id_categoria', $request->id_categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        //Obtener resultados paginados(10 por página)
        $productos = $query->paginate(10)->appends($request->all());

        //Obtener todas las categorías para el filtro
        $categorias = Categoria::all();

        return view('productos.index', compact('productos', 'categorias'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $productos = Producto::where('descripcion', 'LIKE', "%{$query}%")
            ->where('stock', '>', 0)
            ->get();

        $output = '';

        if (count($productos) > 0) {
            foreach ($productos as $producto) {
                $output .= '
                    <div>
                        <button type="button" class="agregar-producto" 
                                data-id="' . $producto->id . '"
                                data-nombre="' . $producto->descripcion . '"
                                data-stock="' . $producto->stock . '">
                            ' . $producto->descripcion . ' (Stock: ' . $producto->stock . ')
                        </button>
                    </div>
                ';
            }
        } else {
            $output .= '<p>No se encontraron productos</p>';
        }

        return $output;
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $categorias = Categoria::where('estado', 1)->get();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Almacenar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        //Validar los datos de entrada
        $request->validate([
            'sku' => 'required|string|max:255|unique:productos,sku',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id',
            'marca' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'costo' => 'required|numeric|min:0',
            'precio_ml' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'link_imagen' => 'nullable|url',
            'estado' => 'required|boolean',
        ]);

        //Crear el producto
        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar el formulario para editar un producto existente.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('estado', 1)->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualizar un producto existente en la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        //Validar los datos de entrada
        $request->validate([
            'sku' => 'required|string|max:255|unique:productos,sku,' . $producto->id,
            'descripcion' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id',
            'marca' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'costo' => 'required|numeric|min:0',
            'precio_ml' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'link_imagen' => 'nullable|url',
            'estado' => 'required|boolean',
        ]);

        //Actualizar el producto
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar un producto de la base de datos.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function obtenerProductos()
    {
        $productos = Producto::orderBy('descripcion', 'asc')->get(['id', 'descripcion', 'sku', 'precio_venta', 'stock']);
        return response()->json($productos);
    }
}