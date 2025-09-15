<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;
use PDF;

class CertificateController extends Controller
{
    public function courseCertificate(Course $course)
    {
        // Verify the user has completed the course
        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        $pdf = PDF::loadView('user.courses.certificate', [
            'course' => $course,
            'user' => Auth::user(),
            'completion_date' => $enrollment->updated_at,
        ]);

        return $pdf->download("certificate-$course->slug.pdf");
    }
}
