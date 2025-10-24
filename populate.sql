SET search_path TO lbaw25172;

------------------------------------------------------------
-- USERS
------------------------------------------------------------
INSERT INTO users (email, name, obs, credit, password, url)
VALUES
('alice@example.com', 'Alice Johnson', 'Frequent bidder', 150.00, 'alice123', 'https://img.example.com/alice.jpg'),
('bob@example.com', 'Bob Smith', 'Occasional seller', 300.00, 'bob123', 'https://img.example.com/bob.jpg'),
('charlie@example.com', 'Charlie Brown', NULL, 50.00, 'charlie123', NULL),
('diana@example.com', 'Diana Prince', 'Top-rated user', 500.00, 'diana123', 'https://img.example.com/diana.jpg'),
('john.doe@example.com', 'John Doe', 'Vintage collector and enthusiast', 10000.00, 'johndoe22', 'https://img.example.com/john.jpg'),
('jane.smith@example.com', 'Jane Smith', 'Art lover and dealer', 12000.00, 'jane21321394', 'https://img.example.com/jane.jpg'),
('mike.wilson@example.com', 'Mike Wilson', 'Tech gadget collector', 7000.00, 'mikey1', 'https://img.example.com/mike.jpg'),
('sara.johnson@example.com', 'Sara Johnson', 'Antique furniture specialist', 20000.00, 'sara572', 'https://img.example.com/sara.jpg'),
('david.brown@example.com', 'David Brown', 'Sports memorabilia fan', 6000.00, 'david123', 'https://img.example.com/david.jpg'),
('emily.davis@example.com', 'Emily Davis', 'Book collector and bibliophile', 9000.00, 'emily123', 'https://img.example.com/emily.jpg'),
('robert.miller@example.com', 'Robert Miller', 'Jewelry and watches expert', 25000.00, 'robert123', 'https://img.example.com/robert.jpg'),
('lisa.garcia@example.com', 'Lisa Garcia', 'Fashion and accessories enthusiast', 11000.00, 'lisa123', 'https://img.example.com/lisa.jpg'),
('james.martinez@example.com', 'James Martinez', 'Car and motorcycle collector', 30000.00, 'james123', 'https://img.example.com/james.jpg'),
('anna.rodriguez@example.com', 'Anna Rodriguez', 'Coin and stamp collector', 5500.00, 'anna123', 'https://img.example.com/anna.jpg'),
('thomas.lee@example.com', 'Thomas Lee', 'Electronics and gaming enthusiast', 8500.00, 'tomas123', 'https://img.example.com/thomas.jpg'),
('maria.hernandez@example.com', 'Maria Hernandez', 'Home decor and vintage items', 4500.00, 'maria123', 'https://img.example.com/maria.jpg'),
('chris.taylor@example.com', 'Chris Taylor', 'Musical instruments collector', 14000.00, 'chris123', 'https://img.example.com/chris.jpg'),
('amanda.white@example.com', 'Amanda White', 'Toy and collectibles expert', 7500.00, 'amanda123', 'https://img.example.com/amanda.jpg'),
('kevin.anderson@example.com', 'Kevin Anderson', 'Photography equipment enthusiast', 10000.00, 'kevin123', 'https://img.example.com/kevin.jpg'),
('susan.clark@example.com', 'Susan Clark', 'Vintage clothing specialist', 6500.00, 'susan123', 'https://img.example.com/susan.jpg');

------------------------------------------------------------
-- ADMINS
------------------------------------------------------------
INSERT INTO admin (email, name, password)
VALUES
('admin1@example.com', 'Admin One', 'adminpass1'),
('admin2@example.com', 'Admin Two', 'adminpass2'),
('admin3@example.com', 'Admin Three', 'adminpass3');

------------------------------------------------------------
-- CATEGORIES
------------------------------------------------------------
INSERT INTO category (name)
VALUES
('Electronics'),
('Fashion'),
('Home'),
('Sports'),
('Books'),
('Art'),
('Collectibles'),
('Jewelry & Watches'),
('Antiques'),
('Musical Instruments'),
('Toys & Games'),
('Automotive'),
('Photography'),
('Coins & Stamps'),
('Furniture');

------------------------------------------------------------
-- LOCATIONS
------------------------------------------------------------
INSERT INTO location (latitude, longitude)
VALUES
('40.7128° N', '74.0060° W'),  -- New York
('34.0522° N', '118.2437° W'), -- Los Angeles
('51.5074° N', '0.1278° W'),   -- London
('48.8566° N', '2.3522° E'),   -- Paris
('41.8781° N', '87.6298 W'),   -- Chicago
('29.7604° N', '95.3698 W'),   -- Houston
('33.4484° N', '112.0740 W'),  -- Phoenix
('39.7392° N', '104.9903 W'),  -- Denver
('47.6062° N', '122.3321 W'),  -- Seattle
('37.7749° N', '122.4194 W'),  -- San Francisco
('42.3601° N', '71.0589 W'),   -- Boston
('25.7617° N', '80.1918 W'),   -- Miami
('32.7157° N', '117.1611 W'),  -- San Diego
('30.2672° N', '97.7431 W'),   -- Austin
('38.9072° N', '77.0369 W');   -- Washington DC

------------------------------------------------------------
-- AUCTIONS
------------------------------------------------------------
INSERT INTO auction (title, description, start_date, end_date, starting_price, current_price, status, owner_id, category_id, location_id)
VALUES
('iPhone 14 Pro', 'Brand new iPhone 14 Pro 128GB', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 800.00, 950.00, 'Active', 2, 1, 1),
('Designer Handbag', 'Luxury leather handbag, gently used', NOW() - INTERVAL '1 day', NOW() + INTERVAL '3 days', 250.00, 270.00, 'Active', 4, 2, 2),
('Mountain Bike', 'Full-suspension trail bike', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 400.00, 520.00, 'Ended', 3, 4, 3),
('Cookbook Collection', 'Set of 10 premium cookbooks', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 50.00, 60.00, 'Active', 1, 5, 4),
('Vintage Watch', 'Classic vintage wristwatch from 1960s', NOW() - INTERVAL '4 days', NOW() + INTERVAL '1 day', 300.00, 450.00, 'Active', 5, 8, 5),
('Gaming Laptop', 'High-performance laptop for gaming', NOW() - INTERVAL '2 days', NOW() + INTERVAL '4 days', 1200.00, 1500.00, 'Active', 6, 1, 6),
('Antique Vase', 'Beautiful antique vase from the 19th century', NOW() - INTERVAL '6 days', NOW() - INTERVAL '2 days', 600.00, 750.00, 'Ended', 7, 9, 7),
('Electric Guitar', 'Fender Stratocaster electric guitar', NOW() - INTERVAL '1 day', NOW() + INTERVAL '6 days', 700.00, 850.00, 'Active', 8, 10, 8),
('Action Figure Set', 'Complete set of superhero action figures', NOW() - INTERVAL '3 days', NOW() + INTERVAL '3 days', 80.00, 120.00, 'Active', 9, 11, 9),
('Classic Car Model', 'Die-cast model of a classic car', NOW() - INTERVAL '4 days', NOW() + INTERVAL '2 days', 150.00, 200.00, 'Active', 10, 12, 10),
('Digital Camera', 'High-resolution digital camera with lens kit', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 500.00, 650.00, 'Active', 11, 13, 11),
('Rare Coin', 'Gold coin from ancient Rome', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 1000.00, 1200.00, 'Ended', 12, 14, 12),
('Wooden Dining Table', 'Handcrafted wooden dining table', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 800.00, 950.00, 'Active', 13, 15, 13),
('Stamp Collection', 'Extensive collection of rare stamps', NOW() - INTERVAL '6 days', NOW() - INTERVAL '2 days', 300.00, 400.00, 'Ended', 14, 14, 14),
('Leather Sofa', 'Comfortable leather sofa in excellent condition', NOW() - INTERVAL '2 days', NOW() + INTERVAL '6 days', 1200.00, 1400.00, 'Active', 15, 3, 15),
('Bluetooth Speaker', 'Portable Bluetooth speaker with deep bass', NOW() - INTERVAL '1 day', NOW() + INTERVAL '5 days', 100.00, 130.00, 'Active', 16, 1, 1),
('Painting by Local Artist', 'Original painting by a renowned local artist', NOW() - INTERVAL '4 days', NOW() + INTERVAL '3 days', 400.00, 550.00, 'Active', 17, 6, 2),
('Vintage Vinyl Records', 'Collection of classic vinyl records from the 70s and 80s', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 200.00, 300.00, 'Ended', 18, 5, 3),
('Smartwatch', 'Latest model smartwatch with health tracking features', NOW() - INTERVAL '2 days', NOW() + INTERVAL '4 days', 250.00, 320.00, 'Active', 19, 1, 4),
('Designer Sunglasses', 'Stylish designer sunglasses with UV protection', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 150.00, 220.00, 'Active', 20, 2, 5);

------------------------------------------------------------
-- BIDS
------------------------------------------------------------
INSERT INTO bid (amount, date, user_id, auction_id)
VALUES
(850.00, NOW() - INTERVAL '2 days', 2, 1),
(900.00, NOW() - INTERVAL '1 day', 3, 1),
(950.00, NOW(), 4, 1),
(260.00, NOW() - INTERVAL '2 days', 1, 2),
(270.00, NOW(), 3, 2),
(500.00, NOW() - INTERVAL '5 days', 1, 3),
(520.00, NOW() - INTERVAL '1 day', 4, 3),
(55.00, NOW() - INTERVAL '3 days', 2, 4),
(60.00, NOW(), 3, 4),
(320.00, NOW() - INTERVAL '4 days', 5, 5),
(450.00, NOW() - INTERVAL '1 day', 1, 5),
(1300.00, NOW() - INTERVAL '2 days', 6, 6),
(1500.00, NOW(), 2, 6),
(700.00, NOW() - INTERVAL '1 day', 7, 20),
(750.00, NOW() - INTERVAL '2 days', 3, 6),
(800.00, NOW() - INTERVAL '1 day', 4, 6),
(800.00, NOW() - INTERVAL '1 day', 8, 8),
(850.00, NOW(), 5, 8),
(100.00, NOW() - INTERVAL '3 days', 9, 9),
(120.00, NOW(), 10, 9),
(180.00, NOW() - INTERVAL '4 days', 11, 10),
(200.00, NOW() - INTERVAL '2 days', 13, 10),
(600.00, NOW() - INTERVAL '5 days', 13, 11),
(650.00, NOW(), 1, 11),
(1100.00, NOW() - INTERVAL '5 days', 14, 13),
(1200.00, NOW() - INTERVAL '1 day', 2, 13),
(850.00, NOW() - INTERVAL '3 days', 15, 13),
(950.00, NOW(), 3, 13),
(250.00, NOW() - INTERVAL '6 days', 16, 13),
(300.00, NOW() - INTERVAL '2 days', 4, 19),
(1300.00, NOW() - INTERVAL '2 days', 17, 15),
(1400.00, NOW(), 5, 15),
(120.00, NOW() - INTERVAL '1 day', 18, 16),
(130.00, NOW(), 1, 16),
(450.00, NOW() - INTERVAL '4 days', 19, 17),
(550.00, NOW(), 2, 17),
(220.00, NOW() - INTERVAL '5 days', 20, 19),
(300.00, NOW() - INTERVAL '1 day', 3, 19),
(280.00, NOW() - INTERVAL '2 days', 1, 19),
(320.00, NOW(), 4, 19),
(200.00, NOW() - INTERVAL '3 days', 2, 20),
(220.00, NOW(), 5, 20),
(750.00, NOW() - INTERVAL '2 days', 1, 7);


------------------------------------------------------------
-- TRANSACTIONS
------------------------------------------------------------
INSERT INTO transactions (amount, date, status, auction_id, buyer_id, seller_id)
VALUES
(520.00, NOW() - INTERVAL '1 day', 'Completed', 3, 4, 3),
(950.00, NOW(), 'Pending', 1, 4, 2),
(1200.00, NOW() - INTERVAL '1 day', 'Completed', 12, 2, 12),
(750.00, NOW() - INTERVAL '2 days', 'Completed', 7, 1, 7),
(300.00, NOW() - INTERVAL '1 day', 'Pending', 18, 3, 18),
(1400.00, NOW(), 'Pending', 15, 5, 14);

------------------------------------------------------------
-- NOTIFICATIONS
------------------------------------------------------------
INSERT INTO notifications (type, is_read, created_date, user_id, auction_id, bid_id)
VALUES
('new-bid', FALSE, NOW() - INTERVAL '2 days', 2, 1, 1),
('new-bid', TRUE, NOW() - INTERVAL '1 day', 2, 1, 2),
('ending', FALSE, NOW() - INTERVAL '1 day', 2, 1, NULL),
('new-bid', FALSE, NOW() - INTERVAL '5 days', 3, 3, 1),
('winner', FALSE, NOW() - INTERVAL '1 day', 4, 3, 8),  
('ended', TRUE, NOW() - INTERVAL '1 day', 3, 3, NULL),
('new-bid', FALSE, NOW() - INTERVAL '4 days', 7, 7, 7),
('winner', FALSE, NOW() - INTERVAL '1 day', 1, 7, 9), 
('ended', TRUE, NOW() - INTERVAL '1 day', 7, 7, NULL),
('new-bid', TRUE, NOW() - INTERVAL '2 days', 12, 12, 12),
('winner', FALSE, NOW() - INTERVAL '1 day', 2, 12, 13),
('ended', FALSE, NOW() - INTERVAL '1 day', 12, 12, NULL),
('new-bid', FALSE, NOW() - INTERVAL '3 days', 18, 18, 42),
('winner', TRUE, NOW(), 3, 18, 42),
('ended', FALSE, NOW() - INTERVAL '1 day', 18, 18, NULL),
('new-bid', FALSE, NOW() - INTERVAL '3 days', 19, 19, 42),
('ending', FALSE, NOW() - INTERVAL '1 day', 19, 19, NULL),
('new-bid', FALSE, NOW() - INTERVAL '2 days', 4, 2, 5),
('new-bid', TRUE, NOW() - INTERVAL '1 day', 4, 2, 6),
('ending', FALSE, NOW() - INTERVAL '1 day', 4, 2, NULL);


------------------------------------------------------------
-- REVIEWS
------------------------------------------------------------
INSERT INTO review (description, rating, created_date, user_id, auction_id)
VALUES
('Great seller! Item as described.', 5.00, NOW() - INTERVAL '2 days', 4, 3),
('Smooth transaction, highly recommend this user.', 4.80, NOW(), 1, 5),
('Item was damaged but resolved professionally.', 4.50, NOW() - INTERVAL '1 day', 1, 7);


------------------------------------------------------------
-- REPORTS
------------------------------------------------------------
INSERT INTO report (description, status, user_id, admin_id, reported_user_id, auction_id)
VALUES
('Suspicious bidding behavior', 'InReview', 1, 1, 3, 1),
('Fake listing suspected', 'Pending', 3, 2, 2, 2),
('Inappropriate comments', 'Resolved', 10, 2, 1, 4),
('Non-delivery of item', 'InReview', 2, 3, 5, 5),
('Counterfeit product reported', 'Pending', 5, 2, 4, 6),
('Spam messages from user', 'Resolved', 6, 1, 7, 2),
('Unfair bidding practices', 'InReview', 3, 2, 8, 3),
('Misleading auction description', 'Pending', 4, 3, 9, 9),
('Offensive content in listing', 'Resolved', 1, 3, 10, 10),
('Non-payment by buyer', 'InReview', 15, 1, 11, 12);

------------------------------------------------------------
-- USER FOLLOWS
------------------------------------------------------------
INSERT INTO user_follows (follower_id, followed_auction)
VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 4),
(4, 3),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20);


------------------------------------------------------------
-- FEATURE PAYMENT
------------------------------------------------------------
INSERT INTO feature_payment (amount, date, status, auction_id, user_id)
VALUES
(20.00, NOW() - INTERVAL '3 days', 'Completed', 1, 1),
(15.00, NOW() - INTERVAL '1 day', 'Pending', 2, 2),
(25.00, NOW() - INTERVAL '2 days', 'Completed', 3, 3),
(10.00, NOW(), 'Pending', 4, 4),
(30.00, NOW() - INTERVAL '4 days', 'Completed', 5, 5);  
