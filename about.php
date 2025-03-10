<?php 
include 'includes/header.php'; 
?>
<div class="container mx-auto">
    <!-- Intro Text -->
    <h2 class="text-center text-3xl font-semibold mb-8 text-gray-800">Contact Us</h2>
    <div class="text-center mb-8">
        <p class="text-lg text-gray-600">We are students of Tieto ja viestintätekniikka perustutkinto, and this website was created as part of our project for work practice. Our task was to create a functional online store.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Left Column: Address and Contact Info -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-xl p-6 col-span-1">
            <div class="mb-6">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-map-marker-alt text-gray-700 h-8 w-8"></i>
                    <span class="text-lg text-gray-700 font-semibold">Our Address</span>
                </div>
                <p class="text-gray-600">Luksia, Länsi-Uudenmaan koulutuskuntayhtymä<br>Toivonkatu 4, 08100 Lohja</p>
                <a href="https://maps.google.com/?q=Toivonkatu+4,+08100+Lohja" target="_blank" class="text-blue-500">View on map</a>
            </div>
            <div class="mb-6">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-envelope text-gray-700 h-8 w-8"></i>
                    <span class="text-lg text-gray-700 font-semibold">Contact Us</span>
                </div>
                <p class="text-gray-600">Email: <a href="mailto:luksiacoffeeshop@gmail.com" class="text-blue-500">luksiacoffeeshop@gmail.com</a></p>
            </div>
        </div>

        <!-- Right Column: Contact Form -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-xl p-6 col-span-2">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Leave Us a Message</h3>
            <form action="send_message.php" method="post">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold">Your Name</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 mt-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your name">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold">Your Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 mt-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your email">
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 font-semibold">Message</label>
                    <textarea id="message" name="message" required class="w-full px-4 py-3 mt-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="5" placeholder="Your message"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-200 w-full">Send Message</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>