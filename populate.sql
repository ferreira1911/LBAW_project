SET search_path TO lbaw25172;

------------------------------------------------------------
-- USERS
------------------------------------------------------------
INSERT INTO users (email, name, obs, credit, password, url)
VALUES
('alice@example.com', 'Alice Johnson', 'Frequent bidder', 150.00, 'alice123', 'https://img.example.com/alice.jpg'),
('bob@example.com', 'Bob Smith', 'Occasional seller', 300.00, 'bob123', 'https://img.example.com/bob.jpg'),
('charlie@example.com', 'Charlie Brown', NULL, 50.00, 'charlie123', NULL),
('diana@example.com', 'Diana Prince', 'Top-rated user', 500.00, 'diana123', 'https://img.example.com/diana.jpg');

------------------------------------------------------------
-- ADMINS
------------------------------------------------------------
INSERT INTO admin (email, name, password)
VALUES
('admin1@example.com', 'Admin One', 'adminpass1'),
('admin2@example.com', 'Admin Two', 'adminpass2');

------------------------------------------------------------
-- CATEGORIES
------------------------------------------------------------
INSERT INTO category (name)
VALUES
('Electronics'),
('Fashion'),
('Home'),
('Sports'),
('Books');

------------------------------------------------------------
-- LOCATIONS
------------------------------------------------------------
INSERT INTO location (latitude, longitude)
VALUES
('40.7128° N', '74.0060° W'),  -- New York
('34.0522° N', '118.2437° W'), -- Los Angeles
('51.5074° N', '0.1278° W'),   -- London
('48.8566° N', '2.3522° E');   -- Paris

------------------------------------------------------------
-- AUCTIONS
------------------------------------------------------------
INSERT INTO auction (title, description, startdate, enddate, startingprice, currentprice, status, owner_id, category, location_id)
VALUES
('iPhone 14 Pro', 'Brand new iPhone 14 Pro 128GB', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 800.00, 950.00, 'Active', 2, 'Electronics', 1),
('Designer Handbag', 'Luxury leather handbag, gently used', NOW() - INTERVAL '1 day', NOW() + INTERVAL '3 days', 250.00, 270.00, 'Active', 4, 'Fashion', 2),
('Mountain Bike', 'Full-suspension trail bike', NOW() - INTERVAL '5 days', NOW() - INTERVAL '1 day', 400.00, 520.00, 'Ended', 3, 'Sports', 3),
('Cookbook Collection', 'Set of 10 premium cookbooks', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 50.00, 60.00, 'Active', 1, 'Books', 4);

------------------------------------------------------------
-- BIDS
------------------------------------------------------------
INSERT INTO bid (amount, user_id, auction_id)
VALUES
(850.00, 1, 1),
(900.00, 3, 1),
(950.00, 4, 1),
(260.00, 1, 2),
(270.00, 3, 2),
(500.00, 1, 3),
(520.00, 4, 3),
(55.00, 2, 4),
(60.00, 3, 4);

------------------------------------------------------------
-- TRANSACTIONS
------------------------------------------------------------
INSERT INTO transactions (amount, date, status, auction_id, buyer_id, seller_id)
VALUES
(520.00, NOW() - INTERVAL '1 day', 'Completed', 3, 4, 3),
(950.00, NOW(), 'Pending', 1, 4, 2);

------------------------------------------------------------
-- NOTIFICATIONS
------------------------------------------------------------
INSERT INTO notifications (type, is_read, user_id, auction_id, bid_id)
VALUES
('new-bid', FALSE, 2, 1, 1),
('new-bid', TRUE, 2, 1, 2),
('ending', FALSE, 1, 4, NULL),
('winner', FALSE, 4, 3, 7),
('ended', TRUE, 3, 3, NULL);

------------------------------------------------------------
-- REVIEWS
------------------------------------------------------------
INSERT INTO review (description, rating, user_id, auction_id)
VALUES
('Great seller! Item as described.', 5.00, 4, 3),
('Fast payment and smooth transaction.', 4.50, 3, 3),
('Would buy again.', 4.00, 1, 1);

------------------------------------------------------------
-- REPORTS
------------------------------------------------------------
INSERT INTO report (description, status, user_id, admin_id, reported_user_id, auction_id)
VALUES
('Suspicious bidding behavior', 'InReview', 1, 1, 3, 1),
('Fake listing suspected', 'Pending', 3, NULL, 2, 2),
('Inappropriate comments', 'Resolved', 4, 2, 1, 4);

------------------------------------------------------------
-- USER FOLLOWS
------------------------------------------------------------
INSERT INTO user_follows (follower_id, followed_auction)
VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 4),
(4, 3);
