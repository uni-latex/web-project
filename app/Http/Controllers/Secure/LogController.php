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

        $filters = $this->filters($request);

        $logs = Upload::select('type', 'file_date', 'original_file', 'user_id', 'created_at', 'is_success')
            ->with('user:id,name')
            ->latest()
            ->filter($filters)
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Secure/Log/Index', [
            'fields' => [
                'upload_types' => [
                    'document' => 'Document',
                    'mutation' => 'Mutation'
                ],
            ],
            'filters' => $filters,
            'models' => $logs,
        ]);
    }

    private function filters(Request $request)
    {
        $filters = [
            'upload_type' => '',
        ];

        foreach ($filters as $key => $value) {
            $filters[$key] = $request->get($key) ?? $filters[$key];
        }

        return $filters;
    }
}
