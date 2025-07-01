<?php

namespace App\Http\Controllers;

use App\Imports\EnrollmentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // ✅ This triggers model creation
            Excel::import(new EnrollmentImport, $request->file('file'));

            return back()->with('success', 'Enrollment data imported successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error importing enrollment data: ' . $e->getMessage());

            return back()->with('error', 'Error importing enrollment data: ' . $e->getMessage());
        }
    }
}
