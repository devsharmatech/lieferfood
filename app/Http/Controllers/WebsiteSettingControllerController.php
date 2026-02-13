<?php

namespace App\Http\Controllers;

use App\Models\home_slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class WebsiteSettingControllerController extends Controller
{
    //
    public function homeSlider()
    {
        $slides = home_slider::latest()->get();
        return view('admin.settings.home-slider', compact('slides'));
    }
    public function addNew()
    {
        return view('admin.settings.add-slide');
    }
    public function storeSlide(Request $request)
    {
        validator([
            'url' => ['nullable', 'url'],
            'image' => ['required', 'image']
        ]);
        $slide = new home_slider();
        $slide->url = $request->url;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/slides/' . $slide->image);
            $image = $manager->read($file);
            $filename = uniqid('slide_') . '.' . $file->getClientOriginalExtension();
            $image->resize(600, 400)->save(public_path('uploads/slides/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $slide->image = $filename;
        }
        $slide->save();

        return back()->with(['alert-type' => 'success', 'message' => 'Successfully created new slide.']);
    }
    public function updateSlide(Request $request)
    {
        validator([
            'id' => ['required', 'exists:home_sliders,id'],
            'url' => ['nullable', 'url'],
            'image' => ['required', 'image']
        ]);
        $slide = home_slider::where('id', $request->id)->first();
        $slide->url = $request->url;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/slides/' . $slide->image);
            $image = $manager->read($file);
            $filename = uniqid('slide_') . '.' . $file->getClientOriginalExtension();
            $image->resize(600, 400)->save(public_path('uploads/slides/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $slide->image = $filename;
        }
        $slide->save();

        return back()->with(['alert-type' => 'success', 'message' => 'Successfully update slide.']);
    }

    public function editSlide($id)
    {
        $slide = home_slider::where('id', $id)->first();
        if (!empty($slide)) {
            return view('admin.settings.edit-slide', compact('slide'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Slide not found.']);
        }
    }

    public function delete($id)
    {
        $id = auth()->user()->id;
        $home_slider = home_slider::where('id', $id)->first();

        if (!empty($home_slider)) {
            $oldPath = public_path('uploads/slides/' . $home_slider->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $home_slider->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Slide deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Slide not found!']);
        }
    }
}
