<?php
include_once __DIR__ . "/../../config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Admin Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .form-container {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .form-container:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .input-focus:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .btn-primary {
        background: linear-gradient(90deg, #4f46e5 0%, #7c73e6 100%);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #4338ca 0%, #6d63d9 100%);
        transform: translateY(-2px);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .category-icon {
        color: #4f46e5;
    }
    </style>
</head>

<body class="font-sans">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Admin Panel</h1>
                <p class="text-gray-600 mt-1">Category Management</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i class="fas fa-user text-indigo-600"></i>
                </div>
                <span class="text-gray-700 font-medium">Admin</span>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl form-container p-6 md:p-8">
                <!-- Page Title & Navigation -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-tags category-icon mr-3"></i>
                            Add New Category
                        </h2>
                        <p class="text-gray-600 mt-2">Create a new category to organize your content</p>
                    </div>
                    <a href="categories.php"
                        class="flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                        <i class="fas fa-list mr-2"></i>
                        View Categories
                    </a>
                </div>

                <!-- Form -->
                <form action="../../admin/Category/categories-db.php" method="post" class="space-y-8">
                    <!-- Form Card -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                            Category Information
                        </h3>

                        <!-- Category Name Field -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2" for="category_name">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" id="category_name" name="category_name"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none"
                                    placeholder="Enter category name (e.g., Electronics, Fashion, Books)" required>
                            </div>
                            <p class="text-gray-500 text-sm mt-2">Enter a descriptive name for your category</p>
                        </div>

                        <!-- Category-type  -->
                        <div class="mb-8">
                            <label for="category_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Category Type <span class="text-red-500">*</span>
                            </label>

                            <!-- Gradient Border Wrapper -->
                            <div class="relative p-[1px] rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
               focus-within:shadow-lg focus-within:shadow-indigo-200 transition-all duration-300">

                                <!-- Actual Select Box -->
                                <div class="relative bg-white rounded-xl">
                                    <!-- Left Icon -->
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-layer-group text-indigo-500"></i>
                                    </div>

                                    <select id="category_type" name="category_type" required class="w-full pl-11 pr-12 py-3.5 text-gray-700 bg-transparent
                       rounded-xl border border-transparent appearance-none
                       focus:outline-none focus:ring-0 cursor-pointer">

                                        <option value="">— Select Category Type —</option>

                                        <optgroup label="🏠 Residential">
                                            <option>Apartment / Flat</option>
                                            <option>House / Villa</option>
                                            <option>Condominium (Condo)</option>
                                            <option>Townhouse</option>
                                            <option>Duplex / Triplex</option>
                                            <option>Studio / Loft</option>
                                            <option>Penthouse</option>
                                        </optgroup>

                                        <optgroup label="🏢 Commercial">
                                            <option>Office</option>
                                            <option>Retail / Shop</option>
                                            <option>Warehouse / Storage</option>
                                            <option>Hotel / Resort</option>
                                            <option>Restaurant / Cafe Space</option>
                                        </optgroup>

                                        <optgroup label="🏭 Industrial">
                                            <option>Factory</option>
                                            <option>Manufacturing Facility</option>
                                            <option>Industrial Land</option>
                                        </optgroup>

                                        <optgroup label="🌱 Land / Plots">
                                            <option>Residential Land</option>
                                            <option>Commercial Land</option>
                                            <option>Agricultural Land</option>
                                            <option>Development Plot</option>
                                        </optgroup>

                                        <optgroup label="⭐ Special Purpose">
                                            <option>Parking Spaces</option>
                                            <option>Co-working Spaces</option>
                                            <option>Mixed-use Buildings</option>
                                        </optgroup>

                                    </select>

                                    <!-- Right Arrow -->
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Select a predefined property category for better organization
                            </p>
                        </div>



                        <!-- Optional: Category Description -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2" for="category_description">
                                Category Description (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                </div>
                                <textarea id="category_description" name="category_description" rows="3"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none"
                                    placeholder="Brief description of this category..."></textarea>
                            </div>
                            <p class="text-gray-500 text-sm mt-2">Add a brief description to help users understand this
                                category</p>
                        </div>

                        <!-- Optional: Category Color Picker -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">
                                Category Color (Optional)
                            </label>
                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center">
                                    <input type="radio" id="color_indigo" name="category_color" value="indigo"
                                        class="sr-only">
                                    <label for="color_indigo"
                                        class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color_blue" name="category_color" value="blue"
                                        class="sr-only">
                                    <label for="color_blue"
                                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color_green" name="category_color" value="green"
                                        class="sr-only">
                                    <label for="color_green"
                                        class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color_red" name="category_color" value="red"
                                        class="sr-only">
                                    <label for="color_red"
                                        class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color_yellow" name="category_color" value="yellow"
                                        class="sr-only">
                                    <label for="color_yellow"
                                        class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color_purple" name="category_color" value="purple"
                                        class="sr-only">
                                    <label for="color_purple"
                                        class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center cursor-pointer border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                                    </label>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm mt-2">Select a color to visually identify this category</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col md:flex-row justify-between items-center pt-4 border-t border-gray-200">
                        <div class="mb-4 md:mb-0">
                            <p class="text-gray-600 text-sm">
                                <i class="fas fa-exclamation-circle text-amber-500 mr-1"></i>
                                Fields marked with <span class="text-red-500">*</span> are required
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="categories.php"
                                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-white font-medium rounded-lg btn-primary shadow-md flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Save Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div class="mt-8 bg-white rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-amber-500 mr-2"></i>
                    Tips for Creating Categories
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                            <i class="fas fa-pen text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Clear Naming</h4>
                            <p class="text-gray-600 text-sm mt-1">Use descriptive names that clearly represent the
                                content.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <i class="fas fa-layer-group text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Hierarchical Structure</h4>
                            <p class="text-gray-600 text-sm mt-1">Consider using parent and child categories for better
                                organization.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <i class="fas fa-sitemap text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Avoid Overlap</h4>
                            <p class="text-gray-600 text-sm mt-1">Ensure categories are distinct with minimal overlap.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center text-gray-500 text-sm">
            <p>© <?php echo date('Y'); ?> Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <!-- JavaScript for Color Selection -->
    <script>
    // Handle color selection
    document.querySelectorAll('input[name="category_color"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove checkmark from all colors
            document.querySelectorAll('label[for^="color_"] i').forEach(icon => {
                icon.classList.add('opacity-0');
            });

            // Add checkmark to selected color
            const selectedLabel = document.querySelector(`label[for="${this.id}"] i`);
            selectedLabel.classList.remove('opacity-0');
        });
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const categoryName = document.getElementById('category_name').value.trim();

        if (!categoryName) {
            e.preventDefault();
            alert('Please enter a category name');
            document.getElementById('category_name').focus();
            return false;
        }

        // Optional: Add more validation here

        // Show loading state on button
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
        submitBtn.disabled = true;

        return true;
    });

    // Auto-focus on category name field
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('category_name').focus();
    });
    </script>
</body>

</html>