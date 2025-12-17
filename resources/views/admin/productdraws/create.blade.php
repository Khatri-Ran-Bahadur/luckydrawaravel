@extends('admin.layouts.app')
@section('content')
<div class="space-y-6">
    <!-- page header -->
     <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Create Cash Lucky Draw</h1>
                <p class="text-green-100 mt-1">Set up a cash prize draw</p>
            </div>
            <a href="{{route('admin.cashdraws.index')}}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
     </div>

     <!-- draw table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
               <i class="fas fa-dollar-sign text-green-600 text-lg mr-2"></i> 
                Cash Draw Details
            </h2>
        </div>

        

        <form action="{{route('admin.cashdraws.store')}}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <label for="prize_amount" class="block text-sm font-medium text-gray-700 mb-2">Prize Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Rs.</span>
                        <input type="number" name="prize_amount" id="prize_amount" step="0.01" min="1" required
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="1000.00" value="{{old('prize_amount')}}">
                            @error('prize_amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                    </div>
                </div>
            </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="entry_fee" class="block text-sm font-medium text-gray-700 mb-2">Entry Fee</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Rs.</span>
                        <input type="number" name="entry_fee" id="entry_fee" step="0.01" min="0.01" required
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="1.00" value="{{old('entry_fee')}}">
                            @error('entry_fee')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                    </div>
                </div>

                <div>
                    <label for="total_winners" class="block text-sm font-medium text-gray-700 mb-2">Total Winners</label>
                    <input type="number" name="total_winners" id="total_winners" min="1" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="1" value="{{old('total_winners',1)}}">
                        @error('total_winners')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Number of winners for this draw</p>
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

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="3" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="Brief description of the cash draw...">{{old('description')}}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
            </div>

             <!-- Winner Selection Method -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Winner Selection Method</label>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="radio" name="is_manual_selection" value="0" id="auto_selection"  {{old('is_manual_selection',0) == 0 ? 'checked' : ''}}
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <label for="auto_selection" class="ml-3 block text-sm text-gray-700">
                            <span class="font-medium">Automatic Selection</span>
                            <span class="block text-gray-500">System will randomly select winners</span>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="is_manual_selection" value="1" id="manual_selection" {{old('is_manual_selection',0) == 1 ? 'checked' : ''}}
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <label for="manual_selection" class="ml-3 block text-sm text-gray-700">
                            <span class="font-medium">Manual Selection</span>
                            <span class="block text-gray-500">Admin will manually select winners</span>
                        </label>
                    </div>
                </div>
                @error('is_manual_selection')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- status select option-->
             <div class="mt-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" required
                    class="w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="active" {{old('status', 'active') == 'active' ? 'selected' : ''}}>Active</option>
                    <option value="inactive" {{old('status', 'active') == 'inactive' ? 'selected' : ''}}>Inactive</option>
                    <option value="completed" {{old('status', 'active') == 'completed' ? 'selected' : ''}}>Completed</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
             </div>

             <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{route('admin.cashdraws.index')}}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Create Cash Draw
                </button>
            </div>


        </form>
       
    </div>
</div>
@endsection