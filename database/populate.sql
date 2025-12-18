SET search_path TO lbaw25172;

-- TRUNCATE ALL TABLES AND RESTART SEQUENCES TO GUARANTEE IDs MATCH
TRUNCATE users, category, auction, bid, transactions, notifications, review, report, user_follows, feature_payment, auction_images RESTART IDENTITY CASCADE;

------------------------------------------------------------
-- USERS
------------------------------------------------------------
INSERT INTO users (email, name, description, credit, password, url, is_admin)
VALUES
('jharsent0@marketwatch.com', 'Junette Harsent', 'Phasellus in felis.', 16000.00, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, true),
('lgarvagh1@baidu.com', 'Leslie Garvagh', 'Morbi quis tortor id nulla ultrices aliquet. Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo.', 19958.77, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('sswiers2@weather.com', 'Sheryl Swiers', 'Morbi non quam nec dui luctus rutrum. Nulla tellus.', 10000.00, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('cland3@networkadvertising.org', 'Cassandry Land', 'Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 62661.95, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('vtongue4@sourceforge.net', 'Vivi Tongue', 'Proin at turpis a pede posuere nonummy. Integer non velit.', 19045.12, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, true),
('hpallent5@boston.com', 'Heriberto Pallent', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus.', 15136.06, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('lcorkish6@usnews.com', 'Lind Corkish', 'Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci.', 13810.58, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('dthomlinson7@weather.com', 'Danie Thomlinson', 'Duis bibendum.', 16289.75, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('epeddel8@meetup.com', 'Erskine Peddel', 'Fusce posuere felis sed lacus.', 15888.22, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('onassau9@dion.ne.jp', 'Othilie Nassau', 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum.', 13409.82, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('hcollecotta@shinystat.com', 'Humfrey Collecott', 'Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla.', 15807.52, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('sgehrelsb@qq.com', 'Skip Gehrels', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus.', 22460.57, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('sbuggsc@dyndns.org', 'Svend Buggs', 'Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', 9600.24, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('lrockhilld@domainmarket.com', 'Lyell Rockhill', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien.', 46517.36, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('achinnerye@sogou.com', 'Anatollo Chinnery', 'Aliquam erat volutpat.', 15361.07, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('djagelsf@abc.net.au', 'Dougy Jagels', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', 86829.54, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('fvang@youku.com', 'Freeman Van der Son', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', 619098709.85, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('hroadnighth@biglobe.ne.jp', 'Helaine Roadnight', 'Proin risus. Praesent lectus.', 17833.71, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('eadamiaki@booking.com', 'Edythe Adamiak', 'Nulla nisl. Nunc nisl.', 15515, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('idenisyukj@ifeng.com', 'Ingamar Denisyuk', 'Maecenas tincidunt lacus at velit.', 15863.48, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, true),
('wseccombek@cisco.com', 'Wally Seccombe', 'Duis bibendum. Morbi non quam nec dui luctus rutrum.', 18413.39, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('phyronsl@opera.com', 'Poul Hyrons', 'Phasellus sit amet erat.', 15821.06, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('ocheasmanm@trellian.com', 'Olivie Cheasman', 'Aenean lectus. Pellentesque eget nunc.', 13744.00, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('afairsn@123-reg.co.uk', 'Araldo Fairs', 'Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue.', 19362.55, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('lbentono@hibu.com', 'Lukas Benton', 'Fusce consequat. Nulla nisl.', 15149.68, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('fvasnetsovp@dot.gov', 'Fran Vasnetsov', 'Morbi a ipsum. Integer a nibh.', 16370.23, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('gcrushq@so-net.ne.jp', 'Georgie Crush', 'Nulla facilisi. Cras non velit nec nisi vulputate nonummy.', 15329.59, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('lneylonr@who.int', 'Lindsay Neylon', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue.', 16129.56, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('omartignons@weebly.com', 'Odey Martignon', 'In sagittis dui vel nisl. Duis ac nibh.', 11400.32, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('bbeamant@meetup.com', 'Braden Beaman', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 11192.12, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('mleynhamu@netlog.com', 'Mamie Leynham', 'Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.', 19314.74, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('sbohlinv@lulu.com', 'Shirlene Bohlin', 'Nullam sit amet turpis elementum ligula vehicula consequat.', 19206.26, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('lschiesterlw@timesonline.co.uk', 'Lalo Schiesterl', 'Nulla tellus. In sagittis dui vel nisl.', 14246.74, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('rburkx@google.ru', 'Ramsay Burk', 'Integer ac neque. Duis bibendum.', 11727.56, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('tdriussiy@freewebs.com', 'Tiebold Driussi', 'Duis ac nibh.', 15407.67, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('sleschellez@usnews.com', 'Sherye Leschelle', 'Morbi porttitor lorem id ligula.', 19721.37, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('wbaumert10@phpbb.com', 'Werner Baumert', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam.', 5518.90, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('mhunnicot11@ucoz.com', 'Melicent Hunnicot', 'Aenean auctor gravida sem. Praesent id massa id nisl venenatis lacinia.', 7963.13, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('slindholm12@soundcloud.com', 'Sidney Lindholm', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', 81787.18, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('mgrimsley13@webnode.com', 'Mirelle Grimsley', 'Nam tristique tortor eu pede.', 17264.93, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('gscripps14@wisc.edu', 'Giustina Scripps', 'Suspendisse potenti. Nullam porttitor lacus at turpis.', 18298.65, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('astede15@miibeian.gov.cn', 'Annabelle Stede', 'Proin risus.', 17655.70, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('wtreace16@i2i.jp', 'Worthington Treace', 'In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', 18730.34, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('ro17@whitehouse.gov', 'Rosanna O'' Dooley', 'Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', 17840.37, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('mmapson18@unblog.fr', 'Mattias Mapson', 'Nullam porttitor lacus at turpis.', 15752.18, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('brisdall19@statcounter.com', 'Beulah Risdall', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim.', 18121.99, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('mcresswell1b@skype.com', 'Misha Cresswell', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci.', 15287.49, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('chatchman1c@tinyurl.com', 'Carey Hatchman', 'Maecenas tincidunt lacus at velit.', 15450.27, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false),
('dscandrite1d@scribd.com', 'Dulsea Scandrite', 'Proin risus. Praesent lectus.', 16722.47, '$2y$10$w57GYwc2jCsN7TtHwcVQwOu86d4SffDxhIe2LHh54Jt9iLdr2Lf4m', NULL, false);
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
INSERT INTO auction (title, description, start_date, end_date, starting_price, status, owner_id, category_id, address, latitude, longitude, buy_now_price, is_buy_now_active, is_featured, featured_until)
VALUES
('iPhone 14 Pro', 'Brand new iPhone 14 Pro 128GB in Space Black. Includes all original accessories and 1-year warranty.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 800.00, 'Active', 2, 1, 'San Francisco, CA', '37.7749', '-122.4194', 1200.00, TRUE, FALSE, NULL),
('Designer Handbag', 'Luxury leather handbag by premium brand, gently used. Comes with authenticity certificate.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '3 days', 250.00, 'Active', 4, 2, 'New York, NY', '40.7128', '-74.0060', 450.00, TRUE, FALSE, NULL),
('Mountain Bike', 'Full-suspension trail bike with carbon frame. Perfect for mountain trails and rough terrain.', NOW() - INTERVAL '5 days', NOW() + INTERVAL '1 day', 400.00, 'Active', 3, 4, 'Denver, CO', '39.7392', '-104.9903', NULL, FALSE, FALSE, NULL),
('Cookbook Collection', 'Set of 10 premium cookbooks covering various cuisines. Like new condition.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 50.00, 'Active', 24, 5, 'Chicago, IL', '41.8781', '-87.6298', NULL, FALSE, FALSE, NULL),
('Vintage Watch', 'Classic vintage wristwatch from 1960s. Automatic movement, recently serviced.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '1 day', 300.00, 'Active', 30, 8, 'Boston, MA', '42.3601', '-71.0589', 800.00, TRUE, TRUE, NOW() + INTERVAL '7 days'), -- CORRIGIDO AQUI
('Gaming Laptop', 'High-performance laptop for gaming with RTX 3070, 16GB RAM, 1TB SSD.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '4 days', 1200.00, 'Active', 6, 1, 'Austin, TX', '30.2672', '-97.7431', 2000.00, TRUE, FALSE, NULL),
('Antique Vase', 'Beautiful antique vase from the 19th century. Hand-painted porcelain with gold trim.', NOW() - INTERVAL '6 days', NOW() + INTERVAL '2 days', 600.00, 'Active', 7, 9, 'Philadelphia, PA', '39.9526', '-75.1652', NULL, FALSE, FALSE, NULL),
('Electric Guitar', 'Fender Stratocaster electric guitar in sunburst finish. Includes hard case and amp.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '6 days', 700.00, 'Active', 8, 10, 'Nashville, TN', '36.1627', '-86.7816', 1500.00, TRUE, TRUE, NOW() + INTERVAL '7 days'),
('Action Figure Set', 'Complete set of superhero action figures. Mint in box, never opened.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '3 days', 80.00, 'Active', 9, 11, 'Seattle, WA', '47.6062', '-122.3321', NULL, FALSE, FALSE, NULL),
('Classic Car Model', 'Die-cast model of a 1967 Ford Mustang. 1:18 scale, highly detailed.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '2 days', 150.00, 'Active', 10, 12, 'Detroit, MI', '42.3314', '-83.0458', 300.00, TRUE, FALSE, NULL),
('Digital Camera', 'High-resolution digital camera with lens kit. 24MP sensor, 4K video capability.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 500.00, 'Active', 11, 13, 'Los Angeles, CA', '34.0522', '-118.2437', 900.00, TRUE, FALSE, NULL),
('Rare Coin', 'Gold coin from ancient Rome. Authenticated by professional numismatist.', NOW() - INTERVAL '5 days', NOW() + INTERVAL '1 day', 1000.00, 'Active', 12, 14, 'Washington, DC', '38.9072', '-77.0369', NULL, FALSE, FALSE, NULL),
('Wooden Dining Table', 'Handcrafted wooden dining table made from solid oak. Seats 6-8 people.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 800.00, 'Active', 13, 15, 'Portland, OR', '45.5152', '-122.6784', 1500.00, TRUE, FALSE, NULL),
('Stamp Collection', 'Extensive collection of rare stamps from various countries and eras.', NOW() - INTERVAL '6 days', NOW() + INTERVAL '2 days', 300.00, 'Active', 14, 14, 'Miami, FL', '25.7617', '-80.1918', NULL, FALSE, FALSE, NULL),
('Leather Sofa', 'Comfortable leather sofa in excellent condition. Three-seater, brown leather.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '6 days', 1200.00, 'Active', 15, 3, 'Phoenix, AZ', '33.4484', '-112.0740', 2200.00, TRUE, FALSE, NULL),
('Bluetooth Speaker', 'Portable Bluetooth speaker with deep bass. Waterproof, 20-hour battery life.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '5 days', 100.00, 'Active', 16, 1, 'San Diego, CA', '32.7157', '-117.1611', 180.00, TRUE, FALSE, NULL),
('Painting by Local Artist', 'Original painting by a renowned local artist. Abstract expressionism, acrylic on canvas.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '3 days', 400.00, 'Active', 17, 6, 'Santa Fe, NM', '35.6870', '-105.9378', NULL, FALSE, TRUE, NOW() + INTERVAL '7 days'),
('Vintage Vinyl Records', 'Collection of classic vinyl records from the 70s and 80s. Includes Beatles, Pink Floyd, Led Zeppelin.', NOW() - INTERVAL '5 days', NOW() + INTERVAL '1 day', 200.00, 'Active', 18, 5, 'Memphis, TN', '35.1495', '-90.0490', NULL, FALSE, FALSE, NULL),
('Smartwatch', 'Latest model smartwatch with health tracking features. Heart rate monitor, GPS, sleep tracking.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '4 days', 250.00, 'Active', 19, 1, 'Dallas, TX', '32.7767', '-96.7970', 450.00, TRUE, FALSE, NULL),
('Designer Sunglasses', 'Stylish designer sunglasses with UV protection. Polarized lenses, includes case.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '2 days', 150.00, 'Active', 20, 2, 'Miami Beach, FL', '25.7907', '-80.1300', 280.00, TRUE, FALSE, NULL),
('MacBook Pro M2', 'Latest MacBook Pro with M2 chip, 16GB RAM, 512GB SSD. Perfect condition, barely used.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '7 days', 1800.00, 'Active', 22, 1, 'Seattle, WA', '47.6062', '-122.3321', 2500.00, TRUE, TRUE, NOW() + INTERVAL '7 days'),
('Vintage Rolex', 'Rolex Submariner from 1980s. Serviced and authenticated. Comes with original box.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '5 days', 5000.00, 'Active', 32, 8, 'New York, NY', '40.7128', '-74.0060', 8000.00, TRUE, TRUE, NOW() + INTERVAL '7 days'),
('First Edition Book', 'First edition Harry Potter and the Philosopher''s Stone. Excellent condition.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '6 days', 2000.00, 'Active', 22, 5, 'London, UK', '51.5074', '-0.1278', NULL, FALSE, FALSE, NULL),
('Signed Baseball', 'Baseball signed by Babe Ruth. Authenticated by PSA. Rare collectible.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '8 days', 3000.00, 'Active', 25, 4, 'Boston, MA', '42.3601', '-71.0589', NULL, FALSE, FALSE, NULL),
('Modern Art Sculpture', 'Contemporary bronze sculpture by emerging artist. Limited edition piece.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '3 days', 1500.00, 'Active', 26, 6, 'San Francisco, CA', '37.7749', '-122.4194', 2800.00, TRUE, FALSE, NULL),
('Vintage Arcade Machine', 'Original Pac-Man arcade machine from 1980. Fully restored and working.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 2500.00, 'Active', 27, 11, 'Las Vegas, NV', '36.1699', '-115.1398', 4000.00, TRUE, FALSE, NULL),
('Designer Wedding Dress', 'Vera Wang wedding dress, size 6. Worn once, professionally cleaned.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 1200.00, 'Active', 28, 2, 'Los Angeles, CA', '34.0522', '-118.2437', 2000.00, TRUE, FALSE, NULL),
('Antique Writing Desk', 'Victorian writing desk from 1890s. Solid mahogany with brass fittings.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '6 days', 900.00, 'Active', 29, 15, 'Charleston, SC', '32.7765', '-79.9311', 1600.00, TRUE, FALSE, NULL),
('Leica Camera M6', 'Classic Leica M6 rangefinder camera. Excellent condition, recently serviced.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 1800.00, 'Active', 33, 13, 'Tokyo, Japan', '35.6762', '139.6503', NULL, FALSE, FALSE, NULL),
('Royal Doulton China Set', 'Complete Royal Doulton fine china set for 12. Mint condition, never used.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 600.00, 'Active', 36, 3, 'Edinburgh, UK', '55.9533', '-3.1883', 1000.00, TRUE, FALSE, NULL),
('Upcoming Art Auction', 'Collection of watercolor paintings by local artists. Auction starts next week.', NOW() + INTERVAL '3 days', NOW() + INTERVAL '10 days', 500.00, 'Active', 26, 6, 'Portland, OR', '45.5152', '-122.6784', NULL, FALSE, FALSE, NULL),
('Future Electronics Sale', 'Brand new iPad Pro with accessories. Auction scheduled for next week.', NOW() + INTERVAL '2 days', NOW() + INTERVAL '9 days', 700.00, 'Active', 7, 1, 'Austin, TX', '30.2672', '-97.7431', 1100.00, TRUE, FALSE, NULL),
('Vintage Comic Books', 'Collection of Marvel comics from 1960s-1970s. Including Amazing Spider-Man issues.', NOW() - INTERVAL '8 days', NOW() + INTERVAL '3 days', 800.00, 'Active', 23, 7, 'Chicago, IL', '41.8781', '-87.6298', NULL, FALSE, FALSE, NULL),
('Antique Grandfather Clock', 'Working grandfather clock from early 1900s. Beautiful chime mechanism.', NOW() - INTERVAL '10 days', NOW() + INTERVAL '4 days', 1500.00, 'Active', 8, 9, 'Baltimore, MD', '39.2904', '-76.6122', NULL, FALSE, FALSE, NULL),
('Rare Vinyl Box Set', 'Limited edition Beatles White Album box set. Numbered edition, pristine condition.', NOW() - INTERVAL '7 days', NOW() + INTERVAL '2 days', 600.00, 'Active', 31, 5, 'Nashville, TN', '36.1627', '-86.7816', NULL, FALSE, FALSE, NULL),
('Vintage Typewriter', 'Royal typewriter from 1950s. Fully functional, perfect for collectors or display.', NOW() - INTERVAL '9 days', NOW() + INTERVAL '3 days', 200.00, 'Active', 29, 7, 'Portland, OR', '45.5152', '-122.6784', NULL, FALSE, FALSE, NULL),
('Old Telescope', 'Vintage brass telescope. Some wear but functional. Great for collectors.', NOW() - INTERVAL '6 days', NOW() + INTERVAL '1 day', 300.00, 'Active', 33, 7, 'San Diego, CA', '32.7157', '-117.1611', NULL, FALSE, FALSE, NULL),
('Board Game Collection', 'Vintage board games from 1970s and 1980s. Some rare editions included.', NOW() - INTERVAL '5 days', NOW() + INTERVAL '1 day', 150.00, 'Active', 18, 11, 'Denver, CO', '39.7392', '-104.9903', NULL, FALSE, FALSE, NULL),
('Gaming Console', 'PlayStation 5 with extra controller. Changed mind about selling.', NOW() - INTERVAL '4 days', NOW() + INTERVAL '3 days', 450.00, 'Active', 27, 1, 'Miami, FL', '25.7617', '-80.1918', 650.00, TRUE, FALSE, NULL),
('Jewelry Box', 'Handcrafted wooden jewelry box. Seller no longer available.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 80.00, 'Active', 34, 3, 'Houston, TX', '29.7604', '-95.3698', NULL, FALSE, FALSE, NULL),
('Professional Drone', '4K drone with gimbal stabilization. Perfect for aerial photography.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '6 days', 800.00, 'Active', 19, 1, 'San Francisco, CA', '37.7749', '-122.4194', 1400.00, TRUE, FALSE, NULL),
('Signed Movie Poster', 'Original Star Wars poster signed by cast. Authenticated with COA.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '5 days', 1000.00, 'Active', 23, 7, 'Los Angeles, CA', '34.0522', '-118.2437', NULL, FALSE, TRUE, NOW() + INTERVAL '7 days'),
('Vintage Motorcycle Helmet', 'Classic motorcycle helmet from 1960s. Original paint, display quality.', NOW() - INTERVAL '3 days', NOW() + INTERVAL '4 days', 250.00, 'Active', 35, 12, 'Sturgis, SD', '44.4097', '-103.5091', 450.00, TRUE, FALSE, NULL),
('Persian Rug', 'Hand-woven Persian rug, 8x10 feet. Excellent condition, vibrant colors.', NOW() - INTERVAL '1 day', NOW() + INTERVAL '7 days', 2000.00, 'Active', 8, 3, 'New York, NY', '40.7128', '-74.0060', 3500.00, TRUE, FALSE, NULL),
('Model Train Set', 'Complete HO scale model train set with tracks and accessories.', NOW() - INTERVAL '2 days', NOW() + INTERVAL '6 days', 400.00, 'Active', 37, 11, 'Chicago, IL', '41.8781', '-87.6298', 750.00, TRUE, FALSE, NULL),
('Smart Home Starter Kit', 'Bundle of smart home devices including smart plugs, bulbs, and voice assistant. Starts next week.', NOW() + INTERVAL '4 days', NOW() + INTERVAL '11 days', 150.00, 'Pending', 6, 1, 'San Jose, CA', '37.3382', '-121.8863', 300.00, TRUE, FALSE, NULL),
('Handmade Jewelry Set', 'Custom handcrafted silver necklace and earrings by local artisan.', NOW() + INTERVAL '2 days', NOW() + INTERVAL '9 days', 120.00, 'Pending', 10, 8, 'Santa Fe, NM', '35.6870', '-105.9378', 250.00, TRUE, FALSE, NULL),
('Limited Edition Sneakers', 'Brand new pair of limited-edition Air Jordan sneakers in original box.', NOW() + INTERVAL '5 days', NOW() + INTERVAL '12 days', 400.00, 'Pending', 12, 2, 'Los Angeles, CA', '34.0522', '-118.2437', 800.00, TRUE, TRUE, NOW() + INTERVAL '7 days'),
('Photography Workshop', 'Weekend photography workshop by professional photographer. Includes guided sessions and materials.', NOW() + INTERVAL '3 days', NOW() + INTERVAL '7 days', 100.00, 'Pending', 15, 13, 'Portland, OR', '45.5152', '-122.6784', NULL, FALSE, FALSE, NULL),
('Classic Vinyl Auction', 'Upcoming sale of rare jazz and blues vinyls from the 1950s. Collectors dream set.', NOW() + INTERVAL '6 days', NOW() + INTERVAL '14 days', 300.00, 'Pending', 19, 5, 'Memphis, TN', '35.1495', '-90.0490', NULL, FALSE, TRUE, NOW() + INTERVAL '7 days');
------------------------------------------------------------
-- BIDS
------------------------------------------------------------
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (880.00, NOW() - INTERVAL '2 days' + INTERVAL '2 hours', 25, 1);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (960.00, NOW() - INTERVAL '1 day' + INTERVAL '5 hours', 7, 1);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1040.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 25, 1);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (275.00, NOW() - INTERVAL '1 day' + INTERVAL '3 hours', 6, 2);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (300.00, NOW() - INTERVAL '20 hours', 12, 2);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (350.00, NOW() - INTERVAL '10 hours', 6, 2);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (440.00, NOW() - INTERVAL '5 days' + INTERVAL '2 hours', 8, 3);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (480.00, NOW() - INTERVAL '4 days' + INTERVAL '5 hours', 11, 3);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (520.00, NOW() - INTERVAL '3 days' + INTERVAL '8 hours', 9, 3);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (580.00, NOW() - INTERVAL '2 days' + INTERVAL '3 hours', 8, 3);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1320.00, NOW() - INTERVAL '2 days' + INTERVAL '3 hours', 15, 6);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1450.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 7, 6);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1600.00, NOW() - INTERVAL '17 hours', 15, 6);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (660.00, NOW() - INTERVAL '6 days' + INTERVAL '4 hours', 16, 7);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (720.00, NOW() - INTERVAL '5 days' + INTERVAL '6 hours', 11, 7);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (800.00, NOW() - INTERVAL '4 days' + INTERVAL '8 hours', 16, 7);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (900.00, NOW() - INTERVAL '3 days' + INTERVAL '5 hours', 17, 7);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (88.00, NOW() - INTERVAL '3 days' + INTERVAL '2 hours', 18, 9);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (100.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 10, 9);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (120.00, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 18, 9);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (165.00, NOW() - INTERVAL '4 days' + INTERVAL '3 hours', 20, 10);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (185.00, NOW() - INTERVAL '3 days' + INTERVAL '6 hours', 12, 10);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (210.00, NOW() - INTERVAL '2 days' + INTERVAL '4 hours', 20, 10);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (550.00, NOW() - INTERVAL '2 days' + INTERVAL '4 hours', 19, 11);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (620.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 12, 11);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (700.00, NOW() - INTERVAL '16 hours', 19, 11);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1100.00, NOW() - INTERVAL '5 days' + INTERVAL '3 hours', 14, 12);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1250.00, NOW() - INTERVAL '4 days' + INTERVAL '6 hours', 20, 12);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1400.00, NOW() - INTERVAL '3 days' + INTERVAL '4 hours', 22, 12);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1600.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 14, 12);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (880.00, NOW() - INTERVAL '3 days' + INTERVAL '5 hours', 16, 13);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (980.00, NOW() - INTERVAL '2 days' + INTERVAL '7 hours', 8, 13);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1100.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 16, 13);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (330.00, NOW() - INTERVAL '6 days' + INTERVAL '2 hours', 24, 14);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (380.00, NOW() - INTERVAL '5 days' + INTERVAL '5 hours', 10, 14);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (450.00, NOW() - INTERVAL '4 days' + INTERVAL '7 hours', 24, 14);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (520.00, NOW() - INTERVAL '3 days' + INTERVAL '4 hours', 20, 14);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1320.00, NOW() - INTERVAL '2 days' + INTERVAL '6 hours', 13, 15);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1480.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 11, 15);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1650.00, NOW() - INTERVAL '14 hours', 13, 15);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (110.00, NOW() - INTERVAL '1 day' + INTERVAL '2 hours', 6, 16);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (125.00, NOW() - INTERVAL '18 hours', 9, 16);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (145.00, NOW() - INTERVAL '10 hours', 6, 16);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (440.00, NOW() - INTERVAL '4 days' + INTERVAL '4 hours', 12, 17);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (500.00, NOW() - INTERVAL '3 days' + INTERVAL '6 hours', 6, 17);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (580.00, NOW() - INTERVAL '2 days' + INTERVAL '8 hours', 12, 17);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (660.00, NOW() - INTERVAL '1 day' + INTERVAL '5 hours', 11, 17);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (220.00, NOW() - INTERVAL '5 days' + INTERVAL '3 hours', 17, 18);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (260.00, NOW() - INTERVAL '4 days' + INTERVAL '5 hours', 8, 18);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (310.00, NOW() - INTERVAL '3 days' + INTERVAL '7 hours', 17, 18);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (370.00, NOW() - INTERVAL '2 days' + INTERVAL '6 hours', 9, 18);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (275.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 7, 19);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (310.00, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 10, 19);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (360.00, NOW() - INTERVAL '16 hours', 7, 19);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (165.00, NOW() - INTERVAL '3 days' + INTERVAL '3 hours', 15, 20);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (190.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 19, 20);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (220.00, NOW() - INTERVAL '1 day' + INTERVAL '4 hours', 15, 20);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1980.00, NOW() - INTERVAL '1 day' + INTERVAL '3 hours', 11, 21);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2180.00, NOW() - INTERVAL '20 hours', 24, 21);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2500.00, NOW() - INTERVAL '15 hours', 11, 21);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (5500.00, NOW() - INTERVAL '3 days' + INTERVAL '2 hours', 28, 22);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (6000.00, NOW() - INTERVAL '2 days' + INTERVAL '6 hours', 6, 22);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (6600.00, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 31, 22);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (7260.00, NOW() - INTERVAL '18 hours', 24, 22);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2200.00, NOW() - INTERVAL '2 days' + INTERVAL '4 hours', 10, 23);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2420.00, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 24, 23);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2662.00, NOW() - INTERVAL '16 hours', 10, 23);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (3300.00, NOW() - INTERVAL '1 day' + INTERVAL '2 hours', 24, 24);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (3630.00, NOW() - INTERVAL '20 hours', 9, 24);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (3993.00, NOW() - INTERVAL '12 hours', 33, 24);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1650.00, NOW() - INTERVAL '4 days' + INTERVAL '3 hours', 6, 25);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1815.00, NOW() - INTERVAL '3 days' + INTERVAL '6 hours', 24, 25);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1996.50, NOW() - INTERVAL '2 days' + INTERVAL '8 hours', 17, 25);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2196.15, NOW() - INTERVAL '1 day' + INTERVAL '5 hours', 8, 25);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2750.00, NOW() - INTERVAL '2 days' + INTERVAL '4 hours', 24, 26);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (3025.00, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 23, 26);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (3327.50, NOW() - INTERVAL '18 hours', 24, 26);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1320.00, NOW() - INTERVAL '3 days' + INTERVAL '3 hours', 12, 27);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1597.20, NOW() - INTERVAL '1 day' + INTERVAL '8 hours', 17, 27);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2200.00, NOW() - INTERVAL '1 day' + INTERVAL '4 hours', 10, 44);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1089.00, NOW() - INTERVAL '20 hours', 36, 28);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1197.90, NOW() - INTERVAL '14 hours', 8, 28);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1980.00, NOW() - INTERVAL '2 days' + INTERVAL '3 hours', 19, 29);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2178.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 8, 29);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2395.80, NOW() - INTERVAL '16 hours', 19, 29);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (660.00, NOW() - INTERVAL '3 days' + INTERVAL '2 hours', 25, 30);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (726.00, NOW() - INTERVAL '2 days' + INTERVAL '5 hours', 35, 30);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (798.60, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 24, 30);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (880.00, NOW() - INTERVAL '8 days' + INTERVAL '3 hours', 33, 33);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (968.00, NOW() - INTERVAL '7 days' + INTERVAL '6 hours', 10, 33);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1064.80, NOW() - INTERVAL '6 days' + INTERVAL '8 hours', 30, 33);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1171.28, NOW() - INTERVAL '5 days' + INTERVAL '4 hours', 27, 33);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1288.41, NOW() - INTERVAL '4 days' + INTERVAL '6 hours', 33, 33);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1650.00, NOW() - INTERVAL '10 days' + INTERVAL '2 hours', 24, 34);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1815.00, NOW() - INTERVAL '9 days' + INTERVAL '5 hours', 10, 34);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1996.50, NOW() - INTERVAL '8 days' + INTERVAL '7 hours', 36, 34);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2196.15, NOW() - INTERVAL '7 days' + INTERVAL '6 hours', 24, 34);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2415.77, NOW() - INTERVAL '6 days' + INTERVAL '4 hours', 11, 34);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2657.34, NOW() - INTERVAL '5 days' + INTERVAL '8 hours', 24, 34);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (660.00, NOW() - INTERVAL '7 days' + INTERVAL '3 hours', 24, 35);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (726.00, NOW() - INTERVAL '6 days' + INTERVAL '5 hours', 18, 35);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (798.60, NOW() - INTERVAL '5 days' + INTERVAL '7 hours', 24, 35);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (878.46, NOW() - INTERVAL '4 days' + INTERVAL '6 hours', 30, 35);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (966.31, NOW() - INTERVAL '3 days' + INTERVAL '4 hours', 24, 35);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (220.00, NOW() - INTERVAL '9 days' + INTERVAL '2 hours', 34, 36);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (242.00, NOW() - INTERVAL '8 days' + INTERVAL '5 hours', 24, 36);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (266.20, NOW() - INTERVAL '7 days' + INTERVAL '7 hours', 37, 36);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (292.82, NOW() - INTERVAL '6 days' + INTERVAL '4 hours', 34, 36);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (322.10, NOW() - INTERVAL '5 days' + INTERVAL '6 hours', 24, 36);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (880.00, NOW() - INTERVAL '1 day' + INTERVAL '3 hours', 33, 41);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (968.00, NOW() - INTERVAL '20 hours', 24, 41);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1064.80, NOW() - INTERVAL '14 hours', 33, 41);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1100.00, NOW() - INTERVAL '2 days' + INTERVAL '2 hours', 24, 42);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1210.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 7, 42);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (1331.00, NOW() - INTERVAL '17 hours', 27, 42);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (275.00, NOW() - INTERVAL '3 days' + INTERVAL '3 hours', 24, 43);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (302.50, NOW() - INTERVAL '2 days' + INTERVAL '6 hours', 36, 43);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (332.75, NOW() - INTERVAL '1 day' + INTERVAL '7 hours', 24, 43);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2420.00, NOW() - INTERVAL '20 hours', 30, 44);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (2662.00, NOW() - INTERVAL '15 hours', 32, 44);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (440.00, NOW() - INTERVAL '2 days' + INTERVAL '3 hours', 24, 45);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (484.00, NOW() - INTERVAL '1 day' + INTERVAL '6 hours', 9, 45);
INSERT INTO bid (amount, date, user_id, auction_id) VALUES (532.40, NOW() - INTERVAL '16 hours', 24, 45);

UPDATE auction a
SET current_price = (
    SELECT MAX(amount)
    FROM bid b
    WHERE b.auction_id = a.id
)
WHERE EXISTS (
    SELECT 1 FROM bid b WHERE b.auction_id = a.id
);

------------------------------------------------------------
-- TRANSACTIONS
------------------------------------------------------------
INSERT INTO transactions (amount, date, status, type, auction_id, buyer_id, seller_id)
VALUES
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
(100.00, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes', 'Completed', 'feature-payment', 5, 30, NULL),
(100.00, NOW() - INTERVAL '1 day' + INTERVAL '30 minutes', 'Completed', 'feature-payment', 8, 8, NULL),
(100.00, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes', 'Completed', 'feature-payment', 17, 17, NULL),
(1500.00, NOW() - INTERVAL '2 hours', 'Pending', 'add-credit', NULL, 19, NULL),
(3000.00, NOW() - INTERVAL '8 days', 'Completed', 'add-credit', NULL, 23, NULL),
(4500.00, NOW() - INTERVAL '7 days', 'Completed', 'add-credit', NULL, 24, NULL),
(2000.00, NOW() - INTERVAL '7 days', 'Completed', 'add-credit', NULL, 25, NULL),
(5000.00, NOW() - INTERVAL '6 days', 'Completed', 'add-credit', NULL, 26, NULL),
(3500.00, NOW() - INTERVAL '6 days', 'Completed', 'add-credit', NULL, 27, NULL),
(2500.00, NOW() - INTERVAL '5 days', 'Completed', 'add-credit', NULL, 28, NULL),
(1500.00, NOW() - INTERVAL '5 days', 'Completed', 'add-credit', NULL, 29, NULL),
(2000.00, NOW() - INTERVAL '4 days', 'Completed', 'add-credit', NULL, 30, NULL),
(4000.00, NOW() - INTERVAL '4 days', 'Completed', 'add-credit', NULL, 31, NULL),
(8000.00, NOW() - INTERVAL '3 days', 'Completed', 'add-credit', NULL, 32, NULL),
(3000.00, NOW() - INTERVAL '3 days', 'Completed', 'add-credit', NULL, 33, NULL),
(1500.00, NOW() - INTERVAL '2 days', 'Completed', 'add-credit', NULL, 34, NULL),
(2000.00, NOW() - INTERVAL '2 days', 'Completed', 'add-credit', NULL, 35, NULL),
(2500.00, NOW() - INTERVAL '1 day', 'Completed', 'add-credit', NULL, 36, NULL),
(1800.00, NOW() - INTERVAL '1 day', 'Completed', 'add-credit', NULL, 37, NULL),
(500.00, NOW() - INTERVAL '3 hours', 'Completed', 'add-credit', NULL, 40, NULL),
(1000.00, NOW() - INTERVAL '2 days', 'Completed', 'credit-withdrawal', NULL, 11, NULL),
(500.00, NOW() - INTERVAL '4 days', 'Completed', 'credit-withdrawal', NULL, 17, NULL),
(1500.00, NOW() - INTERVAL '1 day', 'Pending', 'credit-withdrawal', NULL, 13, NULL);
------------------------------------------------------------
-- REVIEWS
------------------------------------------------------------
INSERT INTO review (description, rating, created_date, user_id, auction_id)
VALUES
('Excellent bike! Exactly as described. Seller was very helpful and shipping was fast. Highly recommend!', 5.00, NOW() - INTERVAL '1 day' + INTERVAL '3 hours', 11, 21);



------------------------------------------------------------
-- REPORTS
------------------------------------------------------------
INSERT INTO report (description, create_date, status, user_id, admin_id, reported_user_id, auction_id)
VALUES
('Item looks fake. I don''t think this is a real Fender Stratocaster.', NOW() - INTERVAL '12 hours', 'Dismissed', 9, 21, NULL, 8),
('This user is bidding on multiple auctions and not following through with payments. Suspicious activity.', NOW() - INTERVAL '2 days', 'InReview', 12, 21, 6, NULL),
('The handbag appears to be counterfeit based on the stitching visible in the photos.', NOW() - INTERVAL '4 days', 'Resolved', 12, 21, NULL, 2),
('The MacBook shown in photos doesn''t match the model description. Possible scam.', NOW() - INTERVAL '1 day', 'Pending', 15, NULL, NULL, 21),
('This Rolex watch looks suspicious. Serial number appears to be fake in the photos.', NOW() - INTERVAL '3 days', 'InReview', 24, 21, NULL, 22),
('Auction ended but seller is not responding to messages about pickup.', NOW() - INTERVAL '5 days', 'Resolved', 8, 21, NULL, 34),
('Item received was damaged and not as described. Seller refusing refund.', NOW() - INTERVAL '6 days', 'Resolved', 20, 21, 14, 14),
('Auction description is misleading. Photos don''t show the actual condition of the item.', NOW() - INTERVAL '8 hours', 'Pending', 11, NULL, NULL, 26),
('User is using multiple accounts to bid on their own auctions.', NOW() - INTERVAL '3 days', 'InReview', 16, 21, 27, NULL),
('Seller sent threatening messages after I won the auction.', NOW() - INTERVAL '4 days', 'Resolved', 14, 21, 18, NULL),
('This user has won multiple auctions but never completed payment.', NOW() - INTERVAL '2 days', 'InReview', 7, 21, 25, NULL),
('Inappropriate language in user profile description.', NOW() - INTERVAL '1 day', 'Dismissed', 19, 21, 35, NULL),
('User is posting fake reviews to boost their rating.', NOW() - INTERVAL '5 days', 'Resolved', 22, 21, 12, NULL),
('Auction listing contains spam links in description.', NOW() - INTERVAL '6 hours', 'Pending', 28, NULL, NULL, 41),
('User sent unsolicited promotional messages.', NOW() - INTERVAL '10 hours', 'Pending', 30, NULL, 34, NULL);

------------------------------------------------------------
-- USER FOLLOWS
------------------------------------------------------------
INSERT INTO user_follows (follower_id, followed_auction)
VALUES
(2,2),
(2,6),
(9,4),
(13,5),
(19,11),
(20,17),
(16,13),
(11,6),
(6, 22),
(6, 25),
(7, 1),
(7, 19),
(7, 42),
(8, 28),
(8, 44),
(10, 23),
(10, 24),
(11, 21),
(12, 2),
(12, 27),
(13, 22),
(13, 43),
(14, 29),
(15, 20),
(15, 41),
(17, 25),
(17, 42),
(18, 30),
(19, 29),
(19, 41),
(22, 23),
(23, 33),
(23, 42),
(24, 21),
(25, 24),
(26, 25),
(27, 26),
(27, 33),
(28, 27),
(29, 28),
(29, 36),
(30, 30),
(30, 44),
(31, 35),
(32, 22),
(32, 44),
(33, 29),
(35, 43),
(36, 28),
(36, 30),
(37, 45);

------------------------------------------------------------
-- FEATURE PAYMENT
------------------------------------------------------------
INSERT INTO feature_payment (auction_id, user_id, paid_date)
VALUES
(5, 30, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes'),
(8, 8, NOW() - INTERVAL '1 day' + INTERVAL '30 minutes'),
(17, 17, NOW() - INTERVAL '4 days' + INTERVAL '30 minutes'),
(21, 22, NOW() - INTERVAL '1 day' + INTERVAL '30 minutes'),
(22, 32, NOW() - INTERVAL '3 days' + INTERVAL '30 minutes'),
(42, 23, NOW() - INTERVAL '2 days' + INTERVAL '30 minutes');

------------------------------------------------------------
-- AUCTION IMAGES (5)
------------------------------------------------------------

INSERT INTO auction_images (auction_id, path) VALUES 
(5, 'vintagewatch1.png'),
(5, 'vintagewatch2.png');

INSERT INTO auction_images (auction_id, path) VALUES 
(8, 'eletricguitar1.png'),
(8, 'eletricguitar2.png');

INSERT INTO auction_images (auction_id, path) VALUES 
(17, 'localartist.jpg');

INSERT INTO auction_images (auction_id, path) VALUES 
(22, 'vintagerolex1.png'),
(22, 'vintagerolex2.png');

INSERT INTO auction_images (auction_id, path) VALUES 
(42, 'movieposter1.png'),
(42, 'movieposter2.png');