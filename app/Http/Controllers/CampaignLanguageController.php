<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignLanguage;
use App\Models\Language;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class CampaignLanguageController extends Controller
{
    public function index($id)
    {
        $campaign_id = $id;
        $languages = CampaignLanguage::with('language', 'campaign')->where('campaign_id', $id)->get();
        return view('admin.campaign.language.index', compact('languages', 'campaign_id'));
    }

    public function create($id)
    {
        $campaign = Campaign::findOrFail($id);
        $setting = SiteSetting::first()->language_id;
        $lang = CampaignLanguage::where('campaign_id', $id)->where('language_id', $setting)->first();
        $languages = Language::where('id', '<>',$setting)->get();
        return view('admin.campaign.language.create', compact('campaign', 'languages', 'lang'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            // 'campaign_id' => 'required',
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|max:255',
        ]);
        $campaign = Campaign::findOrFail($id);
        $campaignLanguage = CampaignLanguage::updateOrCreate(
            [
                'campaign_id' => $id,
                'language_id' => $request->language_id,
            ],
            [
                'title' => $request->title,
            ]
        );
        return redirect()->route('admin.campaign.language.index', $campaignLanguage->campaign_id)->withMessage($campaign->title . ' `s Language Added Successfully!');
    }

    public function edit($campaign_id, $id)
    {
        $campaignLanguage = CampaignLanguage::with('language', 'campaign')->findOrFail($id);
        $setting = SiteSetting::first()->language_id;
        $lang = CampaignLanguage::where('campaign_id', $id)->where('language_id', $setting)->first();
        $languages = Language::all();
        $campaign = Campaign::findOrFail($campaign_id);
        return view('admin.campaign.language.edit', compact('campaignLanguage', 'languages', 'campaign', 'lang'));
    }

    public function update(Request $request, $campaign_id, $id)
    {
        $request->validate([
            // 'campaign_id' => 'required',
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|max:255',
        ]);

        $campaignLanguage = CampaignLanguage::findOrFail($id);
        $campaignLanguage->update($request->all());
        $campaign = Campaign::findOrFail($campaign_id);
        return redirect()->route('admin.campaign.language.index', $campaignLanguage->campaign_id)->withMessage($campaign->title . ' `s Language Updated Successfully!');
    }

    public function destroy($campaign_id, $id)
    {
        $campaignLanguage = CampaignLanguage::findOrFail($id);
        $campaignLanguage->delete();
        $campaign = Campaign::findOrFail($campaign_id);
        return redirect()->route('admin.campaign.language.index', $campaignLanguage->campaign_id)->withMessage($campaign->title . ' `s Language Deleted Successfully!');
    }
}
