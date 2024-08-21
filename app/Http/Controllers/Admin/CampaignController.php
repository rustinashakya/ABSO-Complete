<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Models\CampaignLanguage;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CampaignController extends Controller
{
    protected $updateCampaignService;
    protected $storeCampaignService;

    public function __construct()
    {
        $this->middleware('role_or_permission:Campaign access', ['only' => ['index', 'view']]);
        $this->middleware('role_or_permission:Campaign edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Campaign create', ['only' => ['add', 'store']]);
        $this->middleware('role_or_permission:Campaign delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the Campaign.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::orderBy('id', 'desc')->paginate(10);

        // $campaigns = DB::table('campaigns')
        //     ->select('campaigns.*', 'campaign_languages.title as title')
        //     ->join('campaign_languages', 'campaigns.id', '=', 'campaign_languages.campaign_id')
        //     ->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }

    public function add()
    {
        return view('admin.campaign.create');
    }

    public function store(StoreCampaignRequest $request)
    {
        // dd($request->all());
        try {
            $time = time();

            $campaign = new Campaign();
            $campaign->title = $request->title;
            $campaign->url = $request->url;
            $campaign->status = $request->status ?? 0;
            $campaign->save();


            $title = $request->title;
            $language_id = SiteSetting::first()->language_id;
            CampaignLanguage::updateOrCreate([
                'campaign_id' => $campaign->id,
                'language_id' => $language_id,
            ], [
                'title' => $title
            ]);


            if ($request->images) {
                foreach ($request->images as $image) {
                    // dd($image->getClientOriginalName());
                    $filenamewithextension = $image->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $image->getClientOriginalExtension();
                    //filename to store
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $image;
                    $originalPath = public_path() . '/storage/uploads/campaign/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/campaign/main_image/thumbnail/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }

                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);
                    }
                    $categoryImage = Image::make($main_image);
                    $categoryImage->backup();

                    $categoryImage->save($originalPath . $filename_to_store);
                    $main_image = $filename_to_store;


                    $categoryImage->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $admin, 90);
                    $categoryImage->reset();

                    $campaign->images()->create([
                        'main_image' => $main_image
                    ]);
                }
            }

            $message = 'Campaign Created Successfuly!';
            //return to a index page of campaign
            return redirect()->route('admin.campaign.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * View a data of the campaign.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaign.show', compact('campaign'));
    }


    public function edit($id)
    {
        $campaign = DB::table('campaigns')
            ->select('campaigns.*', 'campaign_languages.title as title', DB::raw('GROUP_CONCAT(campaign_images.main_image) as images'))
            ->join('campaign_languages', 'campaigns.id', '=', 'campaign_languages.campaign_id')
            ->leftJoin('campaign_images', 'campaigns.id', '=', 'campaign_images.campaign_id')
            ->where('campaigns.id', $id)
            ->groupBy('campaigns.id', 'campaign_languages.title') // Adjust with actual columns from campaigns table
            ->first();

        // dd($campaign);
        return view('admin.campaign.edit', compact('campaign'));
    }


    public function update(UpdateCampaignRequest $request, $id)
    {
        // dd($request->all());
        try {
            $time = time();
            $campaign = Campaign::findOrFail($id);
            // $campaign->title = $request->title;
            $campaign->url = $request->url;
            $campaign->status = $request->status ?? 0;
            $campaign->save();

            $title = $request->title;
            $language_id = SiteSetting::first()->language_id;
            CampaignLanguage::updateOrCreate([
                'campaign_id' => $campaign->id,
                'language_id' => $language_id,
            ], [
                'title' => $title
            ]);

            if ($request->images) {
                foreach ($request->images as $image) {
                    foreach ($campaign->images as $key => $value) {
                        Storage::delete('public/uploads/campaign/main_image/' . $value->main_image);
                        Storage::delete('public/uploads/campaign/main_image/thumbnail/admin_' . $value->main_image);
                    }
                    // dd($image->getClientOriginalName());
                    $filenamewithextension = $image->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $image->getClientOriginalExtension();
                    //filename to store
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $image;
                    $originalPath = public_path() . '/storage/uploads/campaign/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/campaign/main_image/thumbnail/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }

                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);
                    }
                    $categoryImage = Image::make($main_image);
                    $categoryImage->backup();

                    $categoryImage->save($originalPath . $filename_to_store);
                    $main_image = $filename_to_store;


                    $categoryImage->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $admin, 90);
                    $categoryImage->reset();

                    $campaign->images()->update([
                        'main_image' => $main_image
                    ]);
                }
            }
            $message = 'Campaign Updated Successfuly!';
            //return to a index page of campaign
            return redirect()->route('admin.campaign.index')->withMessage($message);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();
        $message = 'Campaign Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }
}
