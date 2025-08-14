<!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex justify-center z-[9999] overflow-y-auto pt-2 md:pt-4 pb-2 md:pb-4 hidden">
    <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-[90vw] sm:w-[80vw] md:w-[65vw] lg:w-[60vw] xl:w-[50vw] p-3 md:p-6 lg:p-12 space-y-3 z-[10000] self-start mt-2 md:mt-4 mb-2 md:mb-4 mx-2">
        <div class="flex justify-end items-center pb-2 mb-3">
            <button id="closeAddModal" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <form action="{{ route('admin.students.store') }}" id="save-student-form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4 space-y-3 md:space-y-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
                </div>

                <div class="text-center mb-3">
                    <h3 class="text-xs font-medium text-gray-900 mb-3">Profile Photo</h3>
                    <div class="relative w-12 h-12 md:w-16 md:h-16 mx-auto">
                        <input type="file" accept="image/*" id="profile-photo" name="profile_photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                        <label for="profile-photo" class="w-12 h-12 md:w-16 md:h-16 bg-profile-avatar rounded-full flex items-center justify-center cursor-pointer hover:bg-orange-200 transition-colors border-2 border-dashed border-section-icon">
                            <img id="profile-photo-preview" src="{{ asset('dashboard_assets/images/img/photo.png') }}" alt="Profile Preview" class="w-full h-full rounded-full object-cover" />
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Click to upload photo</p>
                </div>

                <div class="w-full">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="full_name">Fullname *</label>
                        <input name="full_name" type="text" class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-xs focus:ring-1 focus:ring-[#E68815]" placeholder="Enter full name">
                    </div>
                </div>

                <div class="grid straddles grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="phoneNumber">Phone</label>
                        <input name="phone" type="tel" id="phoneNumber" class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-xs focus:ring-1 focus:ring-[#E68815]" placeholder="Enter phone number">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="address">Address</label>
                        <input name="address" type="text" class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-xs focus:ring-1 focus:ring-[#E68815]" placeholder="Enter house address">
                    </div>
                </div>

                <div class="mt-3 mb-4">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Biography</label>
                    <div class="border border-gray-300 rounded-lg bg-white">

                        <textarea name="biography" id="biography" placeholder="Write something..." rows="3" class="w-full px-2 md:px-3 py-1 md:py-2 bg-transparent text-gray-900 placeholder:text-gray-500 resize-none focus:outline-none focus:border-none focus:ring-[#E68815] rounded-t-lg text-xs"></textarea>

                        <div class="flex items-center gap-1 px-2 md:px-3 py-1 border-t border-gray-300 bg-gray-50 rounded-b-lg">
                            <!-- Formatting buttons -->
                            <button type="button" class="p-1 hover:bg-gray-200 rounded">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                </svg>
                            </button>

                            <button type="button" class="p-1 hover:bg-gray-200 rounded">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4l4 16m-4-8h8"></path>
                                </svg>
                            </button>

                            <button type="button" class="p-1 hover:bg-gray-200 rounded">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 20h12M8 4v12a4 4 0 008 0V4"></path>
                                </svg>
                            </button>

                            <div class="w-px h-3 bg-gray-300 mx-1"></div>

                            <button type="button" class="p-1 hover:bg-gray-200 rounded">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </button>

                            <button type="button" class="p-1 hover:bg-gray-200 rounded">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <circle cx="4" cy="6" r="1"></circle>
                                    <circle cx="4" cy="12" r="1"></circle>
                                    <circle cx="4" cy="18" r="1"></circle>
                                </svg>
                            </button>

                            <div class="w-px h-3 bg-gray-300 mx-1"></div>

                            <button type="button" class="p-1 hover:bg-gray-200 rounded">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 md:mt-8 mb-6 md:mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-medium text-gray-900">Login Credentials</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="email">Email</label>
                        <input name="email" type="email" id="email" class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-xs focus:ring-1 focus:ring-[#E68815]" placeholder="Enter e-mail address">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="password">Password</label>
                        <input name="password" type="password" id="password" class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-xs focus:ring-1 focus:ring-[#E68815]" placeholder="Create password">
                        <p class="text-brand text-xs mt-1">At least 8 characters with numbers or symbols.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" id="cancelAddStudent" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300 transition-colors text-xs">
                    Cancel
                </button>

                <button type="submit" id="saveStudent" class="bg-[#E68815] text-white px-4 py-2 rounded-full hover:bg-[#cc6f0f] transition-colors text-xs">
                    Save Student
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
    <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
        <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Student?</h2>
        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
            Are you sure you want to remove <span class="font-semibold">John Doe</span> from the system? This action cannot be undone.
        </p>

        <div class="flex justify-center gap-3 w-full">
            <button id="cancelDelete" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                Cancel
            </button>

            <button id="confirmDelete" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
                Delete
            </button>
        </div>
    </div>
</div>
