<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /** Nhận form đăng ký tư vấn (hỗ trợ cả AJAX và submit thường). */
    public function store(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        $lead = Lead::create([
            'name' => $request->string('name'),
            'phone' => $request->string('phone'),
            'email' => $request->input('email'),
            'need' => $request->input('need'),
            'message' => $request->input('message'),
            'status' => 'new',
            'source' => 'homepage_form',
            'ip_address' => $request->ip(),
        ]);

        // TODO (tuỳ chọn): dispatch notification email/Zalo cho sale tại đây.

        $message = 'Cảm ơn ' . $lead->name . '! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return back()->with('lead_success', $message);
    }
}
