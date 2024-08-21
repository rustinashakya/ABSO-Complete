<?php
namespace App\Services;

use App\Models\Campaign;
use Intervention\Image\Facades\Image;

class UpdateCampaignService
{
    public function updateCampaign($request, $id)
    {
        // dd($request->all());
        $campaign = Campaign::findOrFail($id);
        // Campaign::where('status', '1')->update(['status' => '0']);

        $filename_to_store_main = $campaign->main_image;
        if ($request->hasFile('main_image')) {
            $filename_to_store_main = $this->storeImage($request->file('main_image'), 'uploads/main_image/');
        }

        $filename_to_store_mobile = $campaign->mobile_image;
        if ($request->hasFile('mobile_image')) {
            $filename_to_store_mobile = $this->storeImage($request->file('mobile_image'), 'uploads/mobile_image/');
        }

        $filename_to_store_pdf = $campaign->pdf_link;
        if ($request->hasFile('pdf_file')) {
            $filename_to_store_pdf = $this->storePdf($request->file('pdf_file'), 'uploads/pdf_image/');
        }

        $data = [
            'status' => $request->status,
            'main_image' => $request->type == 'image' ? $filename_to_store_main : '',
            'mobile_image' => $request->type == 'image' ? $filename_to_store_mobile : '',
            'pdf_link' => $request->type == 'image' ? $filename_to_store_pdf : '',
            'type' => $request->type,
            'title' => $request->title,
            'utube_link' => $request->type == 'youtube' ? $request->youtube_link : '',
        ];

        $campaign->update($data);
      
    }

    private function storeImage($file, $path)
    {
        $filenamewithextension = $file->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename_to_store = $filename . '_' . time() . '.' . $extension;

        $image = Image::make($file);
        $originalPath = public_path() . '/storage/' . $path;
        $image->save($originalPath . $filename_to_store);
        $image->save($originalPath . 'small_' . $filename . '_' . time() . '.' . $extension);
        $image->resize(830, 350);
        $image->save($originalPath . 'medium_' . $filename . '_' . time() . '.' . $extension);
        $image->resize(1043, 1043);
        $image->save($originalPath . 'large_' . $filename . '_' . time() . '.' . $extension);
        $image->resize(1043, 1043);

        return $filename_to_store;
    }

    private function storePdf($file, $path)
    {
        $filenamewithextension = $file->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $filename_to_store = $filename . '_' . time() . '.' . $file->extension();

        $file->move(public_path('/storage/' . $path), $filename_to_store);

        return $filename_to_store;
    }
}
