<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PdfExportController extends Controller
{
    public function contactRequest(ContactRequest $contactRequest): Response
    {
        $pdf = Pdf::loadView('pdf.contact-request', [
            'contactRequest' => $contactRequest,
        ])->setPaper('a4');

        $filename = 'cerere-'.Str::slug($contactRequest->name).'-'.$contactRequest->id.'.pdf';

        return $pdf->download($filename);
    }

    public function project(Project $project): Response
    {
        $pdf = Pdf::loadView('pdf.project', [
            'project' => $project,
        ])->setPaper('a4');

        $filename = 'proiect-'.Str::slug($project->title).'.pdf';

        return $pdf->download($filename);
    }
}
