<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Connection;

class ConnectionController extends Controller
{
    // Retorna todas as conexões, incluindo os nós de origem e destino
    public function index()
    {
        return Connection::with(['fromNode', 'toNode'])->get();
    }

    // Retorna uma lista paginada de conexões, com um número limitado de resultados por página
    public function limited(Request $request)
    {
        $perPage = $request->get('per_page', 8);
        $connections = Connection::with(['fromNode', 'toNode'])->paginate($perPage);
        return response()->json($connections);
    }

    // Cria uma nova conexão com base nos dados fornecidos na requisição
    public function store(Request $request)
    {
        $connection = Connection::create($request->all());
        return response()->json($connection, 201);
    }

    // Exclui uma conexão específica
    public function destroy(Connection $connection)
    {
        $connection->delete();
        return response()->json(null, 204);
    }

}
