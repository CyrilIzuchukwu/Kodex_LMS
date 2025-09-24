<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Log;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\Browsershot\Browsershot;
use Throwable;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['course', 'enrollment'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.courses.certificates', [
            'title' => 'My Certificates',
            'certificates' => $certificates
        ]);
    }

    /**
     * @throws Throwable
     */
    public function courseCertificate(Course $course)
    {
        try {
            // Verify the user has completed the course
            $enrollment = CourseEnrollment::where('course_id', $course->id)
                ->where('user_id', Auth::id())
                ->where('status', 'completed')
                ->first();

            if (!$enrollment) {
                abort(403, 'You have not completed this course or are not enrolled.');
            }

            // Generate certificate ID
            $certificateId = 'KDX-' . now()->format('Y') . '-' . $enrollment->id . '-' . $course->id . '-' . Auth::id() . '-' . strtoupper(substr(Auth::user()->name ?? '', 0, 2));

            // Generate unique filenames
            $fileName = "certificate-$course->slug-" . Auth::id() . ".pdf";
            $filePath = "certificates/$fileName";
            $thumbnailPath = "certificate-thumbnails/$certificateId.jpg";

            // Check if the certificate already exists in database and storage
            $certificate = Certificate::where('user_id', Auth::id())
                ->where('course_enrollment_id', $enrollment->id)
                ->where('course_id', $course->id)
                ->first();

            $certificateExists = $certificate && Storage::disk('public')->exists($certificate->certificate_path);
            $thumbnailExists = $certificate && Storage::disk('public')->exists($certificate->thumbnail_path);

            // If both certificate and thumbnail exist, return the existing certificate
            if ($certificateExists && $thumbnailExists) {
                return response()->download(
                    storage_path("app/public/$certificate->certificate_path"),
                    $fileName,
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
                    ]
                );
            }

            // Prepare data for the PDF & thumbnail
            $data = [
                'course' => $course,
                'user' => Auth::user(),
                'completion_date' => $enrollment->updated_at->format('M j, Y'),
                'certificate_id' => $certificateId,
            ];

            // Ensure the storage directories exist
            if (!Storage::disk('public')->exists(dirname($filePath))) {
                Storage::disk('public')->makeDirectory(dirname($filePath));
            }
            if (!Storage::disk('public')->exists(dirname($thumbnailPath))) {
                Storage::disk('public')->makeDirectory(dirname($thumbnailPath));
            }

            // Generate and save the PDF if it doesn't exist
            if (!$certificateExists) {
                Pdf::view('user.courses.certificate', $data)
                    ->format(Format::A4)
                    ->landscape()
                    ->margins(1, 1, 1, 1)
                    ->withBrowsershot(function ($browsershot) {
                        $browsershot->setOption('viewportWidth', 1970)
                            ->setOption('viewportHeight', 1100)
                            ->scale(1)
                            ->noSandbox();
                    })
                    ->save(storage_path("app/public/$filePath"));
            }

            // Generate and save thumbnail if it doesn't exist
            if (!$thumbnailExists) {
                Browsershot::html(view('user.courses.certificate', $data)->render())
                    ->windowSize(1045, 715)
                    ->setScreenshotType('jpeg', 80)
                    ->save(storage_path("app/public/$thumbnailPath"));
            }

            // Save or update a certificate record
            Certificate::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_enrollment_id' => $enrollment->id,
                    'course_id' => $course->id,
                ],
                [
                    'certificate_id' => $certificateId,
                    'certificate_path' => $filePath,
                    'thumbnail_path' => $thumbnailPath,
                ]
            );

            // Return file download with proper headers
            return response()->download(
                storage_path("app/public/$filePath"),
                $fileName,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
                ]
            );
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Certificate generation failed: ' . $e->getMessage());

            // Return a user-friendly error response
            return response()->json([
                'error' => 'Failed to generate certificate. Please try again later.',
            ], 500);
        }
    }
}
