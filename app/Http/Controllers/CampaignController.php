<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignCollection;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(new CampaignCollection(Campaign::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campaign = Campaign::create($request->only(['name', 'from', 'to', 'total_budget', 'daily_budget']));

        return response()->json(new CampaignResource($campaign), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return response()->json(new CampaignResource($campaign), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $campaign->update($request->only(['name', 'from', 'to', 'total_budget', 'daily_budget']));

        return response()->json(new CampaignResource($campaign), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
