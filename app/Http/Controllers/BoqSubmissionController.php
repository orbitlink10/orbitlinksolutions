<?php

namespace App\Http\Controllers;

use App\Models\BoqSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoqSubmissionController extends Controller
{
    public function show()
    {
        $projectTypes = $this->projectTypes();

        return view('theme.' . get_option('theme') . '.send_boq', compact('projectTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:40'],
            'project_location' => ['required', 'string', 'max:255'],
            'project_type' => ['required', 'string', 'in:' . implode(',', $this->projectTypes())],
            'required_delivery_date' => ['nullable', 'date'],
            'budget_range' => ['nullable', 'string', 'max:120'],
            'preferred_brands' => ['nullable', 'string', 'max:1000'],
            'requirements' => ['nullable', 'string', 'max:5000', 'required_without:boq_file'],
            'boq_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $user = Auth::user() ?: User::where('email', $validated['email'])->first();
        $filePath = null;
        $fileOriginalName = null;

        if ($request->hasFile('boq_file')) {
            $file = $request->file('boq_file');
            $filePath = $file->storeAs(
                'uploads/boqs',
                upload_file_name($file, 80, 'boq'),
                'public'
            );
            $fileOriginalName = $file->getClientOriginalName();
        }

        $boq = BoqSubmission::create([
            'reference' => $this->generateReference(),
            'user_id' => $user?->id,
            'full_name' => $validated['full_name'],
            'company' => $validated['company'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'project_location' => $validated['project_location'],
            'project_type' => $validated['project_type'],
            'required_delivery_date' => $validated['required_delivery_date'] ?? null,
            'budget_range' => $validated['budget_range'] ?? null,
            'preferred_brands' => $validated['preferred_brands'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'file_path' => $filePath,
            'file_original_name' => $fileOriginalName,
            'status' => BoqSubmission::STATUS_NEW,
        ]);

        return redirect()->route('send-boq.thank-you', $boq->reference);
    }

    public function thankYou(string $reference)
    {
        $boq = BoqSubmission::where('reference', $reference)->firstOrFail();

        return view('theme.' . get_option('theme') . '.send_boq_thank_you', compact('boq'));
    }

    public function adminIndex(Request $request)
    {
        $query = BoqSubmission::with(['user', 'assignee'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $boqs = $query->paginate(30);
        $statuses = BoqSubmission::statuses();

        return view('admin.boqs.index', compact('boqs', 'statuses'));
    }

    public function adminShow(BoqSubmission $boqSubmission)
    {
        $boqSubmission->load(['user', 'assignee']);
        $statuses = BoqSubmission::statuses();
        $salesUsers = User::whereIn('user_type', ['admin', 'editor'])->orderBy('name')->get();

        return view('admin.boqs.show', compact('boqSubmission', 'statuses', 'salesUsers'));
    }

    public function adminUpdate(Request $request, BoqSubmission $boqSubmission)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(BoqSubmission::statuses()))],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
            'quotation_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
        ]);

        $quotationPath = $boqSubmission->quotation_path;

        if ($request->hasFile('quotation_file')) {
            $file = $request->file('quotation_file');
            $quotationPath = $file->storeAs(
                'uploads/boq-quotations',
                upload_file_name($file, 80, 'quote'),
                'public'
            );
        }

        $boqSubmission->forceFill([
            'status' => $validated['status'],
            'assigned_to' => $validated['assigned_to'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'quotation_path' => $quotationPath,
            'quoted_at' => $quotationPath ? ($boqSubmission->quoted_at ?: now()) : null,
        ])->save();

        return redirect()
            ->route('admin.boqs.show', $boqSubmission)
            ->with('success', 'BOQ updated.');
    }

    private function generateReference(): string
    {
        do {
            $next = (int) BoqSubmission::max('id') + 1;
            $reference = 'ORB-BOQ-' . now()->format('Y') . '-' . str_pad((string) $next, 6, '0', STR_PAD_LEFT);
        } while (BoqSubmission::where('reference', $reference)->exists());

        return $reference;
    }

    private function projectTypes(): array
    {
        return [
            'CCTV Installation',
            'Office Networking',
            'Fibre Installation',
            'Wi-Fi Installation',
            'Point-to-Point Link',
            'ISP Deployment',
            'Structured Cabling',
            'Access Control',
            'Other',
        ];
    }
}
