-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 01:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `card_holder` varchar(255) DEFAULT NULL,
  `expiry_date` varchar(10) DEFAULT NULL,
  `cvv` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `lastname`, `email`, `password`, `phone`, `address`, `city`, `state`, `zipcode`, `country`, `card_number`, `card_holder`, `expiry_date`, `cvv`) VALUES
(4, 'Name', 'Lastname', 'test@test.com', '123', '123456', 'Helsinki', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Nimi', 'Sukunimi', 'mail@com', 'qwe', '098765433', 'Osoite2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'test2', 'testinen2', 'gmail@com', '123', '123456788754234', 'Lohja2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'julia', 'ivanska', 'julia@fi', '123', '333666', 'lohja 08350', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'vfhb', 'dgfddfg', 'test@mail', '123', '+67964656455435', 'fgdgfdg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '', '', 'test2@mail', '123', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'mari', 'vyl', 'maria@mail', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Yuliia', 'Ivanska', 'kova@gmail.com', '123', '+9950466331676', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'Yuliia', 'Ivansk', 'ivanskayulia.yunavili@gmail.com', '123', '+19729530', 'Sahakatu 2', 'Routio', 'Uusimaa', '08100', 'Finland', '1111111111111111', 'aa aa', '11/11', '111');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price_alv` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_method` enum('door_delivery','post_office','pickup') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `total_price_alv`, `delivery_method`) VALUES
(5, 8, '2025-02-12 13:15:12', 37.00, 'door_delivery'),
(6, 8, '2025-02-12 13:16:17', 4.50, 'door_delivery'),
(7, 11, '2025-02-25 17:02:20', 275.00, 'door_delivery'),
(8, 10, '2025-02-25 18:07:48', 49.00, 'door_delivery'),
(9, 10, '2025-02-27 09:12:12', 40.00, 'door_delivery'),
(10, 10, '2025-02-27 09:14:47', 27.00, 'door_delivery'),
(11, 10, '2025-02-27 09:44:44', 251.65, 'door_delivery'),
(12, 10, '2025-02-27 09:53:30', 62.75, 'door_delivery'),
(13, 10, '2025-02-27 09:57:27', 12.55, 'door_delivery'),
(16, 9, '2025-02-27 18:13:29', 61.50, 'door_delivery'),
(17, 84, '2025-03-01 22:04:53', 69.03, 'door_delivery'),
(18, 84, '2025-03-01 22:05:42', 5.65, 'door_delivery'),
(19, 77, '2025-03-03 17:21:34', 61.50, 'door_delivery'),
(20, 84, '2025-03-04 18:38:20', 0.00, 'post_office'),
(21, 84, '2025-03-04 19:29:26', 75.94, 'door_delivery'),
(22, 84, '2025-03-04 19:33:43', 13.18, 'door_delivery'),
(23, 84, '2025-03-04 19:39:50', 61.50, 'pickup'),
(24, 84, '2025-03-04 19:44:33', 0.00, 'pickup'),
(25, 84, '2025-03-04 19:46:06', 0.00, 'pickup'),
(26, 84, '2025-03-04 19:47:08', 0.00, 'door_delivery'),
(27, 84, '2025-03-04 20:03:13', 7.53, 'post_office'),
(28, 84, '2025-03-04 20:10:15', 0.00, 'door_delivery'),
(29, 84, '2025-03-04 20:11:04', 77.82, 'pickup'),
(30, 84, '2025-03-05 13:53:23', 61.50, 'post_office'),
(31, 84, '2025-03-05 14:21:44', 85.98, 'pickup'),
(32, 84, '2025-03-05 14:47:38', 61.50, 'pickup'),
(33, 84, '2025-03-05 14:57:06', 61.50, 'door_delivery'),
(34, 84, '2025-03-05 15:06:37', 61.50, 'pickup'),
(35, 84, '2025-03-05 20:00:08', 253.53, 'pickup'),
(36, 84, '2025-03-06 15:53:00', 7.53, 'pickup');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_alv` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_alv`) VALUES
(12, 5, 2, 6, 4.50),
(13, 5, 24, 1, 10.00),
(14, 6, 2, 1, 4.50),
(17, 8, 6, 1, 49.00),
(18, 9, 9, 5, 8.00),
(19, 10, 2, 6, 4.50),
(20, 11, 2, 1, 5.65),
(21, 11, 6, 4, 61.50),
(24, 16, 6, 1, 61.50),
(25, 17, 6, 1, 61.50),
(26, 17, 7, 1, 7.53),
(27, 18, 2, 1, 5.65),
(28, 19, 6, 1, 61.50),
(29, 21, 6, 1, 61.50),
(30, 21, 2, 1, 5.65),
(31, 21, 8, 1, 8.79),
(32, 22, 2, 1, 5.65),
(33, 22, 7, 1, 7.53),
(34, 23, 6, 1, 61.50),
(35, 27, 7, 1, 7.53),
(36, 29, 6, 1, 61.50),
(37, 29, 7, 1, 7.53),
(38, 29, 8, 1, 8.79),
(39, 30, 6, 1, 61.50),
(40, 31, 6, 1, 61.50),
(41, 31, 2, 1, 5.65),
(42, 31, 12, 1, 8.79),
(43, 31, 11, 1, 10.04),
(44, 32, 6, 1, 61.50),
(45, 33, 6, 1, 61.50),
(46, 34, 6, 1, 61.50),
(47, 35, 7, 1, 7.53),
(48, 35, 6, 4, 61.50),
(49, 36, 7, 1, 7.53);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` enum('coffee','coffee_maker') NOT NULL,
  `brand` varchar(255) NOT NULL,
  `price_alv` decimal(10,2) GENERATED ALWAYS AS (`price` * 1.255) STORED
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image_url`, `category`, `brand`) VALUES
(2, 'Caffe Grano ROMA', '60% arabica 40% robusta', 4.50, 30, 'https://caffegrano.pl/wp-content/uploads/2019/08/ROMA-2.jpg', 'coffee', 'Caffe Grano'),
(6, 'Six Cup Classic CHEMEXÂ®', 'Includes a polished wood collar with leather tie.', 49.00, 2, 'https://chemexcoffeemaker.com/cdn/shop/files/cm-6a.jpg?v=1724186506&width=1800', 'coffee_maker', 'CHEMEX'),
(7, 'NOMADIC Interstate 5 Blend', 'An artisanal homage to the best of road trip coffee along the spine of California - 796 miles from Oregon to Mexico. Interstate 5 is a delicious brew thatâ€™s ready for an adventure. So fill up your thermos, put the top down, and hit the road!', 6.00, 25, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_Interstate5_BSC_720x.png?v=1526770044', 'coffee', 'NOMADIC'),
(8, 'NOMADIC Lone Pine Blend', 'Movie fans know Lone Pine as the stark and beautiful site of over 200 movie Westerns, with Mt Whitney watching over as the ever-present director. Our Lone Pine - delicious brewed and in espresso drinks - is quiet and expansive with a touch of  intrigue â€“ like the terrain and spirit of its namesake.', 7.00, 15, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_LonePine_f92a48df-18ab-480f-ac04-41d4e9163a79_720x.png?v=1526770450', 'coffee', 'NOMADIC'),
(9, 'NOMADIC La Brea Tar Pits', 'Here\'s a flavorful dark bean blend bubbling up for a bold and ballsy brew. Enjoy La Brea Tar Pits Blend black as the night or smooth/sweet with cream/sugar. The La Brea Tar Pits, in the heart of Los Angeles, was formed over 35,000 years ago and our dark roast is a deep, smoky testimonial to this natural wonder.', 8.00, 12, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_LaBrea_720x.png?v=1526770528', 'coffee', 'NOMADIC'),
(10, 'NOMADIC Organic Ethiopia Yirgacheffe Kochere', 'The Yirgacheffe Coffee Farmers Cooperative Union (YCFCU) represents more than 300,000 families and indirectly supports the livelihoods and daily survival of more than 15 million people in Ethiopia, through high-quality coffee production. Located in Gedeo, Southern Ethiopia, YCFCU was founded in 2002 and represents 23 member cooperatives.', 7.00, 10, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_Ethiopia_720x.png?v=1563477444', 'coffee', 'NOMADIC'),
(11, 'NOMADIC Organic Guatemala', 'There are plenty of obstacles to cultivating and exporting coffee from the department of Huehuetenango. The terrain is rugged, and the weather is extreme. But coffee grows well here, and 634 families with farms that average just a few acres in size work together through a cooperative called Guayaâ€™b AsociaciÃ³n Civil (GUAYAâ€™B) to overcome the obstacles.', 8.00, 13, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_GuatemalaNew_720x.png?v=1623625709', 'coffee', 'NOMADIC'),
(12, 'NOMADIC Organic Peru', 'PERU ORGANIC NORTE is sourced from family owned farms organized around the Central Fronteriza del Norte de Cafetaleros (CENFROCAFE), which is an umbrella cooperative established in 1999 that supports 80 organizations and 2,000 coffee producers in the region of Cajamarca, Peru. CENFROCAFE provides training and financing aimed at improving coffee quality and yields to increase farmer earnings.', 7.00, 15, 'https://nomadiccoffee.com/cdn/shop/products/nmdc_0001_peru_720x.png?v=1611518977', 'coffee', 'NOMADIC'),
(13, 'NOMADIC Tioga Pass', 'When hiking the Pacific Crest Trail, your mind is free - almost. Youâ€™re actually thinking about building a fire and settling down with a cup of coffee. This coffee, to be specific. Balanced and bright, Tioga Pass Blend is campfire coffee - elevated. Delicious when brewed indoors too.', 6.00, 8, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_TiogaPass_720x.png?v=1526770380', 'coffee', 'NOMADIC'),
(14, 'NOMADIC Organic Sumatra', 'This Golden Gayo was sourced directly from Aceh. Coffee is processed at the mill in Aceh and sent to Medan for more sorting (hand-picking) before export. As the coffee farms are owned by small-holder farmers, it can be a challenge sometimes to control the quality, however the PT. Indo Cafco team are always very careful and selective throughout the production process to ensure consistency in the cups. Pt. Indo Cafco consists of not only quality control staff but also field agronomists. The focus of the field agronomists are to introduce sustainable farming techniques at farms, from picking the right cherries to pruning methods and the use of organic fertilizers. The hope is to ensure that our supply chain communities continue to grow and prosper for years to come.', 8.00, 20, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_Sumatra_720x.png?v=1595449645', 'coffee', 'NOMADIC'),
(15, 'NOMADIC San Pablo', 'There is no one neighborhood or city that truly can encompass everything that the East Bay is. But there is one street that seems to guide you through the East Bayâ€™s many shifting realities: San Pablo Avenue.\" Inspired by SPA and the words of talented writer Abraham Woodliff comes our most prolific espresso which straddles the medium>dark divide, and rides it home.', 6.00, 25, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_SanPablo_720x.png?v=1539366568', 'coffee', 'NOMADIC'),
(16, 'NOMADIC Amargosa', 'Dark espresso needs the right inspiration. We draw ours from the Amargosa River at the base of the Panamint Mountains. Amargosa, yes, bitter, but the good and calming bitters that stimulate your taste buds as an honorable handshake in the night.', 7.00, 15, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_Amargosa_720x.png?v=1539036346', 'coffee', 'NOMADIC'),
(17, 'NOMADIC Decaf', 'Swiss Water Process (SWP) decaffeinated coffees are free of added chemicals and processed using the cleanest water possible. SWP is also dedicated to aiding initiatives that support sustainability and the livelihoods of producers around the world.', 8.00, 8, 'https://nomadiccoffee.com/cdn/shop/files/NMDC_0001_DefaultDecaf_copy_720x.png?v=1705875667', 'coffee', 'NOMADIC'),
(18, 'NOMADIC Tinker Knob', 'Trail dust, afternoon rainsteam on hot granite, trusty, reliable, hyper palatable Tinker Knob. TK is an overlook on the Pacific Crest Trail. If you know \'Knob\' is 19th century slang for Nose, a shot of this steady and medium roasted espresso will give you an enlightened view.', 7.00, 10, 'https://nomadiccoffee.com/cdn/shop/products/NMDC_0001_TinkerKnob_720x.png?v=1539035581', 'coffee', 'NOMADIC'),
(19, 'Caffe Grano COMO', '70% arabica 30% robusta', 6.00, 15, 'https://caffegrano.pl/wp-content/uploads/2019/08/COMO-3.jpg', 'coffee', 'Caffe Grano'),
(20, 'Caffe Grano RIO', '100% arabica', 6.00, 16, 'https://caffegrano.pl/wp-content/uploads/2019/09/RIO-2-e1651067167934.jpg', 'coffee', 'Caffe Grano'),
(21, 'Caffe Grano BARI', '100% arabica', 6.00, 12, 'https://caffegrano.pl/wp-content/uploads/2019/08/BARI-2-e1651066923699.jpg', 'coffee', 'Caffe Grano'),
(22, 'Hario V60 Range Server', 'Hario\'s V60 range server has become the standard carafe for manual brewing in homes and cafes alike. Tough glass is formed to complement the style of the V60 dripper and is paired with a glass lid and rubber seal to maximize thermal stability. They\'re available in three practical sizes, any of which will make a beautiful addition to your pour-over setup.', 25.00, 5, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/8512/90803/hario-v60-range-server-clear-300-01__19712.1597185225.jpg?c=1&imbypass=on&_gl=1*1pjif3p*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVP', 'coffee_maker', 'Hario'),
(23, 'Hario V60 Glass Dripper with Olivewood', 'The Hario V60 has become one of the most popular manual coffee brewers available, going from odd design, to specialty coffee mainstream in a short time. Whether you\'re a manual coffee brewing beginner, home-brewing coffee aficionado, or barista, the V60 is sure to cross your path at some point. What exactly makes the V60 so appealing? For starters, the V60 can brew an amazing cup of coffee. This is due to the unique design of the V60 which allows coffee to escape through both the sides of the brewer and the bottom. This helps create a nice even coffee brew. In addition, the V60 is simple and easy to clean up. The 01 size is perfect for 1-2 small cups of coffee, while the 02 size will brew up to 4.', 30.00, 5, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/8465/90605/hario-v60-dripper-olivewood-02__10147.1601910743.jpg?c=1&imbypass=on&_gl=1*qwvyjq*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPRZ2E*M', 'coffee_maker', 'Hario'),
(24, 'Hario V60 Coffee Dripper Size 02', 'The ceramic V60 features high-quality ceramic showcased by the glossy appearance.The style of the ceramic V60 02 will fit perfectly in any environment.', 10.00, 5, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/8440/90515/hario-v60-02-dripper-ceramic-white__68615.1600452350.jpg?c=1&imbypass=on&_gl=1*1ogu84j*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPR', 'coffee_maker', 'Hario'),
(25, 'Hario Coffee Dripper V60 Size 03 Clear Plastic', 'The Hario V60 has become one of the most popular manual coffee brewers available, going from odd design, to specialty coffee mainstream in a short time. Whether you\'re a manual coffee brewing beginner, home-brewing coffee aficionado, or barista, the V60 is sure to cross your path at some point. What exactly makes the V60 so appealing? For starters, the V60 can brew an amazing cup of coffee. This is due to the unique design of the V60 which allows coffee to escape through both the sides of the brewer and the bottom. This helps create a nice even coffee brew. In addition, the V60 is simple and easy to clean up. This model of the V60 is the Hario V60 03. This size is built to brew coffee for 3-4 people (max volume of ~1.5L).', 12.00, 5, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/8461/91101/hario-v60-size-03-th__76283.1602007208.jpg?c=1&imbypass=on&_gl=1*1a4l9mi*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPRZ2E*MTczOTM1MD', 'coffee_maker', 'Hario'),
(26, 'Hario Coffee Siphon NEXT', 'The shape of the NEXT Siphon makes a strong statement. Straight lines and soft colors have been replaced with sleek curves and sharp black-and-chrome contrast (that\'s right, no more brown handle). The walls of the brewing chamber lean out at wide angles, expanding the siphon\'s physical presence and pushing the limits of conventional design. And that goofy bulb of a bowl is no more; the new lower chamber\'s flat bottom has a stronger look and even holds more coffee.', 95.00, 2, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/8290/89835/hario-coffee-siphon-next-side__39043.1597182893.jpg?c=1&imbypass=on&_gl=1*1sw034n*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPRZ2E*M', 'coffee_maker', 'Hario'),
(27, 'Hario Server V60 1000 ml Clear Glass', 'In Japanese, HARIO means \"The King of Glass\". Since its founding in 1921, this Japanese company has been manufacturing glassware of the highest quality for general consumers and for industrial uses. Hario\'s line of servers is designed to work with their V60 style of pourover coffee brewers.', 15.00, 5, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/8456/90571/glass-server-1000ml__76097.1597184704.jpg?c=1&imbypass=on&_gl=1*r6nt8h*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPRZ2E*MTczOTM1MDkw', 'coffee_maker', 'Hario'),
(28, 'AeroPress Original Coffee Maker', 'When thinking about iconic coffee brewers, the AeroPress Original Coffee Maker certainly makes the list, and for good reason. Despite being invented in just 2005, the AeroPress has amassed a tremendous following; mostly due to its ability to brew phenomenal coffee by the cup instead of batch brewing several cups at one time. As a total immersion brewer, all that is needed is the right water, a micro-filter paper, your favorite coffee, and the AeroPress, and you\'ll have a sweet, balanced cup in your hands in minutes.', 30.00, 7, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/7835/94048/aeropress-wbg-1__16672.1650898311.jpg?c=1&imbypass=on&_gl=1*i2revd*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPRZ2E*MTczOTM1MDkwMC4x', 'coffee_maker', 'AeroPress'),
(29, 'AeroPress Coffee Maker (Clear)', 'AeroPress Clear is constructed from Tritan plastic, a highly durable and crystal clear material that prevents coffee stains and is more dishwasher safe than the Original AeroPressâ€™s Polypropylene build material. The AeroPress is super lightweight, yet sturdy enough to haphazardly toss into any bag and head up the trail with no fear of damage. Thatâ€™s what makes it one of our favorite brewers ever!', 47.00, 2, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1280x1280/products/11267/95083/AeroPress_Clear_WBG__35397.1685125682.jpg?c=1&imbypass=on&_gl=1*1uzrm8g*_gcl_au*MTUyNDM4NjE3Mi4xNzM5MzUwOTAx*_ga*MTI0OTg1MDg1Ny4xNzM5MzUwOTAx*_ga_7Z2WVPRZ2E*MTczOTM1MD', 'coffee_maker', 'AeroPress'),
(30, 'AeroPress Coffee Filters Pack of 350', 'Extra Filters for the AeroPressÂ® Original Coffee Maker 350 count takes care of even the most avid coffee drinker\'s needs', 7.00, 24, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1920w/products/7784/87745/aeropress-filter-pack-wbg__66945.1597177670.jpg?c=1', 'coffee_maker', 'AeroPress'),
(31, 'Chemex Bonded White Circular Coffee Filters, 100 count', 'Known as a pristine coffeemaker, ChemexÂ® employs all of the chemically correct methods for brewing. Full bodied, richer flavor, from less coffee and as strong as you like without bitterness - that\'s what the ChemexÂ® filter gives you.', 8.00, 25, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1920w/products/8087/88850/chemex-bonded-filters-circles-white-100__89360.1597180726.jpg?c=1', 'coffee_maker', 'Chemex'),
(32, 'Chemex 10 Cup Coffee Maker - Classic & Glass Handle Styles', 'Simple function and visual elegance combine for the optimum extraction of full rich-bodied coffee. This hourglass shaped flask is made entirely of glass, a chemically inert material that does not absorb odors or chemical residues. Capacity: 10 cup/50 oz. Wood Collar Style includes a polished wood collar with leather tie. Glass Handle Style includes a graceful but sturdy glass handle.', 50.00, 2, 'https://cdn11.bigcommerce.com/s-6h7ychjk4/images/stencil/1920w/products/7439/87294/chemex-10-cup-classic-copy__15582.1597176097.jpg?c=1', 'coffee_maker', 'Chemex'),
(35, '', 'dlinnoye', 0.00, 0, '', 'coffee', ''),
(36, '', 'dlinnoye', 0.00, 0, '', 'coffee', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
