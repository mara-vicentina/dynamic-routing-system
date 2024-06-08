<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Node;

class NodeController extends Controller
{
    // Retorna todos os nós
    public function index()
    {
        return Node::all();
    }

    // Retorna uma lista paginada de nós, com um número limitado de resultados por página
    public function limited(Request $request)
    {
        $perPage = $request->get('per_page', 8);
        $nodes = Node::paginate($perPage);
        return response()->json($nodes);
    }

    // Cria um novo nó com base nos dados fornecidos na requisição e gera um endereço IP único
    public function store(Request $request)
    {
        $ipAddress = $this->generateIpAddress();
    
        $node = Node::create([
            'name' => $request->name,
            'ip_address' => $ipAddress,
            'speed' => $request->speed,
            'cost' => $request->cost,
        ]);
    
        return response()->json($node, 201);
    }

    // Atualiza um nó específico com base no ID e nos dados fornecidos na requisição
    public function update($id, Request $request)
    {    
        $node = Node::whereId($id)->update([
            'name' => $request->name,
            'speed' => $request->speed,
            'cost' => $request->cost,
        ]);
    
        return response()->json($node, 201);
    }
    
    // Gera um endereço IP único que não está em uso por outro nó
    private function generateIpAddress()
    {
        do {
            $ipAddress = long2ip(rand(0, 4294967295));
        } while (Node::where('ip_address', $ipAddress)->exists());
    
        return $ipAddress;
    }

    // Exclui um nó específico
    public function destroy(Node $node)
    {
        $node->delete();
        return response()->json(null, 204);
    }
    
}