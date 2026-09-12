<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as DocumentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RequestController extends Controller
{
    private const STATUSES = ['Pending', 'Ready for Pickup', 'Completed', 'Cancelled'];

    public function index(Request $request): View
    {
        $query = DocumentRequest::with('document')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($builder) use ($search) {
                $like = '%'.$search.'%';
                $builder->where('request_id', 'like', $like)
                    ->orWhere('requester_name', 'like', $like)
                    ->orWhere('contact_number', 'like', $like)
                    ->orWhereHas('document', function ($doc) use ($like) {
                        $doc->where('document_id', 'like', $like)->orWhere('session_name', 'like', $like);
                    });
            });
        }

        $requests = $query->paginate(10)->withQueryString();

        return view('admin.requests.index', [
            'requests' => $requests,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, DocumentRequest $documentRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', self::STATUSES)],
            'fee'    => ['nullable', 'numeric', 'min:0'],
            'notes'  => ['nullable', 'string', 'max:2000'],
        ]);

        $updates = [
            'status' => $validated['status'],
            'fee' => $validated['fee'] ?? $documentRequest->fee,
            'notes' => $validated['notes'] ?? $documentRequest->notes,
            'processed_by' => $request->user()->id,
            'processed_at' => now(),
        ];

        if ($validated['status'] === 'Pending') {
            $updates['processed_by'] = null;
            $updates['processed_at'] = null;
        }

        $documentRequest->update($updates);

        // Send SMS Notification via Semaphore API
        try {
            $feeMessage = $documentRequest->fee ? " Expected fee: PHP " . number_format($documentRequest->fee, 2) . "." : "";
            
            Http::post('https://api.semaphore.co/api/v4/messages', [
                'apikey'  => env('SEMAPHORE_API_KEY'),
                'number'  => $documentRequest->contact_number,
                'message' => "Bontoc SB Portal: Your request ({$documentRequest->request_id}) status has been updated to '{$documentRequest->status}'.{$feeMessage}"
            ]);
        } catch (\Exception $e) {
            \Log::error('SMS Failed: ' . $e->getMessage());
        }

        return back()->with('success', "Request {$documentRequest->request_id} updated and notification sent.");
    }
}