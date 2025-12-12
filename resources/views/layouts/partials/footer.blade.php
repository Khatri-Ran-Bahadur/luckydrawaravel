

<footer class="bg-gray-900 text-white mt-20">
    <div class="mx-w-7xl mx-auto py-16 px-4 sm:p6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- first -->
            <div>
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-3 rounded-xl mr-3">
                        <i class="fas fa-dice text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Luck Draw System</h3>
                        <p class="text-sm text-gray-400">Win Amazing Prizes</p>
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed" >
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque provident, tempora dolore maiores nulla possimus ex assumenda ullam sit voluptas.
                </p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Home</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Cash Draws</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Product Draws</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Winners</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">FAQs</a></li>

                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Support</h4>
                <ul class="space-y-3">
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Contact Us</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Terms & Conditions</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Privacy Policy</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Help Center</a></li>

                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Connect</h4>
                <ul class="space-y-3">
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Contact Us</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Terms & Conditions</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Privacy Policy</a></li>
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Help Center</a></li>

                </ul>
            </div>
        </div>
    </div>
</footer>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if(userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if(!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }



    });

    function toggleMobileMenu(){
        const mobileMenu=document.getElementById("mobileMenu");
        const isOpen=mobileMenu.classList.contains('open');

        if(isOpen){
            mobileMenu.classList.remove('open');
            mobileMenu.classList.add('max-h-0');
        }else{
            mobileMenu.classList.remove('max-h-0');
            mobileMenu.classList.add('open');
        }
    }
</script>