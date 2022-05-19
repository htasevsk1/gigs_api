<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGigRequest;
use App\Models\Gig;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $response = Gig::query()
            ->when($request->has('company_id'), function ($query) use ($request) {
                $query->where('company_id', '=', $request->get('company_id'));
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', '=', $request->get('status'));
            })
            ->when($request->has('progress'), function ($query) use ($request) {
                if ($request->get('progress') == Gig::NOT_STARTED) {
                    $query->where('start_time', '>', Carbon::now()->format('Y-m-d H:i:s'));
                }

                if ($request->get('progress') == Gig::STARTED) {
                    $query->where('start_time', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                        ->where('status', '=', true);
                }

                if ($request->get('progress') == Gig::FINISHED) {
                    $query->where('end_time', '<', Carbon::now()->format('Y-m-d H:i:s'))
                        ->where('status', '=', true);
                }
            })
            ->paginate();

        return response()->json($response);
    }

    public function search(Request $request)
    {
        return Gig::search($request->get('query'))
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGigRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreGigRequest $request): JsonResponse
    {
        $this->authorize('createOrModifyGig', [User::class, $request->get('company_id')]);

        DB::beginTransaction();

        $gig = Gig::create($request->only([
            'name',
            'description',
            'start_time',
            'end_time',
            'number_of_positions',
            'pay_per_hour',
            'status',
            'company_id',
        ]));

        DB::commit();

        return response()->json($gig);
    }

    /**
     * Display the specified resource.
     *
     * @param Gig $gig
     * @return JsonResponse
     */
    public function show(Gig $gig): JsonResponse
    {
        return response()->json($gig);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Gig $gig
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Gig $gig): JsonResponse
    {
        $this->authorize('createOrModifyGig', [User::class, $gig->company_id]);

        DB::beginTransaction();

        $gig->fill($request->only([
            'name',
            'description',
            'start_time',
            'end_time',
            'number_of_positions',
            'pay_per_hour',
            'status',
        ]));

        $gig->save();

        DB::commit();

        return response()->json($gig);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Gig $gig
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Gig $gig): JsonResponse
    {
        $this->authorize('createOrModifyGig', [User::class, $gig->company_id]);

        DB::beginTransaction();

        $gig->delete();

        DB::commit();

        return response()->json([
            'message' => 'Deleted'
        ]);

    }
}
