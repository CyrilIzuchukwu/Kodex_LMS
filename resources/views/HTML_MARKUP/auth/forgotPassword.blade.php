<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/poppins.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Forgot Password</title>
</head>

<body class="m-0 p-0 box-border font-poppins">

    <div class="my-30 lg:my-10 py-2 flex flex-col lg:flex-row items-center justify-center ">
        <div
            class="flex flex-col lg:flex-row justify-center lg:flex-wrap items-center h-[100%] w-[100%] px-10">
            <div class="lg:w-[50%] flex justify-center">
                <img class=" lg:max-w-svw" src="{{ asset('assets/auth/main-auth-banner.png') }}"
                    alt="Side Image" />
            </div>

            <div class="flex flex-col items-center lg:w-[50%] gap-y-16">
                <div class="flex flex-col gap-y-4">
                    <div class="flex flex-col justify-center items-center gap-y-4">
                        <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                        <img class="w-[80px] mt-10" src="{{ asset('assets/auth/fingerprint.png') }}" alt="fingerprint">
                    </div>

                    <div class="text-center ">
                        <p class="font-[500] text-[#1B1B1B] text-[18px]">Forgot Password</p>
                        <p class="text-[#767676]">Enter your email to reset your password.</p>
                    </div>

                    <form class="flex flex-col space-y-2 mt-6 " action="">
                        <label class="text-[#767676]" for="email" value="email">Email</label>
                        <input
                            class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2"
                            type="text" placeholder="Enter your e-mail" /><br>
                    </form>
                </div>



                <div class="flex flex-col items-center gap-y-4">
                    <button
                        class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer before:ease relative h-12 overflow-hidden before:absolute before:left-0 before:-ml-2 before:h-48 before:w-[70vw] before:origin-top-right before:-translate-x-full before:translate-y-12 before:-rotate-90 before:bg-gray-900 before:transition-all before:duration-800 hover:text-white hover:before:-rotate-180"><span
                            class="relative z-10">Send Reset Link</span></button>
                    <button
                        class="border-0 rounded-[50px] flex py-2 w-[70vw] place-content-center items-center  lg:w-[20vw] gap-x-1 cursor-pointer text-[#767676] relative h-[50px]  overflow-hidden  bg-white transition-all before:absolute before:left-0 before:right-0 before:top-0 before:h-0 before:w-full before:bg-green-900 before:duration-300 after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0 after:w-full after:bg-green-900 after:duration-500 hover:text-white hover:before:h-2/4 hover:after:h-2/4 ">
                        <img class="w-5 relative z-10  hover:text-white"
                            src="{{ asset('assets/auth/arrow.png') }}" alt="arrow" /><span class="relative z-10">Back to
                            Login</span>
                    </button>
                </div>

                <div class="flex gap-2">
                    <div class="bg-[#E68815] h-0.5 w-20 rounded-4xl"></div>
                    <div class="bg-[#767676] h-0.5 w-20 rounded-4xl"></div>
                    <div class="bg-[#767676] h-0.5 w-20 rounded-4xl"></div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>