<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = Company::query()
            ->paginate();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @return JsonResponse
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        DB::beginTransaction();

        $company = Company::create(array_merge(
            $request->only('name', 'description', 'address'),
            ['user_id' => Auth::id()]
        ));

        DB::commit();

        return response()->json($company);
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function show(Company $company): JsonResponse
    {
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $this->authorize('updateOrDeleteCompany', [User::class, $company->id]);

        DB::beginTransaction();

        $company->fill($request->only(['name', 'description', 'address']));
        $company->save();

        DB::commit();

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Company $company): JsonResponse
    {
        $this->authorize('updateOrDeleteCompany', [User::class, $company->id]);

        DB::beginTransaction();

        $company->gigs()->delete();
        $company->delete();

        DB::commit();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}
