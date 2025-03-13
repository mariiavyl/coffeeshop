<?php 
include 'includes/header.php';
include 'includes/db.php';

function getProductsByBrand($db_connection, $brand) {
    $stmt = $db_connection->prepare("SELECT * FROM products WHERE brand = ? LIMIT 3");
    $stmt->execute([$brand]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$brands = [
    "Chemex" => "https://chemexcoffeemaker.com/pages/how-to-brew-with-chemex",
    "AeroPress" => "https://aeropress.com/pages/how-to-use",
    "Hario" => "https://samplecoffee.com.au/brewguides/hario-v60"
];

$images = [
    "Chemex" => "https://chemexcoffeemaker.com/cdn/shop/files/How-to-brew-header.jpg?v=1726515936&width=2400",
    "AeroPress" => "https://www.artisancoffeeco.com/cdn/shop/articles/Aeropress-01-Brew-Guide_Artisan-Coffee-Co_Header.jpg?v=1623158170",
    "Hario" => "https://www.javarepublic.com/wp-content/uploads/2021/01/IMG_5046.jpg"
];
?>

<body class="bg-gray-100">
<div class="flex flex-col h-screen justify-between">
<?php include 'navbar.php'?>
<h1 class="text-3xl font-bold text-center my-8">Learn More About Coffee and Brewing Methods</h1>
<p class="text-lg text-center mb-8">Here you can find information about different coffee brewing methods and how to use them.</p>

<div class="space-y-12">
    <?php foreach ($brands as $brand => $link): ?>
        <h2 class="text-2xl font-semibold text-center my-8 "><?= $brand ?> Brewing Method</h2>
        
        <a href="<?= $link ?>" target="_blank">
            <img src="<?= $images[$brand] ?>" alt="How to use <?= $brand ?>" class="w-full h-[600px] object-cover rounded-md shadow-md">
        </a>
        <p class="text-center text-xl">
            <a href="<?= $link ?>" target="_blank" class="text-blue-600 hover:underline">Read about how to use <?= $brand ?></a>
        </p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-12 mx-[4em]">
            <?php foreach (getProductsByBrand($db_connection, $brand) as $product): ?>
                <div class="bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden flex flex-col h-[512px]">
                    <?php
                    $imageUrl = !empty($product['image_url']) ? $product['image_url'] : '2.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($imageUrl) ?>" class="w-full p-4 h-[300px] object-cover mx-auto" alt="<?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?>">
                    <div class="flex flex-col justify-between p-4 h-full">
                        <div>
                            <h5 class="text-lg font-semibold text-gray-900"> <?= htmlspecialchars($product['name'] ?? 'No name') ?></h5>
                            <div class="flex justify-between items-center">
                                <p class="text-lg text-red-500 font-bold mt-1">
                                    <?= htmlspecialchars($product['price_alv'] ?? '0.00') ?> €
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Stock: <?= htmlspecialchars($product['stock'] ?? '0') ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center space-x-2 mt-4 mb-4">
                            <a href="product.php?id=<?= $product['id'] ?>&from=store" class="bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition-all duration-200">View Product</a>
                            <form action="cart.php" method="post" class="flex">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="px-6 py-3 rounded-full ml-2 transition-all duration-200 <?php echo ($product['stock'] > 0) ? 'bg-yellow-950 text-white hover:bg-gray-800' : 'bg-gray-400 text-gray-700 cursor-not-allowed'; ?>" <?php echo ($product['stock'] > 0) ? '' : 'disabled'; ?>>
                                    Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="flex justify-center items-center">
            <a href="index.php" class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">See All</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
</div>
