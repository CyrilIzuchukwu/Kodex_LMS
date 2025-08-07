<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/poppins.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>EVC 2</title>
</head>

<body class="m-0 p-0 box-border font-poppins">

    <div class="my-5 lg:my-0 flex flex-col lg:flex-row items-center justify-center ">
        <div
            class="flex my-30 lg:my-0 flex-col lg:flex-row justify-center lg:flex-wrap items-center h-[100%] w-[100%] px-10">
            <div class="lg:w-[50%] h-[100%] flex justify-center">
                <img class=" lg:max-w-svw lg:max-h-svh py-10" src="{{ asset('assets/auth/main-auth-banner.png') }}"
                    alt="Side Image" />
            </div>

            <div class="flex flex-col items-center lg:w-[50%] gap-y-16">
                <div class="flex flex-col gap-y-4">
                    <div class="flex flex-col justify-center items-center gap-y-4">
                        <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                        <img class="w-[80px] mt-10" src="{{ asset('assets/auth/envelope.png') }}" alt="envelope">
                    </div>

                    <div class="text-center ">
                        <p class="font-[500] text-[#1B1B1B] text-[18px]">Enter Verification Code</p>
                        <p class="text-[#767676]">We've sent a 4-digit code to your email.</p>
                    </div>

                    <form class="flex gap-x-4 mt-6 justify-center" action="">
                        <input class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 py-2 px-2 w-7" type="text" />
                        <input class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 py-2 px-2 w-7" type="text" />
                        <input class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 py-2 px-2 w-7" type="text" />
                        <input class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 py-2 px-2 w-7" type="text" />
                    </form>
                </div>



                <div class="flex flex-col items-center gap-1">
                    <button class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer text-red hover:before:bg-redborder-red-500 relative h-[50px] overflow-hidden px-3 transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-gray-900 before:transition-all before:duration-500 hover:text-white  hover:before:left-0 hover:before:w-full"> <span class="relative z-10">Verify
                        Code</span></button>
                    <p class="text-[14px] text-[#767676] cursor-pointer">Didn't receive the code?<span
                            class="text-[#E68815] hover:text-gray-900  hover:transition-all duration-300">
                            Resend</span></p>

                </div>

                <div class="flex gap-2">
                    <div class="bg-[#E68815] h-0.5 w-20 rounded-4xl"></div>
                    <div class="bg-[#E68815] h-0.5 w-20 rounded-4xl"></div>
                    <div class="bg-[#767676] h-0.5 w-20 rounded-4xl"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    if (this.value.length >= 1) {
                        var nextInput = this.nextElementSibling;
                        if (nextInput && nextInput.tagName === 'INPUT') {
                            nextInput.focus();
                        }
                    }
                });
            });
        });
        
        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    if (this.value.length === 0) {
                        var previousInput = this.previousElementSibling;
                        if (previousInput && previousInput.tagName === 'INPUT') {
                            previousInput.focus();
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>