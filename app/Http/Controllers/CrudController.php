<?php

namespace App\Http\Controllers;

use App\Services\Contracts\CrudServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class CrudController extends Controller
{
    protected CrudServiceInterface $service;

    public function __construct(CrudServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $columns = $request->get('columns', ['*']);
        
        $data = $perPage ? $this->service->paginate($perPage, $columns) : $this->service->all($columns);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getSelect(Request $request): JsonResponse
    {
        $columns = $request->get('columns', ['id', 'name']);
        $data = $this->service->getSelect($columns);
        
        return response()->json([
            'success' => true,
            'message' => 'Select options retrieved successfully',
            'data' => $data
        ]);
    }

    public function show(int $id, Request $request): JsonResponse
    {
        $columns = $request->get('columns', ['*']);
        $data = $this->service->find($id, $columns);
        
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->service->create($request->all());
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Resource created successfully'
        ], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $data = $this->service->update($id, $request->all());
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Resource updated successfully'
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        
        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully'
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $data = $this->service->restore($id);
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Resource restored successfully'
        ]);
    }

    protected function getService(): CrudServiceInterface
    {
        return $this->service;
    }
}
