<?php
session_start();

include 'connect.php';

if(mysqli_query($db_conx, "SELECT * FROM users")){
	header("Location:/index.html");
}

function display_error($error){
	$str = "";
	foreach($error as $key => $value){
		$str .= "<li class='error'>$value</li>";
	}
	return $str;
}

function sanitize($link,$item){
	$item = trim($item);
	$item = stripslashes($item);
	return mysqli_real_escape_string($link, $item);
};

function create_table($link, $data, $blog_name){

  $table_user = "CREATE TABLE `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    `user_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `user_image` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
    `user_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `user_register` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	$data['user_password'] = sha1($data['user_password']);
	$data['user_image'] = './includes/blogthebuilder.png';
  $fields = implode(',', array_keys($data));
  $values = '\'' . implode('\', \'', $data) . '\'';

  $table_user_dump="INSERT INTO `users` ($fields) VALUES($values)";

  $table_activity = "CREATE TABLE `activity` (
    `activity_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `activity_ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `activity_type` enum('blogView','postView','comment','share','workspace') COLLATE utf8_unicode_ci NOT NULL,
    `activity_to` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `activity_from` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
    `activity_time` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";
  $table_category = "CREATE TABLE `categories` (
    `category_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    `category_popularity` int(11) NOT NULL DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";
  $table_comments = "CREATE TABLE `comments` (
    `comment_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post_access` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `comment_author_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `comment_author_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `comment_author_IP` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
    `comment_content` longtext COLLATE utf8_unicode_ci NOT NULL,
    `comment_date_gmt` datetime NOT NULL,
    `comment_approved` enum('public','notapproved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
    `comment_parent` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
    `comment_type` enum('comment','reply') COLLATE utf8_unicode_ci NOT NULL,
    `accessHash` varchar(40) COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";
  $table_locale = "CREATE TABLE `locale` (
    `locale_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `locale_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";
  $table_locale_dump = "INSERT INTO `locale` (`locale_name`, `locale_code`) VALUES
  ('English - United States', 'EN-US'),
  ('English - Great Britain', 'EN-GB'),
  ('English - India', 'EN-IN');
  ";
  $table_plugin_catalog = "CREATE TABLE `plugin_catalog` (
    `plugin_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `plugin_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `plugin_cache_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    `plugin_creator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `plugin_selected` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
    `plugin_access` varchar(40) COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";

	$table_plugin_catalog_dump = "INSERT INTO `plugin_catalog` (`plugin_id`, `plugin_name`, `plugin_cache_location`, `plugin_creator`, `plugin_selected`, `plugin_access`) VALUES
	(1, 'Digital Clock', 'digitalClock', 'Anshul Wagadre', 'yes', '211d336f5c6e295058693c306752dde00ed55ea4'),
	(2, 'Today''s Date', 'dateToday', 'Anshul Wagadre', 'yes', '5d1a4bc3451e5453d81637908d2c7c4d5a823676');
	";

  $table_posts = "CREATE TABLE `posts` (
    `post_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post_title` text COLLATE utf8_unicode_ci NOT NULL,
    `post_content` longtext COLLATE utf8_unicode_ci NOT NULL,
    `post_date_gmt` datetime NOT NULL,
    `post_excerpt` longtext COLLATE utf8_unicode_ci NOT NULL,
    `post_status` enum('publish','draft','unpublish','delete') COLLATE utf8_unicode_ci NOT NULL,
    `post_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    `post_modified_gmt` datetime NOT NULL,
    `post_view_count` bigint(20) NOT NULL DEFAULT '0',
    `post_comment_count` bigint(20) NOT NULL,
    `post_share_count` bigint(20) NOT NULL DEFAULT '0',
    `post_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `post_tags` longtext COLLATE utf8_unicode_ci NOT NULL,
    `post_user` int(11) NOT NULL,
    `accessHash` varchar(40) COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";

	$table_posts_dump = "INSERT INTO `posts` (`post_id`, `post_title`, `post_content`, `post_date_gmt`, `post_excerpt`, `post_status`, `post_name`, `post_modified_gmt`, `post_view_count`, `post_comment_count`, `post_share_count`, `post_category`, `post_tags`, `post_user`, `accessHash`) VALUES
  (1, 'Global Warming 2', '&lt;h1&gt;Global Warming&lt;/h1&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;p style=&quot;margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sem eros, lacinia id egestas dignissim, placerat vitae lacus. Nulla in scelerisque leo, ac pharetra lectus. Proin ut est eu mi lobortis efficitur in viverra neque. Nulla facilisi. Vestibulum ut semper felis. Fusce augue tellus, mattis et porta vitae, facilisis hendrerit risus. Morbi rutrum lacus diam, quis mollis nunc vehicula ac. Praesent ornare nisl sed sodales ornare. Pellentesque in eros maximus, rutrum sapien quis, interdum tortor. Maecenas volutpat ac lacus tincidunt egestas. Praesent sed felis justo.&lt;/p&gt;&lt;p style=&quot;margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc cursus risus est, quis tincidunt mauris sollicitudin suscipit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla ut nibh ac massa dictum rutrum ac at velit. Duis nisl nunc, ultricies et mi nec, posuere sagittis nunc. Nunc mollis, odio id placerat ullamcorper, erat ante tincidunt magna, ac dapibus turpis velit sed ante. Suspendisse at congue nulla.&lt;/p&gt;&lt;p style=&quot;margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Nulla fringilla lacus viverra luctus aliquet. Cras dui ipsum, iaculis eu gravida vel, porta quis massa. Sed sagittis finibus dolor in posuere. Sed quis sem ligula. Phasellus posuere sapien ipsum, eget maximus ipsum pretium quis. Nunc tincidunt diam massa. In viverra, libero ac molestie imperdiet, lectus nibh viverra sapien, vitae porta felis nisl vitae nisi. Aenean sit amet ex finibus lectus ornare iaculis non et odio. Nam vulputate quam id ornare rutrum. Ut pellentesque nibh mauris, vel ornare metus vehicula vitae. Sed turpis nisl, aliquet a pretium vel, molestie sit amet enim. Donec purus felis, pellentesque ac eleifend vel, interdum nec ipsum.&lt;/p&gt;&lt;p style=&quot;margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Donec ultricies dictum erat vitae iaculis. Pellentesque ultrices justo ut faucibus hendrerit. Morbi vitae odio et orci lobortis molestie. Phasellus dignissim ligula sed lectus porttitor finibus. Morbi mattis lorem eu risus vehicula tincidunt. Mauris sit amet turpis non est facilisis fringilla. Ut at tincidunt mauris. Ut risus nisi, luctus at posuere finibus, eleifend dictum dolor. Curabitur sit amet elit vel urna venenatis tincidunt id at ligula. Duis semper ornare augue at egestas. Ut egestas ipsum et mauris tincidunt varius. Aliquam vulputate tempus porttitor.&lt;/p&gt;&lt;p style=&quot;margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Pellentesque tempus scelerisque mauris, sed auctor lorem venenatis id. Duis dapibus pulvinar nunc ac finibus. Etiam in enim semper, dapibus mauris vitae, tempus felis. Mauris volutpat nisl sit amet pretium vulputate. Aliquam tincidunt purus a ligula ullamcorper luctus. Vivamus eget sollicitudin magna, sit amet porttitor erat. Mauris magna magna, tincidunt nec efficitur eget, elementum sed nisi. Quisque lobortis pretium enim, sit amet rutrum justo. Donec eget suscipit arcu. Mauris ut interdum diam. Quisque vitae lectus mauris.&lt;/p&gt;', '2017-04-28 13:49:52', '', 'publish', 'globalwarming2', '2017-04-28 19:01:34', 32, 3, 0, 'Environment', 'globalwarming,nothingelse', 1, '4ab077833d921b30f5d02f3576b3405e87bea778'),
  (2, 'Sample Post 2', '&lt;h2&gt;This is second sample post I this section you can edit posts&lt;/h2&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;this aren''t looking so goog are they !@#$%^&amp;amp;*()_+{}|L:&quot;/*-~&lt;/div&gt;', '2017-04-28 19:24:37', 'just and excerpt', 'publish', 'samplepost', '2017-04-28 19:28:51', 0, 0, 0, 'Environment', 'sample,no,two', 1, '03661ead9b5cd057d01dc244f384c379a1bdea15');
  ";

  $table_settings = "CREATE TABLE `settings` (
    `setting_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `settings_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    `settings_value` longtext COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";

  $table_settings_dump = "INSERT INTO `settings` (`setting_id`, `settings_name`, `settings_value`) VALUES
  (1, 'blog_title', '$blog_name'),
  (2, 'blog_tagline', 'Tagline Goes Here'),
  (3, 'blog_locale', 'English - India'),
  (4, 'blog_timezone_name', 'Kolkata'),
  (6, 'blog_comment_settings', 'private'),
  (7, 'blog_comment_moderation', 'always'),
  (8, 'blog_allow_captcha', 'false'),
  (9, 'blog_email_notification', 'false'),
  (10, 'blog_ftp_host', ''),
  (11, 'blog_ftp_user', ''),
  (12, 'blog_ftp_password', ''),
  (13, 'blog_email_host', ''),
  (14, 'blog_email_user', ''),
  (15, 'blog_email_password', '');
  ";

  $table_template_cache = "CREATE TABLE `template_cache` (
    `template_cache_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `setting_display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `template_cache_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `template_cache_value` longtext COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";

  $table_template_cache_dump = "INSERT INTO `template_cache` (`template_cache_id`, `setting_display_name`, `template_cache_name`, `template_cache_value`) VALUES
  (1, 'Home Content', 'home_content', 'This is section controls the content on home page. To change this content please login on your dashboard by youwebsite/dashboard.html use the credentials you used while installation procedure and under appearance > edit website content'),
  (2, 'About Content', 'about_content', 'This is section controls the content on about us page. To change this content please login on your dashboard by youwebsite/dashboard.html use the credentials you used while installation procedure and under appearance > edit website content'),
  (3, 'Contact Content', 'contact_content', 'This is section controls the content on contact us page. To change this content please login on your dashboard by youwebsite/dashboard.html use the credentials you used while installation procedure and under appearance > edit website content'),
  (4, 'Home Title', 'home_title', 'Home'),
  (5, 'About Title', 'about_title', 'About Us'),
  (6, 'Contact Title', 'contact_title', 'Contact Us'),
  (7, 'Post Title', 'post_title', 'Our Posts'),
  (8, 'Plugin Title', 'plugin_title', 'Widgets'),
  (9, 'Post Display', 'posts_organisation', 'card'),
  (10, 'Contact SideBar', 'contact_on_sidebar', 'false'),
  (11, 'Contact Email', 'contact_content_email', 'johndoe@domain.com'),
  (12, 'Contact Number', 'contact_content_number', '(553)54-666-522'),
  (13, 'Contact Address', 'contact_content_address', 'Address to Some Place'),
  (14, 'Contact City', 'contact_content_city', 'City'),
  (15, 'Contact State', 'contact_content_state', 'State'),
  (16, 'Contact Country', 'contact_content_country', 'Country'),
  (17, 'Home Disable', 'home_page_disabled', 'false'),
  (18, 'About Disabled', 'about_page_disabled', 'false'),
  (19, 'Contact Disabled', 'contact_page_disabled', 'false'),
  (20, 'Plugin Disabled', 'plugin_disabled', 'false');
  ";

  $table_template_catalog = "CREATE TABLE `template_catalog` (
    `template_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `template_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `theme_display` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
    `template_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `template_cache_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    `template_creator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `template_created_on` datetime NOT NULL,
    `template_active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
    `accessHash` varchar(40) COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";

	$table_template_catalog_dump = "INSERT INTO `template_catalog` (`template_id`, `template_name`, `theme_display`, `template_category`, `template_cache_location`, `template_creator`, `template_created_on`, `template_active`, `accessHash`) VALUES
  (1, 'Bharath Default', '/resource/display.png', 'default', 'bharathDefault', 'Bharath Subramaniam', '2017-04-20 07:07:23', 'no', 'da426b70a1adc332a89d80d4726ac2aa085120ba'),
  (2, 'Minecraft classic', '/resource/display.jpg', 'Game', 'minecraftClassic', 'Anshul Wagadre', '2017-04-20 08:05:35', 'yes', '364299bce926f210cbd67face6dd18091f2975db'),
  (3, 'Vertical Frame', '/resource/display.png', 'Classic', 'vertiTheme', 'Gurleen Saluja', '2017-04-26 00:00:00', 'no', 'e314e84b3b40c364aabe20b1f42e863ec53908f5'),
  (4, 'Multi Page', '/resource/display.png', 'classic', 'multiPage', 'Gurleen Saluja', '2017-04-26 00:00:00', 'no', 'THEME MULTI PAGE');
  ";

  $table_timezones = "CREATE TABLE `timezones` (
    `time_zone_offset` int(11) NOT NULL,
    `time_zone_representation` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `time_zone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ";
  $table_timezones_dump = "INSERT INTO `timezones` (`time_zone_offset`, `time_zone_representation`, `time_zone_name`) VALUES
  (-10, '(GMT-10:00)', ' Hawaii'),
  (-9, '(GMT-09:00)', ' Alaska'),
  (-8, '(GMT-08:00)', ' Pacific Time (US & Canada)'),
  (-7, '(GMT-07:00)', ' Arizona'),
  (-7, '(GMT-07:00)', ' Mountain Time (US & Canada)'),
  (-6, '(GMT-06:00)', ' Central Time (US & Canada)'),
  (-5, '(GMT-05:00)', ' Eastern Time (US & Canada)'),
  (-5, '(GMT-05:00)', ' Indiana (East)'),
  (-12, '(GMT-12:00)', ' International Date Line West'),
  (-11, '(GMT-11:00)', ' Midway Island'),
  (-11, '(GMT-11:00)', ' Samoa'),
  (-8, '(GMT-08:00)', ' Tijuana'),
  (-7, '(GMT-07:00)', ' Chihuahua'),
  (-7, '(GMT-07:00)', ' La Paz'),
  (-7, '(GMT-07:00)', ' Mazatlan'),
  (-6, '(GMT-06:00)', ' Central America'),
  (-6, '(GMT-06:00)', ' Guadalajara'),
  (-6, '(GMT-06:00)', ' Mexico City'),
  (-6, '(GMT-06:00)', ' Monterrey'),
  (-6, '(GMT-06:00)', ' Saskatchewan'),
  (-5, '(GMT-05:00)', ' Bogota'),
  (-5, '(GMT-05:00)', ' Lima'),
  (-5, '(GMT-05:00)', ' Quito'),
  (-4, '(GMT-04:00)', ' Atlantic Time (Canada)'),
  (-4, '(GMT-04:00)', ' Caracas'),
  (-4, '(GMT-04:00)', ' La Paz'),
  (-4, '(GMT-04:00)', ' Santiago'),
  (-4, '(GMT-03:30)', ' Newfoundland'),
  (-3, '(GMT-03:00)', ' Brasilia'),
  (-3, '(GMT-03:00)', ' Buenos Aires'),
  (-3, '(GMT-03:00)', ' Georgetown'),
  (-3, '(GMT-03:00)', ' Greenland'),
  (-2, '(GMT-02:00)', ' Mid-Atlantic'),
  (-1, '(GMT-01:00)', ' Azores'),
  (-1, '(GMT-01:00)', ' Cape Verde Is.'),
  (0, '(GMT)', ' Casablanca'),
  (0, '(GMT)', ' Dublin'),
  (0, '(GMT)', ' Edinburgh'),
  (0, '(GMT)', ' Lisbon'),
  (0, '(GMT)', ' London'),
  (0, '(GMT)', ' Monrovia'),
  (1, '(GMT+01:00)', ' Amsterdam'),
  (1, '(GMT+01:00)', ' Belgrade'),
  (1, '(GMT+01:00)', ' Berlin'),
  (1, '(GMT+01:00)', ' Bern'),
  (1, '(GMT+01:00)', ' Bratislava'),
  (1, '(GMT+01:00)', ' Brussels'),
  (1, '(GMT+01:00)', ' Budapest'),
  (1, '(GMT+01:00)', ' Copenhagen'),
  (1, '(GMT+01:00)', ' Ljubljana'),
  (1, '(GMT+01:00)', ' Madrid'),
  (1, '(GMT+01:00)', ' Paris'),
  (1, '(GMT+01:00)', ' Prague'),
  (1, '(GMT+01:00)', ' Rome'),
  (1, '(GMT+01:00)', ' Sarajevo'),
  (1, '(GMT+01:00)', ' Skopje'),
  (1, '(GMT+01:00)', ' Stockholm'),
  (1, '(GMT+01:00)', ' Vienna'),
  (1, '(GMT+01:00)', ' Warsaw'),
  (1, '(GMT+01:00)', ' West Central Africa'),
  (1, '(GMT+01:00)', ' Zagreb'),
  (2, '(GMT+02:00)', ' Athens'),
  (2, '(GMT+02:00)', 'Bucharest'),
  (2, '(GMT+02:00)', ' Cairo'),
  (2, '(GMT+02:00)', ' Harare'),
  (2, '(GMT+02:00)', ' Helsinki'),
  (2, '(GMT+02:00)', ' Istanbul'),
  (2, '(GMT+02:00)', ' Jerusalem'),
  (2, '(GMT+02:00)', ' Kyev'),
  (2, '(GMT+02:00)', ' Minsk'),
  (2, '(GMT+02:00)', ' Pretoria'),
  (2, '(GMT+02:00)', ' Riga'),
  (2, '(GMT+02:00)', ' Sofia'),
  (2, '(GMT+02:00)', ' Tallinn'),
  (2, '(GMT+02:00)', ' Vilnius'),
  (3, '(GMT+03:00)', ' Baghdad'),
  (3, '(GMT+03:00)', ' Kuwait'),
  (3, '(GMT+03:00)', ' Moscow'),
  (3, '(GMT+03:00)', ' Nairobi'),
  (3, '(GMT+03:00)', ' Riyadh'),
  (3, '(GMT+03:00)', ' St. Petersburg'),
  (3, '(GMT+03:00)', ' Volgograd'),
  (4, '(GMT+03:30)', ' Tehran'),
  (4, '(GMT+04:00)', ' Abu Dhabi'),
  (4, '(GMT+04:00)', ' Baku'),
  (4, '(GMT+04:00)', ' Muscat'),
  (4, '(GMT+04:00)', ' Tbilisi'),
  (4, '(GMT+04:00)', ' Yerevan'),
  (5, '(GMT+04:30)', ' Kabul'),
  (5, '(GMT+05:00)', ' Ekaterinburg'),
  (5, '(GMT+05:00)', ' Islamabad'),
  (5, '(GMT+05:00)', ' Karachi'),
  (5, '(GMT+05:00)', ' Tashkent'),
  (6, '(GMT+05:30)', ' Chennai'),
  (6, '(GMT+05:30)', ' Kolkata'),
  (6, '(GMT+05:30)', ' Mumbai'),
  (6, '(GMT+05:30)', ' New Delhi'),
  (6, '(GMT+05:45)', ' Kathmandu'),
  (6, '(GMT+06:00)', ' Almaty'),
  (6, '(GMT+06:00)', ' Astana'),
  (6, '(GMT+06:00)', ' Dhaka'),
  (6, '(GMT+06:00)', ' Novosibirsk'),
  (6, '(GMT+06:00)', ' Sri Jayawardenepura'),
  (7, '(GMT+06:30)', ' Rangoon'),
  (7, '(GMT+07:00)', ' Bangkok'),
  (7, '(GMT+07:00)', ' Hanoi'),
  (7, '(GMT+07:00)', ' Jakarta'),
  (7, '(GMT+07:00)', ' Krasnoyarsk'),
  (8, '(GMT+08:00)', ' Beijing'),
  (8, '(GMT+08:00)', ' Chongqing'),
  (8, '(GMT+08:00)', ' Hong Kong'),
  (8, '(GMT+08:00)', ' Irkutsk'),
  (8, '(GMT+08:00)', ' Kuala Lumpur'),
  (8, '(GMT+08:00)', ' Perth'),
  (8, '(GMT+08:00)', ' Singapore'),
  (8, '(GMT+08:00)', ' Taipei'),
  (8, '(GMT+08:00)', ' Ulaan Bataar'),
  (8, '(GMT+08:00)', ' Urumqi'),
  (9, '(GMT+09:00)', ' Osaka'),
  (9, '(GMT+09:00)', ' Sapporo'),
  (9, '(GMT+09:00)', ' Seoul'),
  (9, '(GMT+09:00)', ' Tokyo'),
  (9, '(GMT+09:00)', ' Yakutsk'),
  (10, '(GMT+09:30)', ' Adelaide'),
  (10, '(GMT+09:30)', ' Darwin'),
  (10, '(GMT+10:00)', ' Brisbane'),
  (10, '(GMT+10:00)', ' Canberra'),
  (10, '(GMT+10:00)', ' Guam'),
  (10, '(GMT+10:00)', ' Hobart'),
  (10, '(GMT+10:00)', ' Melbourne'),
  (10, '(GMT+10:00)', ' Port Moresby'),
  (10, '(GMT+10:00)', ' Sydney'),
  (10, '(GMT+10:00)', ' Vladivostok'),
  (11, '(GMT+11:00)', ' Magadan'),
  (11, '(GMT+11:00)', ' New Caledonia'),
  (11, '(GMT+11:00)', ' Solomon Is.'),
  (12, '(GMT+12:00)', ' Auckland'),
  (12, '(GMT+12:00)', ' Fiji'),
  (12, '(GMT+12:00)', ' Kamchatka'),
  (12, '(GMT+12:00)', ' Marshall Is.'),
  (12, '(GMT+12:00)', ' Wellington'),
  (13, '(GMT+13:00)', ' Nukualofa');
  ";

  mysqli_query($link, $table_activity) or die(mysqli_error($link));
  mysqli_query($link, $table_category) or die(mysqli_error($link));
  mysqli_query($link, $table_comments) or die(mysqli_error($link));
  mysqli_query($link, $table_locale) or die(mysqli_error($link));
  mysqli_query($link, $table_locale_dump) or die(mysqli_error($link));
  mysqli_query($link, $table_plugin_catalog) or die(mysqli_error($link));
	mysqli_query($link, $table_plugin_catalog_dump) or die(mysqli_error($link));
  mysqli_query($link, $table_posts) or die(mysqli_error($link));
  mysqli_query($link, $table_posts_dump) or die(mysqli_error($link));
  mysqli_query($link, $table_settings) or die(mysqli_error($link));
  mysqli_query($link, $table_settings_dump) or die(mysqli_error($link));
  mysqli_query($link, $table_template_cache) or die(mysqli_error($link));
  mysqli_query($link, $table_template_cache_dump) or die(mysqli_error($link));
  mysqli_query($link, $table_template_catalog) or die(mysqli_error($link));
	mysqli_query($link, $table_template_catalog_dump) or die(mysqli_error($link));
  mysqli_query($link, $table_timezones) or die(mysqli_error($link));
  mysqli_query($link, $table_timezones_dump) or die(mysqli_error($link));
	mysqli_query($link, $table_user) or die(mysqli_error($link));
	mysqli_query($link, $table_user_dump) or die(mysqli_error($link));

}


$error = array();


if(isset($_GET['action']) && $_GET['action'] == 'install'){
	$data = array();
	if(isset($_POST) && !empty($_POST)){
		foreach($_POST as $key => $value){
			if(empty($value)){
				$error[] = 'All Fields are required';
				break;
			}
			$data[$key] = sanitize($db_conx, $value);
		}
		if(empty($error)){
			if($data['user_password'] != $data['user_repass']){
				$error[] = 'Password doesn\'t match';
			}
		}
	}

	if(empty($error)){
		$blog_name = $data['blog_name'];
		unset($data['blog_name']);
		unset($data['user_repass']);
		$data['user_image'] = "./includes/blogthebuilder.jpg";
		$data['user_code'] = SHA1("USER".microtime().$data['user_email']);
		date_default_timezone_set('UTC');
		$data['user_register'] = date('Y-m-d H:i:s');
		//installation Script

		create_table($db_conx,$data,$blog_name);
		header('Location:index.html');
	}

}

?>

<html>

	<head>
		<link rel="stylesheet" type="text/css" href="CDN/bootstrap/css/bootstrap.min.css" />
		<script src="CDN/jquery.min.js"></script>
		<script src="CDN/bootstrap/js/bootstrap.min.js"></script>
		<style>
			.error-ul{
				padding: 0;
				margin: 0;
			}
			.error{
				list-style: none;
				background-color: #d93644;
				color: #FFF;
				padding:5px 10px;
				margin: 5px 0;
			}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-lg-4 col-sm-12 col-md-offset-4 col-lg-offset-4">
					<center>
						<h1>Blog The Builder<br /><small>Installation</small></h1>
					</center>
					<?php

						if(!empty($error)){
							echo '<ul class="error-ul">';
							echo display_error($error);
							echo '</ul>';
						}

					?>
					<form name="userForm" action="installation.php?action=install" method="post">
						<fieldset>
							<label>Name</label>
							<input class="form-control" type="text" value="<?php if(isset($_POST['user_name'])) echo $_POST['user_name'] ?>" placeholder="Enter Your Name" required name="user_name" />
						</fieldset>
						<br />
						<fieldset>
							<label>Blog Name</label>
				 			<input class="form-control" type="text" value="<?php if(isset($_POST['blog_name'])) echo $_POST['blog_name'] ?>" placeholder="Name of the blog" required name="blog_name" />
						</fieldset>
						<br />
						<fieldset>
							<label>E-mail</label>
				 			<input class="form-control" required type="email" placeholder="Email" value="<?php if(isset($_POST['user_email'])) echo $_POST['user_email'] ?>" name="user_email" />
						</fieldset>
						<br />
						<fieldset>
							<label>Password</label>
				 			<input class="form-control" type="password" required placeholder="Password" name="user_password" />
						</fieldset>
						<br />
						<fieldset>
							<label>Retype-Password</label>
				 			<input class="form-control" type="password" required placeholder="Retype Password" name="user_repass" />
						</fieldset>
						<br />
						<fieldset>
							<button class="btn btn-primary form-control" type="submit">Install</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>

</html>
