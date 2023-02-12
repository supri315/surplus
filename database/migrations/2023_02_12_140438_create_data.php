<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("INSERT INTO `categories` (`id`, `name`, `enable`, `created_at`, `updated_at`) VALUES
        (9, 'Elektronik', 1, '2023-02-11 09:52:05', '2023-02-11 09:52:05'),
        (10, 'Komputer & Aksesoris', 1, '2023-02-11 09:52:39', '2023-02-11 09:52:39'),
        (11, 'Handphone', 1, '2023-02-11 09:52:57', '2023-02-11 09:55:53'),
        (12, 'Pakaian Pria', 1, '2023-02-11 09:53:10', '2023-02-11 09:53:10'),
        (13, 'Sepatu Pria', 1, '2023-02-11 09:53:16', '2023-02-11 09:53:16'),
        (14, 'Tas Pria', 1, '2023-02-11 09:53:23', '2023-02-11 09:53:23'),
        (15, 'Jam Tangan', 1, '2023-02-11 09:53:35', '2023-02-11 09:53:35'),
        (16, 'Kesehatan', 1, '2023-02-11 09:53:42', '2023-02-11 09:53:42'),
        (17, 'Makanan & Minuman', 1, '2023-02-11 09:53:57', '2023-02-11 09:53:57'),
        (18, 'Pakaian Wanita', 1, '2023-02-11 09:54:09', '2023-02-11 09:54:09'),
        (19, 'Fashion Muslim', 1, '2023-02-11 09:54:20', '2023-02-11 09:54:20'),
        (20, 'Tas Wanita', 1, '2023-02-11 09:54:31', '2023-02-11 09:54:31'),
        (22, 'Hobi', 1, '2023-02-11 14:40:54', '2023-02-11 14:40:54'),
        (45, 'Perhiasan', 1, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (46, 'Barang antik', 1, '2023-02-12 13:53:32', '2023-02-12 13:53:32');");

        \DB::statement("INSERT INTO `category_products` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
        (1, 2, 9, '2023-02-11 10:04:17', '2023-02-11 10:04:17'),
        (2, 3, 9, '2023-02-11 10:04:22', '2023-02-11 10:04:22'),
        (3, 4, 9, '2023-02-11 10:04:26', '2023-02-11 10:04:26'),
        (4, 5, 9, '2023-02-11 10:04:30', '2023-02-11 10:04:30'),
        (5, 2, 22, '2023-02-11 21:41:19', '2023-02-11 21:41:20'),
        (33, 11, 9, '2023-02-11 18:10:46', '2023-02-11 18:10:46'),
        (34, 11, 10, '2023-02-11 18:10:46', '2023-02-11 18:10:46'),
        (49, 24, 45, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (50, 24, 46, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (51, 25, 9, '2023-02-12 13:58:06', '2023-02-12 13:58:06'),
        (52, 25, 10, '2023-02-12 13:58:06', '2023-02-12 13:58:06'),
        (53, 25, 11, '2023-02-12 13:58:06', '2023-02-12 13:58:06');");
        
        \DB::statement("INSERT INTO `images` (`id`, `name`, `file`, `enable`, `created_at`, `updated_at`) VALUES
        (2, 'Changhong 43 Inch (1)', 'http://localhost:8000/upload/image1676119697.png', 1, '2023-02-11 12:48:17', '2023-02-11 12:48:17'),
        (3, 'Changhong 43 Inch (2)', 'http://localhost:8000/upload/image1676119712.png', 1, '2023-02-11 12:48:32', '2023-02-11 12:48:32'),
        (4, 'Changhong 43 Inch (3)', 'http://localhost:8000/upload/image1676119721.png', 1, '2023-02-11 12:48:41', '2023-02-11 12:48:41'),
        (5, 'Tcl (1)', 'http://localhost:8000/upload/image1676119735.png', 1, '2023-02-11 12:48:55', '2023-02-11 12:48:55'),
        (6, 'Tcl (2)', 'http://localhost:8000/upload/image1676119741.png', 1, '2023-02-11 12:49:01', '2023-02-11 12:49:01'),
        (7, 'Tcl (3)', 'http://localhost:8000/upload/image1676119750.png', 1, '2023-02-11 12:49:10', '2023-02-11 12:49:10'),
        (8, 'Weyon (1)', 'http://localhost:8000/upload/image1676119769.png', 1, '2023-02-11 12:49:29', '2023-02-11 12:49:29'),
        (9, 'Weyon (2)', 'http://localhost:8000/upload/image1676119777.png', 1, '2023-02-11 12:49:37', '2023-02-11 12:49:37'),
        (10, 'Weyon (3)', 'http://localhost:8000/upload/image1676119785.png', 1, '2023-02-11 12:49:45', '2023-02-11 12:49:45'),
        (11, 'Xiaomi (1)', 'http://localhost:8000/upload/image1676119796.png', 1, '2023-02-11 12:49:56', '2023-02-11 12:49:56'),
        (12, 'Xiaomi (2)', 'http://localhost:8000/upload/image1676119812.png', 1, '2023-02-11 12:50:12', '2023-02-11 12:50:12'),
        (13, 'xiaomi 4', 'http://localhost:8000/upload/image1676119877.png', 1, '2023-02-11 12:50:25', '2023-02-11 12:51:17'),
        (16, 'changhong 30 inc (1)', 'http://localhost:8000/upload/image1676210012.png', 1, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (17, 'changhong 30 inc (2)', 'http://localhost:8000/upload/image1676210012.png', 1, '2023-02-12 13:53:32', '2023-02-12 13:53:32');");

        \DB::statement("INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
        (10, '2014_10_12_000000_create_users_table', 1),
        (11, '2014_10_12_100000_create_password_resets_table', 1),
        (12, '2019_08_19_000000_create_failed_jobs_table', 1),
        (13, '2019_12_14_000001_create_personal_access_tokens_table', 1),
        (14, '2023_02_08_130038_create_categories_table', 1),
        (15, '2023_02_08_130504_create_products_table', 1),
        (16, '2023_02_08_131650_create_category_products_table', 1),
        (17, '2023_02_08_131812_create_images_table', 1),
        (18, '2023_02_08_131950_create_product_images_table', 1);");

        \DB::statement("INSERT INTO `products` (`id`, `name`, `description`, `enable`, `created_at`, `updated_at`) VALUES
        (2, 'TCL 32 inch Smart LED TV - Android 11.0', 'TCL 32A7 SERIES, Best New Android TV. A+ Panel Quality, Feel the Comfortable', 1, '2023-02-11 10:00:49', '2023-02-11 10:00:49'),
        (3, 'Xiaomi Official A2 Smart TV 32 Android TV', 'Memiliki Remote control Bluetooth 360°. Kontrol Smart TV Anda dengan mudah menggunakan remote control Bluetooth 360°', 1, '2023-02-11 10:02:02', '2023-02-11 10:02:02'),
        (4, 'Weyon tv digital 21 inch HD tv led 24 inch', 'Weyon tv digital 21 inch HD tv led 24 inch Televisi(Model TCLG-W21/22/24/25/27/30inch)[Garansi 1 Tahun]', 1, '2023-02-11 10:02:44', '2023-02-11 10:02:44'),
        (5, 'Changhong 43 Inch Newest Android 11', 'Garansi Resmi Panel LED 3 Tahun', 1, '2023-02-11 10:03:18', '2023-02-11 10:03:18'),
        (11, 'Changhong 41 Inch Newest Android 11', 'Garansi Resmi Panel LED 3 Tahun', 1, '2023-02-11 17:54:41', '2023-02-11 18:10:46'),
        (24, 'Changhong 30 Inch Newest Android 11', 'Garansi Resmi Panel LED 3 Tahun', 1, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (25, 'Changhong 41 Inch Newest Android', 'Garansi Resmi Panel LED 3 Tahun', 1, '2023-02-12 13:58:06', '2023-02-12 13:58:06');");

        \DB::statement("INSERT INTO `product_images` (`id`, `product_id`, `image_id`, `created_at`, `updated_at`) VALUES
        (2, 5, 2, '2023-02-11 12:54:01', '2023-02-11 12:54:01'),
        (3, 5, 3, '2023-02-11 12:54:06', '2023-02-11 12:54:06'),
        (4, 5, 4, '2023-02-11 12:54:09', '2023-02-11 12:54:09'),
        (5, 2, 5, '2023-02-11 12:54:42', '2023-02-11 12:54:42'),
        (6, 2, 6, '2023-02-11 12:54:46', '2023-02-11 12:54:46'),
        (7, 2, 7, '2023-02-11 12:54:50', '2023-02-11 12:54:50'),
        (8, 4, 8, '2023-02-11 12:55:24', '2023-02-11 12:55:24'),
        (9, 4, 9, '2023-02-11 12:55:30', '2023-02-11 12:55:30'),
        (10, 4, 10, '2023-02-11 12:55:34', '2023-02-11 12:55:34'),
        (11, 3, 11, '2023-02-11 12:55:52', '2023-02-11 12:55:52'),
        (12, 3, 12, '2023-02-11 12:55:55', '2023-02-11 12:55:55'),
        (13, 3, 13, '2023-02-11 12:55:59', '2023-02-11 12:55:59'),
        (14, 10, 2, '2023-02-11 17:54:11', '2023-02-11 17:54:11'),
        (26, 11, 2, '2023-02-11 18:10:46', '2023-02-11 18:10:46'),
        (27, 24, 16, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (28, 24, 17, '2023-02-12 13:53:32', '2023-02-12 13:53:32'),
        (29, 25, 2, '2023-02-12 13:58:06', '2023-02-12 13:58:06'),
        (30, 25, 3, '2023-02-12 13:58:06', '2023-02-12 13:58:06');");
    }

}
