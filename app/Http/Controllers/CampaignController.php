<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignCollection;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Models\Creative;
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
        // get campaigns and it's related creatives
        $campaigns = Campaign::with('creative')->get();

        // return collection of campaigns as a resource
        return response()->json(new CampaignCollection($campaigns), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'from' => 'required|date',
            'to' => 'required|date',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric',
        ]);

        // create campaign
        $campaign = Campaign::create($request->only(['name', 'from', 'to', 'total_budget', 'daily_budget']));

        // upload multiple one or multiple images/creatives for each campaign
        if ($request->hasFile('image_url')) {
            $files = $request->file('image_url');
            foreach ($files as $file) {
                $new_name = rand() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/creatives'), $new_name);
                // save to database
                Creative::create([
                    'image_url' => $new_name,
                    'campaign_id' => $campaign->id,
                ]);
            }
        }
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
        // get campaign and it's related creatives
        $campaign = Campaign::with('creative')->findOrFail($campaign->id);

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
        // validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'from' => 'required|date',
            'to' => 'required|date',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric',
        ]);

        $campaign->update($request->only(['name', 'from', 'to', 'total_budget', 'daily_budget']));

        // upload multiple one or multiple images/creatives for each campaign
        if ($request->hasFile('image_url')) {
            $files = $request->file('image_url');
            foreach ($files as $file) {
                $new_name = rand() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/creatives'), $new_name);
                // save to database

                // check this method, check the update method in laravel
                Creative::updateOrCreate([
                    'image_url' => $new_name,
                    'campaign_id' => $campaign->id,
                ]);
            }
        }
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
