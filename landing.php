<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Ways Coffee Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
   
</head><link href="landstyle.css" rel="stylesheet" type="text/css">
<body class="bg-[#F5F3EE] text-[#333] font-sans">

<?php
// Include necessary files and establish database connection
include 'includes/db.php';
$disable_breadcrumbs = true;
include 'includes/header.php';

// Fetch category and brand from query parameters
$category = $_GET['category'] ?? 'all';
$brand = $_GET['brand'] ?? 'all';

// Get unique brand list from the database
$brandQuery = "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != ''";
$brandStmt = $db_connection->query($brandQuery);
$brands = $brandStmt->fetchAll(PDO::FETCH_COLUMN);

// Prepare and execute the query to fetch products
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($category !== 'all') {
    $query .= " AND category = ?";
    $params[] = $category;
}

if ($brand !== 'all') {
    $query .= " AND brand = ?";
    $params[] = $brand;
}

$stmt = $db_connection->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<section class="relative w-full flex flex-col justify-center items-center text-center px-6">
    <div class="banner relative" id="banner">
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="banner-text relative z-10">
            <h2 class="text-5xl font-bold mx-auto max-w-3xl leading-tight text-white">Your trusted source for premium coffee</h2>
            <p class="text-lg mt-4 max-w-xl mx-auto text-white">Providing top-quality coffee and professional equipment</p>
            <button onclick="window.location.href='index.php'" class="mt-6 bg-black text-white px-6 py-3 rounded-full text-lg hover:bg-gray-800 transition">Shop Now</button>
        </div>
    </div>
</section>


<!-- Product Carousel -->
<section class="py-10 px-6 relative ">
    <div class="flex flex-col items-start mb-4 w-full">
        <div class="marquee-container mt-10 mb-20 " id="marqueeContainer">
            <div class="marquee-text">After days</div>
            <div class="marquee-text">After days</div>
            <div class="marquee-text">After days</div>
        </div>
        <h3 class="text-4xl font-bold ml-3 mt-2">Our Products</h3>
        <div class="flex space-x-2 mt-4 ml-3 ">
            <button class="category-btn text-lg" data-category="coffee">Coffee</button>
            <span>/</span>
            <button class="category-btn text-lg" data-category="coffee_maker">Coffee Makers</button>
        </div>
    </div>
    <div class="carousel-container">
        <button id="prev" class="carousel-button bg-gray-800 text-white px-3 py-1.5 rounded-full hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </button>
        <div class="carousel-wrapper" id="carousel-wrapper">
            <?php foreach ($products as $product): ?>
                <div class="carousel-item bg-white border border-gray-200 mx-3 rounded-lg shadow-xl overflow-hidden flex flex-col" data-category="<?= htmlspecialchars($product['category']) ?>">
                    <img src="<?= htmlspecialchars($product['image_url'] ?: 'https://www.kahvitori.fi/images/lykke_happiness_500g_1.jpg') ?>" class="w-full p-4 mx-auto" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="flex flex-col justify-between p-4 h-full">
                        <div>
                            <h5 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($product['name'] ?? 'No name') ?></h5>
                            <p class="text-lg text-red-500 font-bold mt-1"><?= htmlspecialchars($product['price_alv'] ?? '0.00') ?> €</p>
                        </div>
                        <div class="flex items-center justify-center mt-4 mb-4">
                            <form action="product.php?id=<?= htmlspecialchars($product['id']) ?>" method="post" class="flex w-full">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-black text-white px-6 py-3 rounded-full w-full text-lg hover:bg-gray-800 transition">Shop Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button id="next" class="carousel-button bg-gray-800 text-white px-3 py-1.5 rounded-full hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>
</section>



<!-- New Section -->
<section class="py-32 px-6 max-w-4xl mx-auto text-center">
    <h3 class="text-7xl font-black leading-tight mb-8">Premium Coffee for True Enthusiasts</h3>
    <p class="text-2xl mt-4 max-w-2xl mx-auto leading-relaxed">Expertly crafted coffee and high-performance equipment tailored for home brewers. Roasted on demand for peak freshness and exceptional flavor.</p>
    <button onclick="window.location.href='index.php'" class="mt-10 bg-black text-white px-8 py-4 rounded-full text-2xl hover:bg-gray-800 transition">Browse Our Selection</button>
</section>


<!-- Map Section -->
<section class="py-20 px-6">
    <h3 class="text-4xl font-bold text-center mb-6">Find Us Here</h3>
    <div class="flex justify-center">
        <iframe
            width="600"
            height="450"
            style="border:0"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?q=Luksia%20Lohja&key=AIzaSyDZUdV7lOtz0A3m4OFoyGv7-HT70j2bh8M">
        </iframe>
    </div>
</section>



<script>
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    const categoryButtons = document.querySelectorAll('.category-btn');
    const carouselWrapper = document.getElementById('carousel-wrapper');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const itemWidth = carouselItems.length > 0 ? carouselItems[0].offsetWidth : 0;
    const visibleItems = 4;
    let currentIndex = 0;
    let totalItems = carouselItems.length;

    // Clone items to create an infinite loop effect
    carouselItems.forEach(item => {
        const clone = item.cloneNode(true);
        carouselWrapper.appendChild(clone);
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + visibleItems) % totalItems;
        updateCarousel();
    });

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - visibleItems + totalItems) % totalItems;
        updateCarousel();
    });

    categoryButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const category = e.target.getAttribute('data-category');
            document.querySelectorAll('.carousel-item').forEach(item => {
                if (category === 'all') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = item.getAttribute('data-category') === category ? 'flex' : 'none';
                }
            });
            currentIndex = 0;
            updateCarousel();
        });
    });

    function updateCarousel() {
        if (totalItems > 0) {
            const offset = -currentIndex * itemWidth;
            carouselWrapper.style.transform = `translateX(${offset}px)`;
        }
    }

    // Banner Slider
    const bannerElement = document.getElementById('banner');
    const banners = [
        'img/banner1.png',
        'img/banner2.png',
        'img/banner3.png'
    ];
    let currentBannerIndex = 0;

    function showBanner(index) {
        bannerElement.style.backgroundImage = `url('${banners[index]}')`;
    }

    setInterval(() => {
        currentBannerIndex = (currentBannerIndex + 1) % banners.length;
        showBanner(currentBannerIndex);
    }, 5000);

    // Initialize the first banner
    showBanner(currentBannerIndex);

    document.addEventListener('DOMContentLoaded', function() {
        const categoryButtons = document.querySelectorAll('.category-btn');

        // Function to update the selected category and filter products
        function selectCategory(category) {
            // Remove 'selected' class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('selected'));

            // Find the button with the specified category and add 'selected' class
            const selectedButton = document.querySelector(`.category-btn[data-category="${category}"]`);
            if (selectedButton) {
                selectedButton.classList.add('selected');
            }

            // Filter products based on the selected category
            document.querySelectorAll('.carousel-item').forEach(item => {
                if (category === 'all') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = item.getAttribute('data-category') === category ? 'flex' : 'none';
                }
            });

            // Reset carousel position
            currentIndex = 0;
            updateCarousel();
        }

        categoryButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const category = e.target.getAttribute('data-category');
                selectCategory(category);
            });
        });

        // Initialize the "Coffee" category as selected
        selectCategory('coffee');
        updateCarousel();
    });
    

    
</script>

</body>
<?php include 'includes/footer.php'; ?>
        </div>
    </body>