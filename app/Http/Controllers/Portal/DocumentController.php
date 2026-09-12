<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::query()
            ->where('is_public', true)
            ->where('status', 'published');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($builder) use ($search) {
                $like = '%'.$search.'%';
                $builder->where('document_id', 'like', $like)
                    ->orWhere('session_name', 'like', $like)
                    ->orWhere('sponsors', 'like', $like)
                    ->orWhere('session_id', 'like', $like)
                    ->orWhere('tags', 'like', $like)
                    ->orWhere('type', 'like', $like);
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($session = trim((string) $request->input('session'))) {
            $query->where('session_id', 'like', '%'.$session.'%');
        }

        if ($sponsor = trim((string) $request->input('sponsor'))) {
            $query->where('sponsors', 'like', '%'.$sponsor.'%');
        }

        $documents = $query->latest('session_date')->latest('id')->paginate(10)->withQueryString();
        $types = DocumentType::orderBy('name')->get();

        return view('public.index', compact('documents', 'types'));
    }

    public function file(Document $document): BinaryFileResponse
    {
        abort_unless($document->is_public && $document->status === 'published' && ! $document->trashed(), 404);

        abort_unless(Storage::disk('local')->exists($document->file_path), 404);

        return response()->file(
            Storage::disk('local')->path($document->file_path),
            ['Content-Type' => $document->mime_type ?: 'application/pdf']
        );
    }
}