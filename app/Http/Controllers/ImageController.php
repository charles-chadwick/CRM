<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Upload an image to a polymorphic model.
     */
    public function upload(UploadImageRequest $request)
    {
        $validated = $request->validated();

        $model_class = 'App\\Models\\' . $validated['on_type'];

        if (!class_exists($model_class)) {
            return back()->withErrors(['error' => 'Invalid model type.']);
        }

        $model = $model_class::findOrFail($validated['on_id']);

        if ($request->hasFile('image')) {
            $collection = $validated['image_type'];

            // Clear existing media in the collection if needed
            $model->clearMediaCollection($collection);

            // Add the new image
            $model->addMediaFromRequest('image')
                  ->toMediaCollection($collection);
        }

        return back()->with([
            'message' => 'Image uploaded successfully.',
            'type' => 'success'
        ]);
    }

    /**
     * Remove an image from a polymorphic model.
     */
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'on_type' => 'required|string',
            'on_id' => 'required',
        ]);

        $model_class = 'App\\Models\\' . $validated['on_type'];

        if (!class_exists($model_class)) {
            return back()->withErrors(['error' => 'Invalid model type.']);
        }

        $model = $model_class::findOrFail($validated['on_id']);

        // Clear all media in the images collection
        $model->clearMediaCollection($request->input('image_type'));

        return back()->with([
            'message' => 'Image removed successfully.',
            'type' => 'success'
        ]);
    }
}
