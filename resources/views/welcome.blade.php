<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .marquee {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            white-space: nowrap;
            overflow: hidden;
            animation: marquee 10s linear infinite;
            font-size: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 10px; /* Padding around the text */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Shadow effect */
            width: auto; /* Full width of the viewport */
        }

        @keyframes marquee {
            0% { transform: translate(-50%, -50%) translateX(100%); }
            100% { transform: translate(-50%, -50%) translateX(-100%); }
        }
    </style>
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body class="h-full">

    <!-- Image at the top taking 1/2 of the screen height -->
    <div class="relative w-full h-1/2">
        <img src="\pwd-images\taguig.jpg" alt="Top Image" class="w-full h-full object-cover">
    </div>
       <!-- Welcome text that scrolls across the top image -->

    <!-- Main content section with cards -->
    <div class="flex flex-wrap justify-center mt-10">

    <div class="marquee text-black text-3xl font-bold">
            Welcome to the e-Census System!
        </div>
        <!-- Card 1 -->
        <div class="p-5 max-w-sm">
            <div class="flex rounded-lg h-full border-2 border-red-400 bg-transparent p-8 flex-col justify-between">
                <!-- Centered PNG Icon -->
                <div class="flex justify-center mb-6">
                    <a href="/super-admin/login">
                        <img src="\pwd-images\super_admin-removebg.png" alt="Super Admin Icon" class="w-40 h-40">
                        <p class="text-center text-lg font-semibold">Super Admin</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="p-5 max-w-sm">
            <div class="flex rounded-lg h-full border-2 border-red-400 bg-transparent p-8 flex-col justify-between">
                <!-- Centered PNG Icon -->
                <div class="flex justify-center mb-6">
                    <a href="/baranggay-admin/login">
                        <img src="\pwd-images\barangay_admin-removebg.png" alt="Barangay Admin Icon" class="w-40 h-40">
                        <p class="text-center text-lg font-semibold">Barangay Admin</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="p-5 max-w-sm">
            <div class="flex rounded-lg h-full border-2 border-red-400 bg-transparent p-8 flex-col justify-between">
                <!-- Centered PNG Icon -->
                <div class="flex justify-center mb-6">
                    <a href="/field-worker/login">
                        <img src="\pwd-images\fieldworker-removebg.png" alt="Field Worker Icon" class="w-40 h-40">
                        <p class="text-center text-lg font-semibold">Fieldworker </p>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <p class="text-center text-lg font-semibold">
    Please Select Your User Account for Taguig E-census</p>
</body>
</html>
