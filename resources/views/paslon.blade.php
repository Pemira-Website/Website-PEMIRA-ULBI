<!-- resources/views/paslon.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paslon 1</title>
    @vite('resources/css/app.css') <!-- Include Tailwind CSS -->
</head>
<body class=" flex items-center justify-center ">
    <div class="space-y-10">
        <!-- Card Component -->
        <div class="bg-blue-900 text-white rounded-lg w-[700px] mx-auto overflow-hidden">
            <!-- Title Section -->
            <div class="text-center py-2 bg-blue-900">
                <h2 class="text-xl font-semibold">Paslon 1</h2>
            </div>
            <!-- Content Section -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <!-- Capres Image Placeholder -->
                    <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-black font-semibold">Capres</span>
                    </div>
                    <!-- Cawapres Image Placeholder -->
                    <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-black font-semibold">Cawapres</span>
                    </div>
                </div>
            </div>
            <!-- Button Section with White Background -->
            <div class="bg-white py-4 flex justify-center gap-4">
                <button class="bg-blue-700 text-white py-2 px-6 rounded hover:bg-blue-800">Vote</button>
                <button class="bg-orange-500 text-white py-2 px-6 rounded hover:bg-orange-600">Detail Profil</button>
            </div>
        </div>

        <!-- Duplicate Card Component for the Second Card -->
        <div class="bg-blue-900 text-white rounded-lg w-[700px] mx-auto overflow-hidden">
            <!-- Title Section -->
            <div class="text-center py-2 bg-blue-900">
                <h2 class="text-xl font-semibold">Paslon 1</h2>
            </div>
            <!-- Content Section -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <!-- Capres Image Placeholder -->
                    <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-black font-semibold">Capres</span>
                    </div>
                    <!-- Cawapres Image Placeholder -->
                    <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-black font-semibold">Cawapres</span>
                    </div>
                </div>
            </div>
            <!-- Button Section with White Background -->
            <div class="bg-white py-4 flex justify-center gap-4">
                <button class="bg-blue-700 text-white py-2 px-6 rounded hover:bg-blue-800">Vote</button>
                <button class="bg-orange-500 text-white py-2 px-6 rounded hover:bg-orange-600">Detail Profil</button>
            </div>
        </div>
    </div>
</body>
</html>
