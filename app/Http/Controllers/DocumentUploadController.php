<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadDocumentRequest;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DocumentController extends Controller
{
    public function store(UploadDocumentRequest $request)
    {
        $validated = $request->validated();
        $model_class = 'App\\Models\\' . $validated['on_type'];

        if (!class_exists($model_class)) {
            return back()->withErrors(['error' => 'Invalid model type.']);
        }

        $model = $model_class::findOrFail($validated['on_id']);
        $collection = $validated['collection'] ?? 'documents';

        foreach ($request->file('documents') as $file) {
            $model->addMedia($file)->toMediaCollection($collection);
        }

        return back()->with([
            'message' => 'Documents uploaded successfully.',
            'type'    => 'success',
        ]);
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return back()->with([
            'message' => 'Document deleted successfully.',
            'type'    => 'success',
        ]);
    }
}
