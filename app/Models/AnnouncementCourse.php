<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AnnouncementCourse extends Pivot
{
    protected $table = 'announcement_course';
}
