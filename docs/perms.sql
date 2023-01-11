INSERT INTO `permissions` (`id`, `parent_id`, `type`, `title`, `icon`, `path`, `slug`, `status`, `component`, `meta`, `created_at`, `updated_at`)
VALUES
    (1, NULL, 1, '概览', 'DataLine', '/', 'dash', 1, 'Dash.vue', NULL, '2023-01-11 23:12:58', NULL),
    (2, NULL, 0, '平台配置', 'Setting', '/platform', 'platform', 1, NULL, NULL, '2023-01-11 23:15:33', NULL),
    (3, 2, 1, '品牌管理', 'Flag', '/platform/brands', 'platform.brand', 1, 'Brand.vue', NULL, '2023-01-11 23:12:58', NULL),
    (4, 2, 1, '分类管理', 'Guide', '/platfrom/categories', 'platform.category', 1, 'Category.vue', NULL, '2023-01-11 23:12:58', NULL),
    (5, 2, 1, '配送管理', 'Van', '/platform/deliveries', 'platform.delivery', 1, 'Delivery.vue', NULL, '2023-01-11 23:12:58', NULL),
    (6, 2, 1, '产品管理', 'Van', '/platform/products', 'platform.product', 1, 'Product.vue', NULL, '2023-01-11 23:12:58', NULL),
    (7, 2, 1, '商品管理', 'Van', '/platform/goods', 'platform.goods', 1, 'Goods.vue', NULL, '2023-01-11 23:12:58', NULL),
    (8, 2, 1, '店铺管理', 'Shop', '/platform/stores', 'platform.store', 1, 'Store.vue', NULL, '2023-01-11 23:12:58', NULL);
