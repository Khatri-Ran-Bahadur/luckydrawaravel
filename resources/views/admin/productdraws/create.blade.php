@extends('admin.layouts.app')
@section('content')
<div class="space-y-6"></div>
    <!-- page header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Create Product Lucky Draw</h1>
                <p class="text-green-100 mt-1">Set up a product prize draw</p>
            </div>
            <a href="{{route('admin.productdraws.index')}}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
     </div>

     <!-- draw table -->    
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-gift text-gray-400 text-lg mr-2"></i>
                    Product Draw Details
                </h2>
            </div>

         
            <form action="{{route('admin.productdraws.store')}}" method="POST" class="p-6 space-y-6" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Draw Information</h3>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Draw Title</label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="e.g., Win $1000 Cash Prize" value="{{old('title')}}">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Draw Description</label>
                        <textarea name="description" id="description" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Brief description of the cash draw...">{{old('description')}}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- product information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Product Information</h3>
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input type="text" name="product_name" id="product_name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="e.g., iPhone 13" value="{{old('product_name')}}">
                        @error('product_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="product_price" class="block text-sm font-medium text-gray-700 mb-2">Product Price</label>
                        <input type="number" name="product_price" id="product_price" step="0.01" min="1" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="1000.00" value="{{old('product_price')}}">
                            @error('product_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                    </div>
                    <div>
                        <label for="product_image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                        <input type="file" name="product_image" id="product_image" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            value="{{old('product_image')}}">
                            <p class="text-sm text-gray-500 mt-1">Upload a clear image of the product (max 2MB)</p>
                        @error('product_image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- draw settings -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Draw Settings</h3>
                    <div>
                        <label for="entry_fee" class="block text-sm font-medium text-gray-700 mb-2">Entry Fee</label>
                        <input type="number" name="entry_fee" id="entry_fee" step="0.01" min="1" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="1.00" value="{{old('entry_fee')}}">
                        @error('entry_fee')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="draw_date" class="block text-sm font-medium text-gray-700 mb-2">Draw Date & Time</label>
                        <input type="datetime-local" name="draw_date" id="draw_date" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            value="{{old('draw_date')}}">
                        @error('draw_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- submit button -->
                 <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{route('admin.productdraws.index')}}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Create Product Draw
                    </button>
                </div>
            
            </form>
        </div>

        <!-- live preview -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-eye mr-3 text-green-600"></i>
                    Live Preview
                </h2>
                <p class="text-gray-600 text-sm mt-1">See how your product will appear to users</p>
            </div>

            <div class="p-6">
                <!-- Product Card Preview (Honda Bike Style) -->
                <div id="productPreview" class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-6 border-2 border-blue-200 shadow-lg">
                    <div class="text-center">
                        <!-- Product Image -->
                        <div id="previewImageContainer" class="w-48 h-48 mx-auto mb-6 bg-white rounded-xl shadow-md flex items-center justify-center overflow-hidden">
                            <div id="placeholderIcon" class="text-gray-400">
                                <i class="fas fa-image text-6xl"></i>
                                <p class="text-sm mt-2">Upload Image</p>
                            </div>
                            <img id="previewImage" src="" alt="Product" class="w-full h-full object-cover hidden">
                        </div>

                        <!-- Product Name -->
                        <h3 id="previewProductName" class="text-2xl font-bold text-gray-800 mb-2">Product Name</h3>

                        <!-- Product Price -->
                        <div class="mb-4">
                            <span class="text-sm text-gray-600">Worth</span>
                            <div id="previewProductPrice" class="text-3xl font-bold text-green-600">Rs. 0</div>
                        </div>

                        <!-- Buy Button -->
                        <div class="mb-4">
                            <button class="w-full bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold py-4 px-6 rounded-xl text-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                <span id="previewBuyButton">Buy for Rs. 0</span>
                            </button>
                        </div>

                        <!-- Draw Date -->
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-clock mr-1"></i>
                            Draw Date: <span id="previewDrawDate">Select date</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const productNameInput = document.getElementById('product_name');
        const productPriceInput = document.getElementById('product_price');
        const productImageInput = document.getElementById('product_image');
        const entryFeeInput = document.getElementById('entry_fee');
        const drawDateInput = document.getElementById('draw_date');

        const previewImageContainer = document.getElementById('previewImageContainer');
        const previewProductName = document.getElementById('previewProductName');
        const previewProductPrice = document.getElementById('previewProductPrice');
        const previewBuyButton = document.getElementById('previewBuyButton');
        const previewDrawDate = document.getElementById('previewDrawDate');


        //  update preview functions
        function updatePreviewName() {
            const name = productNameInput.value || 'Product Name';
            previewProductName.textContent = name;
        }

        function updatePreviewPrice() {
            const price = productPriceInput.value || '0';
            previewProductPrice.textContent = 'Rs. ' + parseInt(price).toLocaleString();
        }

        function updatePreviewEntryFee() {
            const entryFee = entryFeeInput.value || '0';
            previewBuyButton.textContent = 'Buy for Rs. ' + parseInt(entryFee).toLocaleString();
        }

        function updatePreviewDrawDate() {
            const date = drawDateInput.value;
            if(date) {
                const dateObj = new Date(date);
                const formattedDate = dateObj.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                });
                previewDrawDate.textContent = formattedDate;
            } else {
                previewDrawDate.textContent = 'Select date';
            }
        }

        function updatePreviewImage() {
            const image = productImageInput.files[0];
            if(image) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    placeholderIcon.classList.add('hidden');
                }
                reader.readAsDataURL(image);
            } else {
                previewImage.src = '';
                previewImage.classList.add('hidden');
                placeholderIcon.classList.remove('hidden');
            }
        }

        //  update preview when input values change
        productNameInput.addEventListener('input', updatePreviewName);
        productPriceInput.addEventListener('input', updatePreviewPrice);
        entryFeeInput.addEventListener('input', updatePreviewEntryFee);
        drawDateInput.addEventListener('change', updatePreviewDrawDate);
        productImageInput.addEventListener('change', updatePreviewImage);


        // initail update
        updatePreviewName();
        updatePreviewPrice();
        updatePreviewEntryFee();
        updatePreviewDrawDate();
        updatePreviewImage();

        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        drawDateInput.min = now.toISOString().slice(0, 16);

        //  update preview when input values change
    });
</script>

@endpush