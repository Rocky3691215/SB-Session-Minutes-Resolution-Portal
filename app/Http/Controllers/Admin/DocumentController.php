<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Services\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::withTrashed()->latest('id');

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

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $documents = $query->paginate(10)->withQueryString();
        $types = DocumentType::orderBy('name')->get();

        return view('admin.documents.index', compact('documents', 'types'));
    }

    public function create(): View
    {
        $types = DocumentType::orderBy('name')->get();
        return view('admin.documents.create', compact('types'));
    }

    public function store(Request $request, DocumentService $service): RedirectResponse
    {
        $validated = $request->validate([
            'session_name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'session_id' => ['nullable', 'string', 'max:100'],
            'session_date' => ['required', 'date'],
            'sponsors' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:1000'],
            'is_public' => ['nullable', 'boolean'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $validated['is_public'] = $request->boolean('is_public');

        $file = $request->file('pdf');
        $docId = 'DOC-' . str_pad(Document::count() + 1, 3, '0', STR_PAD_LEFT);
        $filename = $docId . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/'.date('Y/m'), $filename, 'local');

        $validated['document_id'] = $docId;
        $validated['file_path'] = $path;
        $validated['filename'] = $filename;
        $validated['status'] = 'published';

        unset($validated['pdf']);

        $document = Document::create($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', "{$document->document_id} was uploaded successfully.");
    }

    public function edit($id): View
    {
        $document = Document::withTrashed()->findOrFail($id);
        $types = DocumentType::orderBy('name')->get();
        return view('admin.documents.edit', compact('document', 'types'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $document = Document::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'document_type_id' => ['required', 'string', 'max:100'],
            'session_number'   => ['nullable', 'string', 'max:100'],
            'document_date'    => ['required', 'date'],
            'author'           => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:1000'],
            'status'           => ['required', 'in:published,archived'],
            'is_public'        => ['nullable', 'boolean'],
            'pdf'              => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($validated['status'] === 'published' && $document->trashed()) {
            $document->restore();
        }

        $newPath = null;
        $oldPath = $document->file_path;
        $filename = $document->filename;

        if ($request->hasFile('pdf')) {
            $newPath = $request->file('pdf')->store('documents/'.date('Y/m'), 'local');
            $filename = $request->file('pdf')->getClientOriginalName();
        }

        try {
            $document->update([
                'session_name' => $validated['title'],
                'type'         => $validated['document_type_id'],
                'session_id'   => $validated['session_number'],
                'session_date' => $validated['document_date'],
                'sponsors'     => $validated['author'],
                'tags'         => $validated['tags'] ?? null,
                'status'       => $validated['status'],
                'is_public'    => $request->boolean('is_public'),
                ...($newPath ? [
                    'file_path' => $newPath,
                    'filename'  => $filename
                ] : [])
            ]);

            if ($newPath && $oldPath !== $newPath) {
                Storage::disk('local')->delete($oldPath);
            }
        } catch (\Throwable $e) {
            if ($newPath) {
                Storage::disk('local')->delete($newPath);
            }
            throw $e;
        }

        return redirect()->route('admin.documents.index')
            ->with('success', "{$document->document_id} was updated.");
    }

    public function destroy(Document $document): RedirectResponse
    {
        $document->update(['status' => 'archived', 'is_public' => false]);
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', "{$document->document_id} was archived from the active list.");
    }

    public function file($id): BinaryFileResponse
    {
        $document = Document::withTrashed()->findOrFail($id);
        
        abort_unless(Storage::disk('local')->exists($document->file_path), 404);

        return response()->file(
            Storage::disk('local')->path($document->file_path),
            ['Content-Type' => 'application/pdf']
        );
    }
}