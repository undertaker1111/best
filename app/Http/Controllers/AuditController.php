<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
    public function index()
    {
        $logs = Activity::with('causer', 'subject')->latest()->paginate(30);
        return view('audits.index', compact('logs'));
    }
} 