<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request as DocumentRequest; // Aliased to avoid conflict with Illuminate\Http\Request
use App\Models\Document;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    // 1. Show Request Form and pass documents list
    public function create(Request $request)
    {
        $document = null;
        if ($docId = $request->input('document')) {
            $document = Document::where('document_id', $docId)->first();
        }

        $documents = Document::where('is_public', true)
            ->where('status', 'published')
            ->orderBy('session_name')
            ->get();

        return view('public.requests.create', compact('document', 'documents'));
    }

    // 2. Handle the Submission & SMS
    public function store(Request $request)
    {
        // Validate the incoming public request
        $request->validate([
            'requester_name' => 'required|string|max:255',
            'contact_number' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'document_id'    => 'required|string',
            'copies'         => 'required|integer|min:1',
            'reason'         => 'required|string|max:255',
            'pickup_date'    => 'required|date',
            'valid_id'       => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        // Save the Valid ID image if uploaded
        $idPath = null;
        if ($request->hasFile('valid_id')) {
            $idPath = $request->file('valid_id')->store('valid_ids', 'public');
        }

        // Save the request to the database
        $newRequest = DocumentRequest::create([
            'request_id'     => 'REQ-' . time(),
            'requester_name' => $request->requester_name,
            'contact_number' => $request->contact_number,
            'document_id'    => $request->document_id,
            'copies'         => $request->copies,
            'reason'         => $request->reason,
            'pickup_date'    => $request->pickup_date,
            'valid_id_path'  => $idPath,
            'status'         => 'Pending'
        ]);

        // Send SMS Notification via Semaphore
        try {
            Http::post('https://api.semaphore.co/api/v4/messages', [
                'apikey'  => env('SEMAPHORE_API_KEY'),
                'number'  => $request->contact_number,
                'message' => "Bontoc SB Portal: Your request ({$newRequest->request_id}) has been received. We will notify you once it is ready for pickup."
            ]);
        } catch (\Exception $e) {
            \Log::error('SMS Failed: ' . $e->getMessage());
        }

        return redirect()->route('public.requests.success', $newRequest->id);
    }

    // 3. Show Tracking Form
    public function trackingForm()
    {
        return view('public.requests.track');
    }

    // 4. Handle Tracking Search
    public function track(Request $request)
    {
        $request->validate(['request_id' => 'required|string']);
        
        $documentRequest = DocumentRequest::where('request_id', $request->request_id)->first();
        
        return view('public.requests.track', compact('documentRequest'));
    }

    public function index(Request $request)
    {
        $requests = DocumentRequest::with('document')
            ->latest('id')
            ->paginate(10);

        return view('public.requests.index', compact('requests'));
    }

    // Cancel Request
    public function cancel(DocumentRequest $request)
    {
        if ($request->status === 'Pending') {
            $request->update(['status' => 'Cancelled']);
            
            try {
                Http::post('https://api.semaphore.co/api/v4/messages', [
                    'apikey'  => env('SEMAPHORE_API_KEY'),
                    'number'  => $request->contact_number,
                    'message' => "Bontoc SB Portal: Your request ({$request->request_id}) has been cancelled."
                ]);
            } catch (\Exception $e) {
                \Log::error('SMS Failed: ' . $e->getMessage());
            }

            return back()->with('success', "Request {$request->request_id} has been cancelled.");
        }

        return back()->with('error', 'Only pending requests can be cancelled.');
    }

    // Delete Request
    public function destroy(DocumentRequest $request)
    {
        if ($request->valid_id_path && Storage::disk('public')->exists($request->valid_id_path)) {
            Storage::disk('public')->delete($request->valid_id_path);
        }

        $request->delete();

        return back()->with('success', 'Request has been removed from the list.');
    }

    // 5. Show Success Page
    public function success($id)
    {
        $request = DocumentRequest::findOrFail($id);
        
        return view('public.requests.success', compact('request'));
    }
}