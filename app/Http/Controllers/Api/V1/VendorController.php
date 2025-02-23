<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Vendor\StoreVendorRequest;
use App\Http\Requests\Api\V1\Vendor\UpdateVendorRequest;
use App\Http\Resources\Api\V1\VendorResource;
use App\Services\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function index()
    {
        try {
            $vendors = $this->vendorService->getAll();

            return ResponseFormatter::success(
                data: VendorResource::collection($vendors),
                message: 'Vendors retrieved successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Get vendors error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to retrieve vendors',
                code: 500
            );
        }
    }

    public function store(StoreVendorRequest $request)
    {
        try {
            $vendor = $this->vendorService->create($request->validated());

            return ResponseFormatter::success(
                data: new VendorResource($vendor),
                message: 'Vendor created successfully',
                code: 201
            );
        } catch (\Exception $e) {
            Log::error('Create vendor error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: 400
            );
        }
    }

    public function show($id)
    {
        try {
            $vendor = $this->vendorService->find($id);

            return ResponseFormatter::success(
                data: new VendorResource($vendor),
                message: 'Vendor retrieved successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Get vendor error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: 404
            );
        }
    }

    public function update(UpdateVendorRequest $request, $id)
    {
        try {
            $vendor = $this->vendorService->update($id, $request->validated());

            return ResponseFormatter::success(
                data: new VendorResource($vendor),
                message: 'Vendor updated successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Update vendor error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: $e->getMessage() === 'Vendor not found' ? 404 : 400
            );
        }
    }

    public function destroy($id)
    {
        try {
            $this->vendorService->delete($id);

            return ResponseFormatter::success(
                message: 'Vendor deleted successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Delete vendor error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: $e->getMessage() === 'Vendor not found' ? 404 : 500
            );
        }
    }
}
