SET search_path TO lbaw25172;

------------------------------------------------------------
-- USERS
------------------------------------------------------------
INSERT INTO users (email, name, description, credit, password, url, is_admin)
VALUES
('alice@example.com', 'Alice Johnson', 'Frequent bidder', 150.00, 'alice123', 'https://img.example.com/alice.jpg', FALSE),
('bob@example.com', 'Bob Smith', 'Occasional seller', 300.00, 'bob123', 'https://img.example.com/bob.jpg', FALSE),
('charlie@example.com', 'Charlie Brown', NULL, 50.00, 'charlie123', NULL, FALSE),
('diana@example.com', 'Diana Prince', 'Top-rated user', 500.00, 'diana123', 'https://img.example.com/diana.jpg', FALSE),
('john.doe@example.com', 'John Doe', 'Vintage collector and enthusiast', 10000.00, 'johndoe22', 'https://img.example.com/john.jpg', FALSE),
('jane.smith@example.com', 'Jane Smith', 'Art lover and dealer', 12000.00, 'jane21321394', 'https://img.example.com/jane.jpg', FALSE),
('mike.wilson@example.com', 'Mike Wilson', 'Tech gadget collector', 7000.00, 'mikey1', 'https://img.example.com/mike.jpg', FALSE),
('sara.johnson@example.com', 'Sara Johnson', 'Antique furniture specialist', 20000.00, 'sara572', 'https://img.example.com/sara.jpg', FALSE),
('david.brown@example.com', 'David Brown', 'Sports memorabilia fan', 6000.00, 'david123', 'https://img.example.com/david.jpg', FALSE),
('emily.davis@example.com', 'Emily Davis', 'Book collector and bibliophile', 9000.00, 'emily123', 'https://img.example.com/emily.jpg', FALSE),
('robert.miller@example.com', 'Robert Miller', 'Jewelry and watches expert', 25000.00, 'robert123', 'https://img.example.com/robert.jpg', FALSE),
('lisa.garcia@example.com', 'Lisa Garcia', 'Fashion and accessories enthusiast', 11000.00, 'lisa123', 'https://img.example.com/lisa.jpg', FALSE),
('james.martinez@example.com', 'James Martinez', 'Car and motorcycle collector', 30000.00, 'james123', 'https://img.example.com/james.jpg', FALSE),
('anna.rodriguez@example.com', 'Anna Rodriguez', 'Coin and stamp collector', 5500.00, 'anna123', 'https://img.example.com/anna.jpg', FALSE),
('thomas.lee@example.com', 'Thomas Lee', 'Electronics and gaming enthusiast', 8500.00, 'tomas123', 'https://img.example.com/thomas.jpg', FALSE),
('maria.hernandez@example.com', 'Maria Hernandez', 'Home decor and vintage items', 4500.00, 'maria123', 'https://img.example.com/maria.jpg', FALSE),
('chris.taylor@example.com', 'Chris Taylor', 'Musical instruments collector', 14000.00, 'chris123', 'https://img.example.com/chris.jpg', FALSE),
('amanda.white@example.com', 'Amanda White', 'Toy and collectibles expert', 7500.00, 'amanda123', 'https://img.example.com/amanda.jpg', FALSE),
('kevin.anderson@example.com', 'Kevin Anderson', 'Photography equipment enthusiast', 10000.00, 'kevin123', 'https://img.example.com/kevin.jpg', FALSE),
('susan.clark@example.com', 'Susan Clark', 'Vintage clothing specialist', 6500.00, 'susan123', 'https://img.example.com/susan.jpg', FALSE),
('pedro.hortença@example.com', 'Pedro Hortença', NULL, NULL, 'admin1', NULL, TRUE);

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
-- AUCTIONS
------------------------------------------------------------
INSERT INTO auction (title, description, start_date, end_date, starting_price, status, owner_id, category_id, address, latitude, longitude, buy_now_price, is_buy_now_active, is_featured)
VALUES
('iPhone 14 Pro', 'Brand new iPhone 14 Pro 128GB in Space Black. Includes all original accessories and 1-year warranty.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 800.00, 'Active', 2, 1, 'San Francisco, CA', '37.7749', '-122.4194', 1200.00, TRUE, FALSE),
('Designer Handbag', 'Luxury leather handbag by premium brand, gently used. Comes with authenticity certificate.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '3 days', 250.00, 'Active', 4, 2, 'New York, NY', '40.7128', '-74.0060', 450.00, TRUE, FALSE),
('Mountain Bike', 'Full-suspension trail bike with carbon frame. Perfect for mountain trails and rough terrain.', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 400.00, 'Ended', 3, 4, 'Denver, CO', '39.7392', '-104.9903', NULL, FALSE, FALSE),
('Cookbook Collection', 'Set of 10 premium cookbooks covering various cuisines. Like new condition.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 50.00, 'Active', 1, 5, 'Chicago, IL', '41.8781', '-87.6298', NULL, FALSE, FALSE),
('Vintage Watch', 'Classic vintage wristwatch from 1960s. Automatic movement, recently serviced.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '1 day', 300.00, 'Active', 5, 8, 'Boston, MA', '42.3601', '-71.0589', 800.00, TRUE, TRUE),
('Gaming Laptop', 'High-performance laptop for gaming with RTX 3070, 16GB RAM, 1TB SSD.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '4 days', 1200.00, 'Active', 6, 1, 'Austin, TX', '30.2672', '-97.7431', 2000.00, TRUE, FALSE),
('Antique Vase', 'Beautiful antique vase from the 19th century. Hand-painted porcelain with gold trim.', NOW() - INTERVAL '6 days', NOW() - INTERVAL '2 days', 600.00, 'Ended', 7, 9, 'Philadelphia, PA', '39.9526', '-75.1652', NULL, FALSE, FALSE),
('Electric Guitar', 'Fender Stratocaster electric guitar in sunburst finish. Includes hard case and amp.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '6 days', 700.00, 'Active', 8, 10, 'Nashville, TN', '36.1627', '-86.7816', 1500.00, TRUE, TRUE),
('Action Figure Set', 'Complete set of superhero action figures. Mint in box, never opened.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '3 days', 80.00, 'Active', 9, 11, 'Seattle, WA', '47.6062', '-122.3321', NULL, FALSE, FALSE),
('Classic Car Model', 'Die-cast model of a 1967 Ford Mustang. 1:18 scale, highly detailed.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '2 days', 150.00, 'Active', 10, 12, 'Detroit, MI', '42.3314', '-83.0458', 300.00, TRUE, FALSE),
('Digital Camera', 'High-resolution digital camera with lens kit. 24MP sensor, 4K video capability.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 500.00, 'Active', 11, 13, 'Los Angeles, CA', '34.0522', '-118.2437', 900.00, TRUE, FALSE),
('Rare Coin', 'Gold coin from ancient Rome. Authenticated by professional numismatist.', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 1000.00, 'Ended', 12, 14, 'Washington, DC', '38.9072', '-77.0369', NULL, FALSE, FALSE),
('Wooden Dining Table', 'Handcrafted wooden dining table made from solid oak. Seats 6-8 people.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 800.00, 'Active', 13, 15, 'Portland, OR', '45.5152', '-122.6784', 1500.00, TRUE, FALSE),
('Stamp Collection', 'Extensive collection of rare stamps from various countries and eras.', NOW() - INTERVAL '6 days', NOW() - INTERVAL '2 days', 300.00, 'Ended', 14, 14, 'Miami, FL', '25.7617', '-80.1918', NULL, FALSE, FALSE),
('Leather Sofa', 'Comfortable leather sofa in excellent condition. Three-seater, brown leather.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '6 days', 1200.00, 'Active', 15, 3, 'Phoenix, AZ', '33.4484', '-112.0740', 2200.00, TRUE, FALSE),
('Bluetooth Speaker', 'Portable Bluetooth speaker with deep bass. Waterproof, 20-hour battery life.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '5 days', 100.00, 'Active', 16, 1, 'San Diego, CA', '32.7157', '-117.1611', 180.00, TRUE, FALSE),
('Painting by Local Artist', 'Original painting by a renowned local artist. Abstract expressionism, acrylic on canvas.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '3 days', 400.00, 'Active', 17, 6, 'Santa Fe, NM', '35.6870', '-105.9378', NULL, FALSE, TRUE),
('Vintage Vinyl Records', 'Collection of classic vinyl records from the 70s and 80s. Includes Beatles, Pink Floyd, Led Zeppelin.', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 200.00, 'Ended', 18, 5, 'Memphis, TN', '35.1495', '-90.0490', NULL, FALSE, FALSE),
('Smartwatch', 'Latest model smartwatch with health tracking features. Heart rate monitor, GPS, sleep tracking.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '4 days', 250.00, 'Active', 19, 1, 'Dallas, TX', '32.7767', '-96.7970', 450.00, TRUE, FALSE),
('Designer Sunglasses', 'Stylish designer sunglasses with UV protection. Polarized lenses, includes case.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 150.00, 'Active', 20, 2, 'Miami Beach, FL', '25.7907', '-80.1300', 280.00, TRUE, FALSE);
------------------------------------------------------------
-- BIDS
------------------------------------------------------------
INSERT INTO bid (amount, date, user_id, auction_id)
VALUES
(880.00, NOW() - INTERVAL '2 days' + INTERVAL '2 hours', 5, 1),
(950.00, NOW() - INTERVAL '1 day' + INTERVAL '5 hours', 7, 1),
(1050.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 5, 1),
(1150.00, NOW() - INTERVAL '12 hours', 13, 1),
(275.00, NOW() - INTERVAL '1 day' + INTERVAL '3 hours', 6, 2),
(300.00, NOW() - INTERVAL '20 hours', 12, 2),
(350.00, NOW() - INTERVAL '10 hours', 6, 2),
(440.00, NOW() - INTERVAL '5 days' + INTERVAL '2 hours', 8, 3),
(480.00, NOW() - INTERVAL '4 days' + INTERVAL '5 hours', 11, 3),
(520.00, NOW() - INTERVAL '3 days' + INTERVAL '8 hours', 9, 3),
(580.00, NOW() - INTERVAL '2 days' + INTERVAL '3 hours', 8, 3),
(1320.00, NOW() - INTERVAL '2 days' + INTERVAL '3 hours', 15, 6),
(1450.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 7, 6),
(1600.00, NOW() - INTERVAL '18 hours', 15, 6),
(660.00, NOW() - INTERVAL '6 days' + INTERVAL '4 hours', 16, 7),
(720.00, NOW() - INTERVAL '5 days' + INTERVAL '6 hours', 11, 7),
(800.00, NOW() - INTERVAL '4 days' + INTERVAL '8 hours', 16, 7),
(900.00, NOW() - INTERVAL '3 days' + INTERVAL '5 hours', 17, 7),
(88.00, NOW() - INTERVAL '3 days' + INTERVAL '2 hours', 18, 9),
(100.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 10, 9),
(120.00, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 18, 9),
(165.00, NOW() - INTERVAL '4 days' + INTERVAL '3 hours', 9, 10),
(185.00, NOW() - INTERVAL '3 days' + INTERVAL '6 hours', 12, 10),
(210.00, NOW() - INTERVAL '2 days' + INTERVAL '4 hours', 9, 10),
(550.00, NOW() - INTERVAL '2 days' + INTERVAL '4 hours', 19, 11),
(620.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 11, 11),
(700.00, NOW() - INTERVAL '16 hours', 19, 11),
(1100.00, NOW() - INTERVAL '5 days' + INTERVAL '3 hours', 14, 12),
(1250.00, NOW() - INTERVAL '4 days' + INTERVAL '6 hours', 20, 12),
(1400.00, NOW() - INTERVAL '3 days' + INTERVAL '4 hours', 12, 12),
(1600.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 14, 12),
(880.00, NOW() - INTERVAL '3 days' + INTERVAL '5 hours', 16, 13),
(980.00, NOW() - INTERVAL '2 days' + INTERVAL '7 hours', 8, 13),
(1100.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 16, 13),
(330.00, NOW() - INTERVAL '6 days' + INTERVAL '2 hours', 14, 14),
(380.00, NOW() - INTERVAL '5 days' + INTERVAL '5 hours', 10, 14),
(450.00, NOW() - INTERVAL '4 days' + INTERVAL '7 hours', 14, 14),
(520.00, NOW() - INTERVAL '3 days' + INTERVAL '4 hours', 20, 14),
(1320.00, NOW() - INTERVAL '2 days' + INTERVAL '6 hours', 13, 15),
(1480.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 11, 15),
(1650.00, NOW() - INTERVAL '14 hours', 13, 15),
(110.00, NOW() - INTERVAL '1 day' + INTERVAL '2 hours', 6, 16),
(125.00, NOW() - INTERVAL '18 hours', 9, 16),
(145.00, NOW() - INTERVAL '10 hours', 6, 16),
(440.00, NOW() - INTERVAL '4 days' + INTERVAL '4 hours', 12, 17),
(500.00, NOW() - INTERVAL '3 days' + INTERVAL '6 hours', 6, 17),
(580.00, NOW() - INTERVAL '2 days' + INTERVAL '8 hours', 12, 17),
(660.00, NOW() - INTERVAL '1 day' + INTERVAL '5 hours', 11, 17),
(220.00, NOW() - INTERVAL '5 days' + INTERVAL '3 hours', 17, 18),
(260.00, NOW() - INTERVAL '4 days' + INTERVAL '5 hours', 8, 18),
(310.00, NOW() - INTERVAL '3 days' + INTERVAL '7 hours', 17, 18),
(370.00, NOW() - INTERVAL '2 days' + INTERVAL '6 hours', 9, 18),
(275.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 7, 19),
(310.00, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 10, 19),
(360.00, NOW() - INTERVAL '16 hours', 7, 19),
(165.00, NOW() - INTERVAL '3 days' + INTERVAL '3 hours', 15, 20),
(190.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 19, 20),
(220.00, NOW() - INTERVAL '1 day' + INTERVAL '4 hours', 15, 20);

------------------------------------------------------------
-- TRANSACTIONS
------------------------------------------------------------
INSERT INTO transactions (amount, date, status, type, auction_id, buyer_id, seller_id)
VALUES
(580.00, NOW() - INTERVAL '1 day' + INTERVAL '10 minutes', 'Completed', 'auction-buy', 3, 8, 3),
(900.00, NOW() - INTERVAL '2 days' + INTERVAL '10 minutes', 'Completed', 'auction-buy', 7, 17, 7),
(1600.00, NOW() - INTERVAL '1 day' + INTERVAL '10 minutes', 'Completed', 'auction-buy', 12, 14, 12),
(520.00, NOW() - INTERVAL '2 days' + INTERVAL '10 minutes', 'Completed', 'auction-buy', 14, 20, 14),
(370.00, NOW() - INTERVAL '1 day' + INTERVAL '10 minutes', 'Completed', 'auction-buy', 18, 9, 18),
(5000.00, NOW() - INTERVAL '7 days', 'Completed', 'add-credit', NULL, 5, NULL),
(3000.00, NOW() - INTERVAL '6 days', 'Completed', 'add-credit', NULL, 7, NULL),
(2500.00, NOW() - INTERVAL '6 days', 'Completed', 'add-credit', NULL, 13, NULL),
(4000.00, NOW() - INTERVAL '5 days', 'Completed', 'add-credit', NULL, 11, NULL),
(2000.00, NOW() - INTERVAL '5 days', 'Completed', 'add-credit', NULL, 17, NULL),
(1500.00, NOW() - INTERVAL '4 days', 'Completed', 'add-credit', NULL, 6, NULL),
(3500.00, NOW() - INTERVAL '4 days', 'Completed', 'add-credit', NULL, 15, NULL),
(1800.00, NOW() - INTERVAL '3 days', 'Completed', 'add-credit', NULL, 8, NULL),
(2200.00, NOW() - INTERVAL '3 days', 'Completed', 'add-credit', NULL, 14, NULL),
(1200.00, NOW() - INTERVAL '2 days', 'Completed', 'add-credit', NULL, 9, NULL),
(1000.00, NOW() - INTERVAL '2 days', 'Completed', 'add-credit', NULL, 10, NULL),
(2800.00, NOW() - INTERVAL '1 day', 'Completed', 'add-credit', NULL, 12, NULL),
(1600.00, NOW() - INTERVAL '1 day', 'Completed', 'add-credit', NULL, 16, NULL),
(100.00, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes', 'Completed', 'feature-payment', 5, 5, NULL),
(100.00, NOW() - INTERVAL '1 day' + INTERVAL '30 minutes', 'Completed', 'feature-payment', 8, 8, NULL),
(100.00, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes', 'Completed', 'feature-payment', 17, 17, NULL),
(1500.00, NOW() - INTERVAL '2 hours', 'Pending', 'add-credit', NULL, 19, NULL);

------------------------------------------------------------
-- NOTIFICATIONS
------------------------------------------------------------
INSERT INTO notifications (type, is_read, created_date, user_id, auction_id, bid_id)
VALUES
('winner', TRUE, NOW() - INTERVAL '1 day' + INTERVAL '5 minutes', 8, 3, NULL),
('winner', TRUE, NOW() - INTERVAL '2 days' + INTERVAL '5 minutes', 17, 7, NULL),
('winner', TRUE, NOW() - INTERVAL '1 day' + INTERVAL '5 minutes', 14, 12, NULL),
('winner', TRUE, NOW() - INTERVAL '2 days' + INTERVAL '5 minutes', 20, 14, NULL),
('winner', TRUE, NOW() - INTERVAL '1 day' + INTERVAL '5 minutes', 9, 18, NULL),
('ended', TRUE, NOW() - INTERVAL '1 day' + INTERVAL '5 minutes', 3, 3, NULL),
('ended', TRUE, NOW() - INTERVAL '2 days' + INTERVAL '5 minutes', 7, 7, NULL),
('ended', TRUE, NOW() - INTERVAL '1 day' + INTERVAL '5 minutes', 12, 12, NULL),
('ended', TRUE, NOW() - INTERVAL '2 days' + INTERVAL '5 minutes', 14, 14, NULL),
('ended', TRUE, NOW() - INTERVAL '1 day' + INTERVAL '5 minutes', 18, 18, NULL),
('ending', FALSE, NOW() - INTERVAL '6 hours', 2, 1, NULL),
('ending', FALSE, NOW() - INTERVAL '6 hours', 5, 5, NULL),
('new-bid', FALSE, NOW() - INTERVAL '8 hours', 8, 8, 30),
('new-bid', FALSE, NOW() - INTERVAL '10 hours', 16, 16, 43);


------------------------------------------------------------
-- REVIEWS
------------------------------------------------------------
INSERT INTO review (description, rating, created_date, user_id, auction_id)
VALUES
('Excellent bike! Exactly as described. Seller was very helpful and shipping was fast. Highly recommend!', 5.00, NOW() - INTERVAL '1 day' + INTERVAL '3 hours', 8, 3),
('Beautiful piece! Very well packaged and authentic. The seller provided great documentation. Very satisfied.', 4.80, NOW() - INTERVAL '2 days' + INTERVAL '2 hours', 17, 7),
('Amazing coin! Authentication certificate was included. Seller was professional and responsive. Would buy again.', 5.00, NOW() - INTERVAL '1 day' + INTERVAL '4 hours', 14, 12);



------------------------------------------------------------
-- REPORTS
------------------------------------------------------------
INSERT INTO report (description, status, user_id, admin_id, reported_user_id, auction_id)
VALUES
('Item looks fake. I don''t think this is a real Fender Stratocaster.', NOW() - INTERVAL '12 hours', 'Dismissed', 9, 21, NULL, 8),
('This user is bidding on multiple auctions and not following through with payments. Suspicious activity.', NOW() - INTERVAL '2 days', 'InReview', 12, 21, 6, NULL),
('The handbag appears to be counterfeit based on the stitching visible in the photos.', NOW() - INTERVAL '4 days', 'Resolved', 12, 21, NULL, 2);

------------------------------------------------------------
-- USER FOLLOWS
------------------------------------------------------------
INSERT INTO user_follows (follower_id, followed_auction)
VALUES
(1,1),
(1,5),
(2,2),
(2,6),
(9,4),
(13,5),
(19,11),
(20,17),
(16,13),
(11,6);

------------------------------------------------------------
-- FEATURE PAYMENT
------------------------------------------------------------
INSERT INTO feature_payment (auction_id, user_id, paid_date)
VALUES
(5, 5, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes'),
(8, 8, NOW() - INTERVAL '1 day' + INTERVAL '30 minutes'),
(17, 17, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes');