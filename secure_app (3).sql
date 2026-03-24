-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 12:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secure_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `gmail` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `gmail`, `password`, `created_at`) VALUES
(1, 'alex the admin', 'adlexadmin@gmail.com', '$2y$10$f1oSY.QzDrmxVgfjiQwFUOTSdMGpid0ahF8UYLvpv6yH4IWTuHQkW', '2026-03-08 03:36:11'),
(2, 'alex pogi123', 'alexpogi123@gmail.com', '$2y$10$5gwoFLopB7oBA9ec3ue5PuDzI8LMKvnhfciybW9e2iw6VRGwB0PY6', '2026-03-08 03:39:24');

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

CREATE TABLE `chat_logs` (
  `id` int(11) NOT NULL,
  `user_message` text NOT NULL,
  `bot_response` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`id`, `user_message`, `bot_response`, `created_at`) VALUES
(1, 'hi', 'I am currently offline. Please try again later.', '2026-03-19 05:43:53'),
(2, 'company', 'I am currently offline. Please try again later.', '2026-03-19 05:44:53'),
(3, 'Company', 'I am currently offline. Please try again later.', '2026-03-19 05:45:00'),
(4, 'agents', 'I am currently offline. Please try again later.', '2026-03-20 14:20:33'),
(5, 'hi', 'I am currently offline. Please try again later.', '2026-03-20 14:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `propertiies`
--

CREATE TABLE `propertiies` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `display_image` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `location` text NOT NULL,
  `description` text NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `image` text NOT NULL,
  `view_images` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  `property_page` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `propertiies`
--

INSERT INTO `propertiies` (`id`, `title`, `display_image`, `type`, `price`, `location`, `description`, `bedrooms`, `bathrooms`, `image`, `view_images`, `created_at`, `views`, `view_count`, `property_page`) VALUES
(15, 'GJCKPUG4DMQITp9RA0YOxw==', '', '', 0.01, 'XjCQlpQqEl+DqyP1f38pfQ==', 'Q3gWyV3APnNSlpsJIGmUHnoWCYx5FlRz0b/f/TmTronOLAxm1vQSVS0XT+NjGEkXbQ+IHuBeaO9JUNp4d1Fn1u7xeOwBZec4OBXMCEXBVnsfgLfnoFIcxi9ZTjU2vYwKT17MTBgOvGHB3jb6FjtDo90BIeQJgKksYU7MDVYgCPl4nC/T5MFrb3Ai5u1MPtDb1SdgvLYTf0pZfvW79T9AK9tseoTBrHe+o7+83WzCJM+pMet69JsLGpAVhrXcezFoPRek+UaBh2B61NDiiBwUyb1xPM486B5meLcYHzGzdRn7sIpw+1eKB/L0jw4vH3vDVUXy/vBHZG3zLynzugb6HqSbb6zEcAq+Mx3dUA2oioF0MiTTENlyuD9eSztt1mkAoTBeCfyxAm1wvGSC1qvYWkpuEqzj6vUfgOEMmw8j06FjQpfxMjwUfptgKw9GMMnAXFzrlMAJ5uJOdNDr+1Cm5yMUO0W+VjDqQRy7gUJWFzSEDApKPiSxK/xadryqtkEG9fmgUwKqLl2hsO89jhRZQ6DNJ7Y1PMBx033vmU7S7ad6CB6dy+Wqf+/tF6D3TT8HhVCKdc+AX2qE5T2p26om7IKFylR7WarQ96jmoHtCY3WPgEDgVeXRoojHaJ4xTWBNsZY+Z5c/af/0R/pgjKR/Gg==', 2, 1, '', NULL, '2026-03-22 15:35:23', 2, 0, 'monticello'),
(16, 'h9bk9c3VWFbkRia/EvUIJQ==', '', '', 123.00, 'XjCQlpQqEl+DqyP1f38pfQ==', 'XL5aZtraM44nAKBsa++EWg==', 1, 2, '', NULL, '2026-03-22 15:57:17', 1, 0, 'monticello'),
(18, 'WOwvxUQXTLxe4uzVF7tDcg==', '', '', 9999999999.99, 'PCJzc01JRxB4yMUhJU4N8g==', 'QBv9bkBLWaMwaMpRMrJPCizRx9nobOqinT27CsLKBsr9v1WEXIzJNAlpGpUrw12t', 2147483647, 1231231312, '', NULL, '2026-03-23 16:02:26', 1, 0, 'monticello'),
(19, 'BU/56w4vQRlXak699JNrrg==', '', '', 89089089.00, 'aNOCi5x83e5H4B4i2Q9Wcw==', '1QpQz/jfOIK9VLeeRJGPAI0mckgdTgduBfCt0nWOMYTyU6pSYSWV0OdyFtjsY2Sw', 898898089, 90808089, '', NULL, '2026-03-23 16:23:27', 1, 0, 'deca_homes'),
(20, '9wOmsuSV6IOHW+Ud82OgnA==', '', '', 9999999999.99, 'ZuJ32JTGnbJZcB0918zciA==', 'S0KaMzTkEjrOHtwuOl5xcQrHXi1WRRUZzhg5t3qQUiVhXLZ0iRJK/vmlwE534VG5+jrfn/hZs3i/phzaBw48GQ==', 2147483647, 2147483647, '', NULL, '2026-03-23 16:26:08', 1, 0, 'deca_homes'),
(21, 'DLYHH9mpJ+Gc+jEH7TiWPRaKTwo+xNbqKcJyleWA/0o=', '', '', 9999999999.99, 'iHUpbUJI+1AgVL6qoGmRpA==', 'OARCqkTEqFYb3ijWxx64X9b2UEz3qy5qIoC5r5/6u7zAQ1H1YKYS8pS0ucIkBYbyi0kPBaAjbCTcIW5pyMpvvyCznDV7P1Qk364H5gKeZ4RLjJaaWvOD+EnxcbQCMRTgMfYUukU+pvOMjrS0ddnawCpiGCt5/SW7N8fJnRkV1a0b9/M6IPfDfq0sBi5QOWWey695HHGRuXlyL1q3PzetlPlmfix4urKCiX5sLtwRNt0=', 12, 12, '1774283603_bg_2.jpg', NULL, '2026-03-23 16:33:23', 1, 0, 'deca_homes'),
(22, 'zY6Ne6V6ABAVWWV0CZ/wmYuId0WU9bOJl/xaohd+tWU=', '', '', 9999999999.99, 'dS0ZgErOg9UixrrVclRpoJyn+mpKJUCjaGQVR380GvA=', 'uudOLCts/RiBC1GK0x46hDv0zXunZ3mNcQejA7JZ3qs=', 2147483647, 2147483647, '1774283708_1773725275_logo.png', NULL, '2026-03-23 16:35:08', 1, 0, 'parc_regency'),
(23, 'D220YGTu95zk+ByaZnVvDw==', '', '', 100.00, 'kNdFZRfkg/9nogSsmYOutQ==', '15gUKCVglzWIFPpRUfXffQ==', 1, 1, '1774284100_1773723728_etoten.jpg', NULL, '2026-03-23 16:41:40', 1, 0, 'monticello'),
(24, 'ssgBEzupQhDO+cQi+PLE4+HfYp1fG/T20OA/OS4iQdxjwsp9SriwnUClJaWkh9Ig', '', '', 9999999999.99, '/0Uc5xnd7D2M2ckYEsgTX1CIilI7Zz7E1cNZ6EkfscU=', '/0Uc5xnd7D2M2ckYEsgTX1CIilI7Zz7E1cNZ6EkfscU=', 2147483647, 2147483647, '1774285108_626025876_817252761375555_782912627039123986_n.png', NULL, '2026-03-23 16:58:28', 1, 0, 'deca_homes'),
(25, 'OZPk5t+DX0sE1xICzm5dLQ==', '', '', 200000.00, 'AK1z5Wrkjml0nB06ZBhUkg==', 'PFW2k8ZTDdApRbl5Gmk+dwlpYWnwOYW27Vje4/cYB56kodYXWtqheTT07EwjR5c9oJL2QRW9HWSWvLk/aQXL1zBhy1PU2SSFdmFL6st5QIGRvqAA6CNldCMkslflD9ZpxnwcnG4HE58Gg6q6VJtyIiqCAk58alB6bnhPamsiJEvbudmwnQwrhSHkudzdPLn8Dey8UWqeb6nIfxoCCn7EgZf27Dh8JqVAnm39bJ7ZzJeLcagsRSEdLTPjvF3ut5dVx3qQmiePnzjho9WaaNSFTSVFbD6lIJErdkZzFp6NuzxEDv/IStG+fS1lnleo+pG0n+o6VOLmxWklI7CEP2FnanMf+0V8pjnotsBx/LQBP304KTXHZXA+jQXDwCqGxZ45JhjCeviBINur9f0gGRLolwLdcQ8Mc7jqyDhXPm74P1U=', 2, 1, '1774288788_1773723728_logo.png', NULL, '2026-03-23 17:59:48', 2, 0, 'monticello'),
(26, 'enGVBT4JCzLnU33Au8sCoA==', '', '', 100000.00, 'rWcKcnLbrYRvZXwxHHqKYg==', 'nwKK88uhTUafil0/u432mxn9Hg6zpdIqK631Ska6jJhHbjEE9Ovh1GVyjDHocGkDWRgxxoC+ywzfEHlO55fxea+bk+XKK41aC4f9+4EDF9X68q4CHphn1nqL5SNtdHxUuwB2tXoM895iWcDoPPIvDUwXjsP4AIz0i5wwiHL4+sgTL3TEEVLER90sMjiuAGfp/mH+kObi1bL3s2T9iuyr7wzG7eoBdSd3Ty5orVn2pPwEO5LJB+nsQehdnZHB73O5Z7yxwC9oQISQL07eh3kfiw6klDtnjfjvKxJBo7X1OedNI7LVLmDp8tsMbW7g5gnMuOoE1o4rB3LXWGwqYoqZ+26ibr++MidRXXNEajUC8bX0eyT47yXhjSMjmfAwQjWY', 2, 1, '1774290394_image.jpg', NULL, '2026-03-23 18:26:34', 1, 0, 'deca_homes'),
(27, '2zxe3BTA1ofDmcY9l2wmGw==', '', '', 299999.00, 'QWPF+9jkKKu6XmHEyB8pXA==', 'BK/Y+SX6KdLWuvjjgJlPHvIwRjQF+EsJ/BaPmXakuww=', 5, 5, '1774334490_logo.png', NULL, '2026-03-24 06:41:30', 1, 0, 'monticello'),
(28, 'D220YGTu95zk+ByaZnVvDw==', '', '', 100000000.00, 'FLpljXJO9WvScCdHYQW0aQ==', 'PS03j2WP/L4iRzGHWHca0I4/UM3NF+qk8zl4HFECx1U=', 100, 10, '1774338384_1772020505_logo.png', NULL, '2026-03-24 07:46:24', 1, 0, 'monticello'),
(29, 'FDhUfVHBO9GA0DUqqEhnYQ==', '', '', 1000.00, 'sux7uBrRN73SwNCaVXZv5Q==', 'pxMwzvQfKL2wsNdIs5o4QpzwGlY7/hLfrjMRyjKSxHVErID1a8mLHVEP8Q31PcZsA2HNAMuPMvxfCUF337rMYsE+NBptXwjx98ayHlAfY/fF+uL6ufQc+WWRmrlihoBQzi4plr9irNwXlK+K92V1sROmWRTD4jfabbAmlvOUwPQ0FPbJdIQEuCeeb/Zs59KTYj2QKh3BdTsN4G1DxUvVceKd3otwGEcAqut6zv6BbXLYBsytQS80U+2wuzNC7S+Xrimk8FqDtAGMxYEicmKuGSymDBByS6yk5y57ZDKf3DSS2ZAa9XkJakUSKNs1ljrpetWZTk3g3vjmfhY0dCnkHgl87uIXd5LvcIsjB9y4ujPbbxmh2/R7F0Wan6qlShD09J34+djwJAmANqm1eo5rUboEJoHNYYdoNArnOV/PMNAuwVWnx4sMjq8iKOeYZy7idOiBpsQLBj8JBobXRG9auU0Iy4q9rOx34qz2I6eZRcA9kkTbeGaUgY4Svr+KnFA/l2UyVfGcVt/D/9RHQFtV6HKV9HFcLxvorioBv3NTXgyTym+VksVpFT4aWACjJ875fRUGzYIZ1EpWVCCxpinUQFesvm5yAOsGlt+eC5ShV1GS3K+3FI7xUOYgSr4OGvAazZvga0BmfG3fRwEsB0RMbmGRGbXigcvF1zKA4AgDIdQCDsQlw1ozRuA3dNWChT2+6InorYgTTMBiERUswnlIeQ==', 10, 10, '1774341513_image.jpg', NULL, '2026-03-24 08:38:33', 3, 0, 'parc_regency');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image`) VALUES
(35, 15, 'd170+bTo6wq+8ZYl9yClBRTcTN/JYTN0UIYGoWo0xO/AFDytP81NH4PiFTJf9//ydeW3bo9RGXrPpaPMQ/VEeA=='),
(36, 15, 'd170+bTo6wq+8ZYl9yClBRTcTN/JYTN0UIYGoWo0xO8qt/Rjk5R83P0lcsB4m3Y7IbmLMHlWS6UTNKNeK3TE/g=='),
(37, 15, 'd170+bTo6wq+8ZYl9yClBRTcTN/JYTN0UIYGoWo0xO99p/BF//zcH7kCFUQOArFgUJUVqdQ3CStzXZilBtD6rg=='),
(38, 15, 'DZMDJwDubTonnoTxF+hYIh7ofg078esAWSMI4Hn1SuhqYvyt6JSS9OAitCaBUW3do+Jg2qK/fawHBahYtie6Aw=='),
(39, 15, 'DZMDJwDubTonnoTxF+hYIh7ofg078esAWSMI4Hn1SuiGAH7mru2p2SZ06E+CU2BdVk9wxy5F7QZwHSVXT+jnZQ=='),
(40, 15, 'DZMDJwDubTonnoTxF+hYIh7ofg078esAWSMI4Hn1Suiilovj21A/oNjSjaQOlAwSWZxT6JwUdUEJphmgk0r1YQ=='),
(41, 15, 'DZMDJwDubTonnoTxF+hYIh7ofg078esAWSMI4Hn1Suhmnp6CEgX0uNdtnbF/qhCQGyShnE+bl0PPOmK36wTwIg=='),
(42, 15, 'DZMDJwDubTonnoTxF+hYIh7ofg078esAWSMI4Hn1SuioOkVQQu6A1nW+12ZOEPN0B2Yxhgn47HhU27SDINumGA=='),
(43, 15, 'xFM6Cmqls2iYnmmkL54mTopNVXJ9KKv51Wm1jY/S1E/wa40V+GoYefDojKVaE69tCILwuRcfkxiiwyifxwfThA=='),
(44, 15, 'xFM6Cmqls2iYnmmkL54mTopNVXJ9KKv51Wm1jY/S1E9Zy11X7hAVrm87yHUu3nAAqoOluzZm5C2uu0mMCBJw8A=='),
(45, 15, 'koXvtd3MJDqe9mQlBbYk1N2CmjBJD2EeClO9ROXdxlY='),
(46, 15, '8QXGvXjdsVCkrgSEqO/tYSeGpI/STWew6L/MCF7Ha7Y='),
(47, 15, 'vYiXqboXQPuP+QUVF7T057CksvPjiNqYzLlyEf8dMzJ+hajiYiQ9WQqQ0hpsbAk98TnnGh8ADUB4C5pz403bog=='),
(48, 15, 't60uzFVul0NuZG5HsLC3DdCZezfCktyzS/usuOHrknw='),
(49, 15, 'F1fQ/iV0LN1oSAFvitxEQT86xh2HyRL7QBJI6NTzIDbt/21OLjjZpjAEKnmlbPTY'),
(50, 16, 'W7SUSRpirRfnOi09xmUTWWtLbvTqJvg0XpIxk1U+ieBLaR1qarGyCX0taRktVHTFek6V3RAVS/2A3pJH9TKnrA=='),
(51, 16, 'mUxFhzr2BSfJLQBaocygrOHlB04ygXeMzE/rlwQxN/E='),
(52, 16, 'mUxFhzr2BSfJLQBaocygrAZsRKySYIkod/hXcRvEksc='),
(53, 16, 'mUxFhzr2BSfJLQBaocygrLBV5Ho/jZgrZbWqMWDMBPM='),
(54, 16, 'kju2z0PLDI5L7uDXYefvcYCyajZvbobR3dKuorrndsqMtpn9nrgiPyXsYwtFLw9Tz2CCwJ84P+8HHrkVGWhx/SidBlIbW/Pp6BeFHbXz6PQ='),
(55, 16, 'kju2z0PLDI5L7uDXYefvcd6/i6aayd8scbJzk0kYovYrQIs4GrgnaoL3CPqH+H1EFqJurLr7DJRLWB1IdmviV5y9mFZgbi0QA2D/JPfINBk='),
(56, 16, 'kju2z0PLDI5L7uDXYefvcbeRF5KfMsRx8fqh4t7awLQWQNVE7i/e7H83ts6SFuU2LuA/F1xy6mxhXzFsZmXtyOQMzIfHBebF6ZZdwIGT8XM='),
(57, 16, 'kju2z0PLDI5L7uDXYefvcbeRF5KfMsRx8fqh4t7awLQWQNVE7i/e7H83ts6SFuU2UK3cZmcR/RYrgmH0YSNMqx4Y3sndwVFtGKEhM/glsv4='),
(58, 16, 'kju2z0PLDI5L7uDXYefvcSyH+uxtC+aqmnuuUyRdgqBS2H3yzgb8KWT/dXPHathu'),
(59, 16, 'kju2z0PLDI5L7uDXYefvcbFpRWOTwyq4hzwk9HOj2Ww='),
(61, 18, '8JA0uCYsPzfjty4TCOhXD/BdmznhodS6lYIyoCRNqzs='),
(62, 19, 'jgJ/+ozvoplQebgbvqvMkc0OMnlCqgWDwPTjYWuHxcw='),
(63, 19, 'RkwBYygN/jYGkMRFnOUF7XXa9SIKyXq0s4FjIXHszmU='),
(64, 19, 'RkwBYygN/jYGkMRFnOUF7SuiTZK02g9ngyCoTRTtGzg='),
(65, 20, 'ebLBs0x5PFvwjQEU5XI7P2k9rLBXPLCVNjH0Ey26D94='),
(66, 21, 'oeSjbRylWs6V4IBuBnEmxZAdgC72G4/ictFqs/7uu9k='),
(67, 22, '4+OpDSHL4hqyay56A9/j/cN8TnGgPoBEOiYYIneyZmU='),
(68, 22, '4+OpDSHL4hqyay56A9/j/SDWyGMI6KW65K+/yjPH0ssnhqU4HuIemTfnHUKOwxYoX11CUkZOGjNjDvxmvyiEa+zK+HvXK4VB5MkB2L0uKkA='),
(69, 22, '4+OpDSHL4hqyay56A9/j/QbUyF5cOSGokGWYevUo/POB1Mvto4sYIhpmMik+zVZpuxzWXnAjE6/2yl4anG3AqpORrnY3KXHCWnA1a4HED5w='),
(70, 22, '4+OpDSHL4hqyay56A9/j/QdBx7auMAFRHpuPW+gTF8RDjLGFwAJdxjvcoKDLgRRMi7o3DO73ZQ6DLeyQY1CjUxcOavmlk06XGXmV3z5awps='),
(71, 22, '4+OpDSHL4hqyay56A9/j/ZTBabWzEbRDeIr+7ts6mA0trWV528fyJGRz5WhuiSRFnvXcJJG/0rVECLGlgpgpDw=='),
(72, 22, '4+OpDSHL4hqyay56A9/j/WzbrXygPR508Co4JHS5zQU='),
(73, 22, 'W6yD1c1o/fO+wu3C3PujknCvMYDKBE7Szecfkrdq8ULAAw4dt9u3mbLCOYj60eUz4AbCuDz/svfpQx5H2jWqrA=='),
(74, 22, 'W6yD1c1o/fO+wu3C3PujknCvMYDKBE7Szecfkrdq8UIdW8m0jawPjKpMdONhM2/OyTLMr2LkC3elwIXZ3/5CJg=='),
(75, 22, 'W6yD1c1o/fO+wu3C3PujknCvMYDKBE7Szecfkrdq8ULhX33RwuQG1JWvq+pNHs2cTD3E7CcQj7cD2yFsXj520g=='),
(76, 22, 'W6yD1c1o/fO+wu3C3PujknCvMYDKBE7Szecfkrdq8UJRY6iVkX24HTTd1/B2u1Osc250zG+fLCGTu0lFx6RmNQ=='),
(77, 22, 'W6yD1c1o/fO+wu3C3PujknCvMYDKBE7Szecfkrdq8UJJaH/PvEH9GPM1mj+3y2gxvMARt4x5pFYudetJYk3Xig=='),
(78, 22, 'W6yD1c1o/fO+wu3C3PujknCvMYDKBE7Szecfkrdq8ULn/zHe5eiB20ZIC9tidGAVGb7uJzMvQ9L9pJdWAP1gyQ=='),
(79, 22, 'W6yD1c1o/fO+wu3C3Pujkp3obHMkR15cWXx4TPXc0EzhvNyNZXCQ8oGxytu9HSjmqBTAp6jdaop3zcm3jNDTVA=='),
(80, 22, 'W6yD1c1o/fO+wu3C3Pujkp3obHMkR15cWXx4TPXc0EyKx3qsC8OcCiO/ps/AuCP5zmP1ZLXMz/NhVotDMxDAkw=='),
(81, 22, 'W6yD1c1o/fO+wu3C3Pujkp3obHMkR15cWXx4TPXc0EyOYGza+6xxZVka0zjG2ZOsmdHJUNjbIHmNHbyHJ83eyg=='),
(82, 22, 'xc9Dw6P4B7VDdAHsqSsR3Xvd6rfSzAHCTO9UVfE/s/q18SBvg36G4ipvoVXddi3aa4V0qs44mYN3fux3zm0Ijw=='),
(83, 22, 'xc9Dw6P4B7VDdAHsqSsR3Xvd6rfSzAHCTO9UVfE/s/rQc+StwDkdVqj9cMTou1knu/zeqxcdw29AydZRxQEAJg=='),
(84, 22, 'xc9Dw6P4B7VDdAHsqSsR3Xvd6rfSzAHCTO9UVfE/s/oCMwWgd70ctPkCFdiAJON9oC5D5srIMcO8Pf6W1Eo1dg=='),
(85, 22, 'xc9Dw6P4B7VDdAHsqSsR3Xvd6rfSzAHCTO9UVfE/s/pmHgkglyuU3oS9cbyodBvf3uvoPbWBBf8X2LYXAXpyVg=='),
(86, 22, 'xc9Dw6P4B7VDdAHsqSsR3Xvd6rfSzAHCTO9UVfE/s/oUncyktOH9SVH6XtAZUDIUNjhEPWT6u8waWsvvBJKHuQ=='),
(87, 23, '4YSRxDfDwtzXybi2NGuFsHR18tT76JdKzsEbsDXdtnD75RhBCiMfyLIOAcjsDIvP'),
(88, 24, 'r9s3kqG3iDjIOILvVDHMx57HeEbJgiO8KB+BR2ND1AN+hj5YYY1b+dLEoLtEVxzqde3kYcOdFpHQED/zaFvzEQ=='),
(89, 24, 'zJFg3LMN5l/xQNcQAqBhL40UxzlUKrZePKm9Z/OR9pY='),
(90, 24, 'zJFg3LMN5l/xQNcQAqBhL18DpOJqF/ZZC82mrjnTkJ0='),
(91, 24, 'zJFg3LMN5l/xQNcQAqBhL4dXTQ3OxE3Hljt3eNk3ve0='),
(92, 24, 'b4KufoB7DxeBpTyoOoLXMUnsxDVMMPAR5ZPWNPgk+1CuJcXeHB75DuQBvhjt/03gmBwS8iCpfu48jsTVqqjVdhfsbRZLsL3ictCzeWNUADA='),
(93, 25, '2+q+1t+oRT8MpUN3NimRqRGCCnVbY3vYStogcH2LjuI='),
(94, 26, '2B2XHzq9683Wdfffk6akh36HWcUAcASQ8lMar76IlKU='),
(95, 27, 'OkQE/IF6lszbQBLGuVvnh5xYrV/UxbyL4EtFt3OtGCQ='),
(96, 28, 'RBQ3sZuGP64c9z5QmRtBBxKtl0hP1GxlmENUCbIC6zY='),
(97, 29, 'w5sflWN0cCkfTuPGhAIQ3ZF0U1XQheevvKuNFmeq2GY=');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `property` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `fullname`, `email`, `phone`, `property`, `date`, `time`, `created_at`) VALUES
(11, 'alex', 'alex123@gmail.com', '09876543210', '', '2002-02-11', '11:30:00', '2026-03-15 05:38:34'),
(12, 'DubwYTGBjdUtQFeZ7jEhkg==', 'X5NaBZ2sQlSjwrnM4qpYLw==', '5IcfQbrLdjurNOG7IKOX+g==', '', '2026-03-24', '14:50:00', '2026-03-24 06:48:28'),
(13, 'DubwYTGBjdUtQFeZ7jEhkg==', 'X5NaBZ2sQlSjwrnM4qpYLw==', '5IcfQbrLdjurNOG7IKOX+g==', 'House Lot 512 -', '2026-03-24', '14:50:00', '2026-03-24 06:51:21'),
(14, 'DubwYTGBjdUtQFeZ7jEhkg==', 'X5NaBZ2sQlSjwrnM4qpYLw==', '5IcfQbrLdjurNOG7IKOX+g==', 'House Lot 512 -', '2026-03-24', '14:50:00', '2026-03-24 06:51:24'),
(15, 'DDLGio7h6PDSQqLE9ieuoA==', 'P2eBgwy9MGfhLCeCluv91g==', 'jY/T/R2n64Iln6A4pDO1Uw==', 'Long -', '0124-01-07', '00:31:00', '2026-03-24 10:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`id`, `ip_address`, `user_agent`, `visited_at`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 10:22:59'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 10:25:02'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 02:47:57'),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 02:55:31'),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 03:01:04'),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 03:23:11'),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 03:25:34'),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 12:38:57'),
(9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-14 12:47:05'),
(10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-14 13:09:39'),
(11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-14 13:30:34'),
(12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-14 13:30:43'),
(13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-14 13:59:24'),
(14, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-15 03:42:26'),
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-15 03:42:26'),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-16 12:15:42'),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-16 12:43:06'),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-17 04:46:03'),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-18 10:31:46'),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-18 11:57:38'),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-19 05:39:17'),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-20 02:25:19'),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-20 12:24:30'),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-20 13:08:42'),
(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', '2026-03-20 14:17:52'),
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-23 08:37:30'),
(27, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-23 17:31:17'),
(28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-23 18:16:37'),
(29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-03-23 18:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `vlogs`
--

CREATE TABLE `vlogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gmail` (`gmail`);

--
-- Indexes for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `propertiies`
--
ALTER TABLE `propertiies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vlogs`
--
ALTER TABLE `vlogs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat_logs`
--
ALTER TABLE `chat_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `propertiies`
--
ALTER TABLE `propertiies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `vlogs`
--
ALTER TABLE `vlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `propertiies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
