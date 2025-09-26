<div class="glass-effect rounded-2xl p-6 shadow-sm">
    <div class="flex items-start gap-6">
        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0">
            <img class="w-full h-full object-cover" src="https://placehold.co/124x124/E5B983/FFF?text=S"
                alt="Support Team">
        </div>

        <div class="flex-1">
            <h3 class="text-xl font-semibold text-orange-600 mb-1">Support Team</h3>
            <p class="text-xs text-gray-500 mb-3">We're here to assist you with any questions or issues.</p>
            
            <div class="flex flex-col md:flex-col lg:flex-row gap-4">
                <a href="mailto:{{ site_settings()?->site_email }}"
                    class="btn-primary bg-orange-500 text-white px-4 py-2 rounded-full font-medium transition-all duration-300 flex items-center gap-2 hover:bg-orange-600"
                    title="Email Support Team">
                    <i class="mdi mdi-email"></i>
                    Email
                </a>

                <a href="tel:{{ site_settings()?->site_phone }}"
                    class="btn-primary bg-orange-500 text-white px-4 py-2 rounded-full font-medium transition-all duration-300 flex items-center gap-2 hover:bg-orange-600"
                    title="Call Support Team">
                    <i class="mdi mdi-phone"></i>
                    Phone
                </a>
            </div>
        </div>
    </div>
</div>
