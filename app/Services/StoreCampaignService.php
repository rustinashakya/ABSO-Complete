<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class StoreCampaignService
{
    /**
     * Create a new campaign.
     *
     * @param  array  $data
     * @param  UploadedFile|null  $main_image
     * @param  UploadedFile|null  $mobile_image
     * @param  UploadedFile|null  $pdf_file
     * @return Campaign
     */
    public function create(array $data, ?UploadedFile $main_image = null, ?UploadedFile $mobile_image = null, ?UploadedFile $pdf_file = null): Campaign
    {
        // Update the status of campaigns to 0 before inserting new data
        Campaign::where('status', '1')->update(['status' => '0']);

        // Create a new campaign object
        $campaign = new Campaign();

        // Upload and save main image
        if ($main_image) {
            $filename_to_store = $this->generateFilename($main_image);
            $path = public_path('storage/uploads/main_image/');
           
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
        
        // retry storing the file in newly created path.
            }
            $categoryImage = Image::make($main_image);
            $categoryImage->save($path . $filename_to_store);
            $categoryImage->save($path . 'small_' . $filename_to_store)->resize(830, 350);
            $categoryImage->save($path . 'medium_' . $filename_to_store)->resize(1043, 1043);
            $categoryImage->save($path . 'large_' . $filename_to_store)->resize(1043, 1043);

            $campaign->main_image = $filename_to_store;
        }

        // Upload and save mobile image
        if ($mobile_image) {
            $filename_to_store = $this->generateFilename($mobile_image);
            $path = public_path('storage/uploads/mobile_image/');
            if(!File::isDirectory($path)){
                File::makeDirectory($originalPath, 0777, true, true);
        
        // retry storing the file in newly created path.
             }
            $categoryImage = Image::make($mobile_image);
            $categoryImage->save($path . $filename_to_store);
            $categoryImage->save($path . 'small_' . $filename_to_store)->resize(200, 200);
            $categoryImage->save($path . 'medium_' . $filename_to_store)->resize(280, 280);
            $categoryImage->save($path . 'large_' . $filename_to_store)->resize(445, 445);

            $campaign->mobile_image = $filename_to_store;
        }

        // Upload and save PDF file
        if ($pdf_file) {
            $filename_to_store = $this->generateFilename($pdf_file);
            $path = public_path('storage/uploads/pdf_image/');

            $pdf_file->move($path, $filename_to_store);
            $campaign->pdf_link = $filename_to_store;
        }

        // Map request data to database columns
        $campaign->status = $data['status'];
        $campaign->type = $data['type'];
        $campaign->title = $data['title'];
        $campaign->utube_link = $data['youtube_link'];

        // Save to database
        $campaign->save();

        return $campaign;
    }

    /**
     * Generate a unique filename.
     *
     * @param  UploadedFile  $file
     * @return string
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename= Str::slug($filename) . '_' . uniqid() . '.' . $extension;
        return $filename;
    }
}
