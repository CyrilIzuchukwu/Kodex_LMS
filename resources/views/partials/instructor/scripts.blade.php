<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/cleave.min.js') }}"></script>

@if(Route::is('admin.students.index'))
    <script src="{{ asset('dashboard_assets/js/manage_students.js') }}"></script>
@endif

@if(Route::is('admin.instructors.index'))
    <script src="{{ asset('dashboard_assets/js/manage_instructors.js') }}"></script>
@endif

@if(Route::is('admin.categories.index'))
    <script src="{{ asset('dashboard_assets/js/manage_categories.js') }}"></script>
@endif

@if(Route::is('admin.categories.show') || Route::is('admin.courses.index'))
    <script src="{{ asset('dashboard_assets/js/manage_course.js') }}"></script>
@endif

@if(Route::is('admin.courses.add.details') || Route::is('admin.courses.edit.details') || Route::is('admin.announcements.create'))
    <script src="{{ asset('dashboard_assets/js/quill-editor.js') }}"></script>
    <script src="{{ asset('dashboard_assets/js/quill.js') }}"></script>
@endif

<script src="{{ asset('dashboard_assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/plugins.init.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/app.js') }}"></script>
