<?php

namespace App\Http\Controllers\Secure;

use App\Http\Controllers\Controller;
use App\Models\Customs\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LogController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::user()->can('viewLogs')) {
            return Redirect::route('dashboard');
        }

        $logs = Upload::select('type', 'original_file', 'user_id', 'created_at', 'is_success')
            ->with('user:id,name')
            ->latest()
            ->paginate()
            ->withQueryString();

        return Inertia::render('Secure/Log/Index', [
            'models' => $logs,
        ]);
    }
}
