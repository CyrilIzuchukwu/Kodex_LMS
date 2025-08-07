<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/poppins.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Create New Password</title>
</head>

<body class="m-0 p-0 box-border font-poppins">
    <div class="my-5 lg:my-0 flex flex-col lg:flex-row items-center justify-center ">
        <div
            class="flex my-30 lg:my-0 flex-col lg:flex-row justify-center lg:flex-wrap items-center h-[100%] w-[100%] px-10">
            <div class="lg:w-[50%] h-[100%] flex justify-center">
                <img class=" lg:max-w-svw lg:max-h-svh py-10" src="{{ asset('assets/auth/main-auth-banner.png') }}"
                    alt="Side Image" />
            </div>

            <div class="flex flex-col items-center lg:w-[50%] gap-y-8">
                <div class="flex flex-col ">
                    <div class="flex flex-col justify-center items-center gap-y-4">
                        <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                        <img class="w-[80px] mt-10" src="{{ asset('assets/auth/key.png') }}" alt="key">
                    </div>

                    <div class="text-center ">
                        <p class="font-[500] text-[#1B1B1B] text-[18px]">Create New Password</p>
                        <p class="text-[#767676]">Protect your account with a secure password.</p>
                    </div>

                    <form class="flex flex-col gap-y-5 mt-6 justify-center" action="">
                        <div>
                            <label class="text-[#767676]" for="password" value="password">New Password</label>
                            <div class="relative w-[100%]">
                                <input
                                    class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2"
                                    type="password" placeholder="Enter your password" id="password" />
                                <span class="absolute right-12 top-3 text-[#767676]">
                                    <i class="ri-eye-off-line mr-2 cursor-pointer absolute hidden" id="eyeclose"></i>
                                    <i class="ri-eye-line cursor-pointer absolute" id="eyeopen"></i>
                                </span>
                            </div>
                        </div>


                        <div>
                            <label class="text-[#767676]" for="Password" value="Password">Confirm Password</label>
                            <div class="relative w-[100%]">
                                <input
                                    class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2"
                                    type="password" placeholder="Confirm your new password" id="confirmPassword" />
                                <span class="absolute right-12 top-3 text-[#767676]">
                                    <i class="ri-eye-off-line mr-2 cursor-pointer absolute hidden" id="eyeclose1"></i>
                                    <i class="ri-eye-line cursor-pointer absolute" id="eyeopen1"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>



                <div class="flex flex-col items-center gap-1">
                    <div x-data="{ open: false }">

                        <!-- Modal Trigger Button -->
                        <button @click="open = true"
                            class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer before:ease relative h-12 overflow-hidden before:absolute before:left-0 before:-ml-2 before:h-48 before:w-[70vw] before:origin-top-right before:-translate-x-full before:translate-y-12 before:-rotate-90 before:bg-gray-900 before:transition-all before:duration-300 hover:text-white hover:before:-rotate-180 hover:animate-bounce"><span
                                class="relative z-10">Send Reset Link</span>
                        </button>

                        <!-- Modal -->
                        <div x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <div @click.away="open = false"
                                class="bg-white rounded-[30px] shadow-lg p-4 lg:p-6 lg:w-[34.72vw] flex flex-col items-center text-center gap-y-5 h-auto lg:h-[34.72vw] ">
                                <div><img src="{{ asset('assets/auth/good.png') }}" alt="good"></div>
                                <div class="mb-5">
                                    <h2 class="text-xl font-[500]">Password Reset Successful</h2>
                                    <p>Your password has been updated. You can now log in with your new password.</p>
                                </div>
                                <div> <button @click="open = false"
                                        class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer hover:before:bg-redborder-red-500 relative h-[50px] overflow-hidden px-3 transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-gray-900 before:transition-all before:duration-500 hover:text-white  hover:before:left-0 hover:before:w-full hover:animate-bounce"><span
                                            class="relative z-10">Go to Login</span>
                                    </button></div>
                            </div>
                        </div>

                    </div>

                    <button
                        class="border-0 rounded-[50px] flex py-2 w-[70vw] place-content-center items-center  lg:w-[20vw] gap-x-1 cursor-pointer text-[#767676] relative h-[50px]  overflow-hidden  bg-white transition-all before:absolute before:left-0 before:right-0 before:top-0 before:h-0 before:w-full before:bg-green-900 before:duration-500 after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0 after:w-full after:bg-green-900 after:duration-500 hover:text-white hover:before:h-2/4 hover:after:h-2/4">
                        <img class="w-5 relative z-10 hover:animate-bounce hover:text-white"
                            src="{{ asset('assets/auth/arrow.png') }}" alt="arrow" /><span class="relative z-10">Back to
                            Login</span>
                    </button>
                </div>


                <div class="flex gap-2">
                    <div class="bg-[#E68815] h-0.5 w-20 rounded-4xl"></div>
                    <div class="bg-[#E68815] h-0.5 w-20 rounded-4xl"></div>
                    <div class="bg-[#E68815] h-0.5 w-20 rounded-4xl"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
    document.addEventListener('click', function() {
        const eyeIcon = document.getElementById('eyeopen');
        const eyeOffIcon = document.getElementById('eyeclose');
        const passwordInput = document.getElementById('password')

        eyeIcon.addEventListener('click', () => {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        });

        eyeOffIcon.addEventListener('click', () => {
            passwordInput.type = 'password';
            eyeOffIcon.classList.add('hidden');
            eyeIcon.classList.remove('hidden');
        });
    });



    document.addEventListener('click', function() {
        const eyeIcon1 = document.getElementById('eyeopen1');
        const eyeOffIcon1 = document.getElementById('eyeclose1');
        const passwordInput1 = document.getElementById('confirmPassword');

        eyeIcon1.addEventListener('click', () => {
            passwordInput1.type = 'text';
            eyeIcon1.classList.add('hidden');
            eyeOffIcon1.classList.remove('hidden');
        });

        eyeOffIcon1.addEventListener('click', () => {
            passwordInput1.type = 'password';
            eyeOffIcon1.classList.add('hidden');
            eyeIcon1.classList.remove('hidden');
        });
    })
    </script>

</body>

</html>