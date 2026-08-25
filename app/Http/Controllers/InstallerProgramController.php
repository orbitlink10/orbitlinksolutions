<?php

namespace App\Http\Controllers;

use App\Models\InstallerApplication;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstallerProgramController extends Controller
{
    public function show()
    {
        $businessTypes = $this->businessTypes();

        return view('theme.' . get_option('theme') . '.installer_program', compact('businessTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'county' => ['required', 'string', 'max:100'],
            'town' => ['required', 'string', 'max:100'],
            'business_type' => ['required', 'string', 'in:' . implode(',', $this->businessTypes())],
            'years_in_business' => ['nullable', 'string', 'max:100'],
            'monthly_purchases' => ['nullable', 'string', 'max:100'],
            'main_brands' => ['nullable', 'string', 'max:1000'],
            'preferred_categories' => ['nullable', 'string', 'max:1000'],
            'buys_for_projects' => ['required', 'boolean'],
            'whatsapp_number' => ['nullable', 'string', 'max:40'],
            'business_registration_number' => ['nullable', 'string', 'max:100'],
            'kra_pin' => ['nullable', 'string', 'max:100'],
            'supporting_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
            'marketing_consent' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user() ?: User::where('email', $validated['email'])->first();
        $documentPath = null;

        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $documentPath = $file->storeAs(
                'uploads/installer-documents',
                upload_file_name($file, 80, 'installer'),
                'public'
            );
        }

        $application = InstallerApplication::create([
            'user_id' => $user?->id,
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'company_name' => $validated['company_name'],
            'county' => $validated['county'],
            'town' => $validated['town'],
            'business_type' => $validated['business_type'],
            'years_in_business' => $validated['years_in_business'] ?? null,
            'monthly_purchases' => $validated['monthly_purchases'] ?? null,
            'main_brands' => $validated['main_brands'] ?? null,
            'preferred_categories' => $validated['preferred_categories'] ?? null,
            'buys_for_projects' => (bool) $validated['buys_for_projects'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'business_registration_number' => $validated['business_registration_number'] ?? null,
            'kra_pin' => $validated['kra_pin'] ?? null,
            'supporting_document_path' => $documentPath,
            'marketing_consent' => (bool) ($validated['marketing_consent'] ?? false),
            'status' => InstallerApplication::STATUS_PENDING,
        ]);

        if ($user && $user->installer_status !== InstallerApplication::STATUS_APPROVED) {
            $user->forceFill(['installer_status' => InstallerApplication::STATUS_PENDING])->save();
        }

        return redirect()
            ->route('installer-program.thank-you')
            ->with('installer_application_reference', $application->id);
    }

    public function thankYou()
    {
        return view('theme.' . get_option('theme') . '.installer_program_thank_you');
    }

    public function adminIndex(Request $request)
    {
        $query = InstallerApplication::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(30);
        $statuses = InstallerApplication::statuses();

        return view('admin.installers.index', compact('applications', 'statuses'));
    }

    public function adminShow(InstallerApplication $installerApplication)
    {
        $installerApplication->load(['user', 'reviewer']);
        $matchedUser = $installerApplication->user ?: User::where('email', $installerApplication->email)->first();
        $orders = $matchedUser
            ? Order::with('orderItems.product')->where('user_id', $matchedUser->id)->latest()->limit(10)->get()
            : collect();
        $statuses = InstallerApplication::statuses();

        return view('admin.installers.show', compact('installerApplication', 'matchedUser', 'orders', 'statuses'));
    }

    public function adminUpdate(Request $request, InstallerApplication $installerApplication)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(InstallerApplication::statuses()))],
            'approved_discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $installerApplication->forceFill([
            'status' => $validated['status'],
            'approved_discount_percent' => $validated['approved_discount_percent'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ])->save();

        $user = $installerApplication->user ?: User::where('email', $installerApplication->email)->first();

        if ($user) {
            $user->forceFill([
                'installer_status' => $validated['status'],
                'installer_discount_percent' => $validated['status'] === InstallerApplication::STATUS_APPROVED
                    ? ($validated['approved_discount_percent'] ?? $user->installer_discount_percent)
                    : null,
                'installer_approved_at' => $validated['status'] === InstallerApplication::STATUS_APPROVED
                    ? ($user->installer_approved_at ?: now())
                    : null,
            ])->save();

            if (! $installerApplication->user_id) {
                $installerApplication->forceFill(['user_id' => $user->id])->save();
            }
        }

        return redirect()
            ->route('admin.installers.show', $installerApplication)
            ->with('success', 'Installer application updated.');
    }

    private function businessTypes(): array
    {
        return [
            'CCTV Installer',
            'Network Technician',
            'Fibre Technician',
            'ISP Technician',
            'System Integrator',
            'IT Company',
            'Electrical Contractor',
            'Reseller',
            'Other',
        ];
    }
}
