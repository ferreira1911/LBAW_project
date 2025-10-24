DROP SCHEMA IF EXISTS lbaw25172 CASCADE;
CREATE SCHEMA lbaw25172;
SET search_path TO lbaw25172;

------------------------------------------------------------
-- ENUMERATED TYPES
------------------------------------------------------------
CREATE TYPE auction_status AS ENUM ('Pending', 'Active', 'Ended', 'Cancelled');
CREATE TYPE report_status AS ENUM ('Pending', 'InReview', 'Resolved', 'Dismissed');
CREATE TYPE transaction_status AS ENUM ('Pending', 'Completed', 'Cancelled');
CREATE TYPE transaction_type AS ENUM ('auction-buy', 'add-credit', 'feature-payment', 'credit-withdrawal');

CREATE TYPE notification_type AS ENUM (
    'new-bid',
    'ending',
    'ended',
    'winner',
    'cancel',
    'review'
);

------------------------------------------------------------
-- USER AND ADMIN
------------------------------------------------------------
CREATE TABLE users (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    description TEXT,
    credit NUMERIC(12,2) DEFAULT 0 CHECK (credit >= 0),
    held_credit NUMERIC(12,2) DEFAULT 0 CHECK (held_credit >= 0),
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    is_admin BOOLEAN DEFAULT FALSE,
    password TEXT NOT NULL,
    url TEXT
);

------------------------------------------------------------
-- CATEGORY
------------------------------------------------------------
CREATE TABLE category (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name TEXT UNIQUE NOT NULL
);

------------------------------------------------------------
-- AUCTION
------------------------------------------------------------
CREATE TABLE auction (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT,
    start_date TIMESTAMP NOT NULL,
    end_date TIMESTAMP NOT NULL CHECK (end_date > start_date),
    starting_price NUMERIC(12,2) NOT NULL CHECK (starting_price > 0),
    current_price NUMERIC(12,2) NOT NULL CHECK (current_price >= starting_price),
    status auction_status DEFAULT 'Pending',
    owner_id INTEGER NOT NULL REFERENCES users(id),
    category_id INTEGER REFERENCES category(id),
    is_featured BOOLEAN DEFAULT FALSE,
    featured_until TIMESTAMP,
    buy_now_price NUMERIC(12,2) CHECK (buy_now_price > 0),
    address TEXT,
    latitude TEXT,
    longitude TEXT,
    is_buy_now_active BOOLEAN DEFAULT FALSE
);

------------------------------------------------------------
-- BID
------------------------------------------------------------
CREATE TABLE bid (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    amount NUMERIC(12,2) NOT NULL CHECK (amount > 0),
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INTEGER NOT NULL REFERENCES users(id),
    auction_id INTEGER NOT NULL REFERENCES auction(id)
);

------------------------------------------------------------
-- TRANSACTION
------------------------------------------------------------
CREATE TABLE transactions (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    amount NUMERIC(12,2) NOT NULL CHECK (amount > 0),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status transaction_status DEFAULT 'Pending',
    type transaction_type NOT NULL,
    auction_id INTEGER REFERENCES auction(id) ,
    buyer_id INTEGER REFERENCES users(id),
    seller_id INTEGER REFERENCES users(id)
);


------------------------------------------------------------
-- NOTIFICATION
------------------------------------------------------------
CREATE TABLE notifications (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    type notification_type NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INTEGER NOT NULL REFERENCES users(id),
    auction_id INTEGER REFERENCES auction(id),
    bid_id INTEGER REFERENCES bid(id)
);

------------------------------------------------------------
-- REVIEW
------------------------------------------------------------
CREATE TABLE review (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    description TEXT NOT NULL,
    rating NUMERIC(3,2) NOT NULL CHECK (rating BETWEEN 0 AND 5),
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INTEGER REFERENCES users(id),
    auction_id INTEGER REFERENCES auction(id)
);

------------------------------------------------------------
-- REPORT 
------------------------------------------------------------
CREATE TABLE report (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    description TEXT NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status report_status DEFAULT 'Pending',
    user_id INTEGER REFERENCES users(id),
    admin_id INTEGER REFERENCES users(id),
    reported_user_id INTEGER REFERENCES users(id),
    auction_id INTEGER REFERENCES auction(id)
);

CREATE TABLE user_follows (
    follower_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    followed_auction INTEGER REFERENCES auction(id) ON DELETE CASCADE,
    PRIMARY KEY (follower_id, followed_auction)
);

------------------------------------------------------------
-- FEATURE 
------------------------------------------------------------

CREATE TABLE feature_payment (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON DELETE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    paid_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- * ====================================================
-- * Index Creation
-- * ====================================================

CREATE INDEX idx_bid_auction_id ON bid (auction_id);

CREATE INDEX idx_auction_enddate ON auction (end_date);

CREATE INDEX idx_user_notifications on notifications (user_id);


-- * ====================================================
-- * Full Text Search Index Creation
-- * ====================================================


ALTER TABLE auction
ADD COLUMN tsvectors TSVECTOR;


CREATE FUNCTION auction_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER auction_search_update
BEFORE INSERT OR UPDATE ON auction
FOR EACH ROW
EXECUTE PROCEDURE auction_search_update();


CREATE INDEX auction_search_idx ON auction USING GIN (tsvectors);




ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;


CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE PROCEDURE user_search_update();


CREATE INDEX user_search_idx ON users USING GIN (tsvectors);


-----------------------------------------------------------------------------
--TRIGERS
-----------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION notify_on_new_bid() 
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notifications (user_id, type, auction_id, bid_id)
    SELECT
        id_to_notify,
        'new-bid' AS type,
        NEW.auction_id,
        NEW.id
    FROM (
        -- Select the auction owner
        SELECT owner_id AS id_to_notify FROM auction WHERE id = NEW.auction_id
        UNION
        -- Select all users who have ever bid on this auction
        SELECT user_id AS id_to_notify FROM bid WHERE auction_id = NEW.auction_id
    ) AS recipients

    WHERE id_to_notify <> NEW.user_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER on_new_bid_notification
AFTER INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION notify_on_new_bid();

------------------------------------------------------------------------


CREATE OR REPLACE FUNCTION handle_auction_end()
RETURNS TRIGGER AS $$
DECLARE
    winner_id INT;
BEGIN
    INSERT INTO notifications (user_id, type, auction_id)
    SELECT
        id_to_notify,
        'ended' AS type,
        NEW.id 
    FROM (
        SELECT NEW.owner_id AS id_to_notify
        UNION
        SELECT DISTINCT user_id FROM bid WHERE auction_id = NEW.id
    ) AS recipients;

    -- get the winning bid
    SELECT 
        b.user_id INTO winner_id
    FROM bid b
    WHERE b.auction_id = NEW.id
    ORDER BY b.amount DESC, b.date ASC 
    LIMIT 1;

    IF winner_id IS NOT NULL THEN
        INSERT INTO notifications (user_id, type, auction_id)
        VALUES (winner_id, 'winner', NEW.id);

        UPDATE users 
        SET credit = credit + NEW.current_price
        WHERE id = NEW.owner_id;

        UPDATE users 
        SET held_credit = held_credit - NEW.current_price
        WHERE id = winner_id;

        INSERT INTO transactions (amount, auction_id, buyer_id, seller_id, status,type)
        VALUES (NEW.current_price, NEW.id, winner_id, NEW.owner_id, 'Completed','auction-buy');

    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_auction_ended
AFTER UPDATE ON auction
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status AND NEW.status = 'Ended')
EXECUTE FUNCTION handle_auction_end();

--------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION send_notifications_on_auction_cancel()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notifications (user_id, type, auction_id)
    SELECT
        id_to_notify,
        'cancel' AS type,
        NEW.id 
    FROM (
        SELECT DISTINCT user_id AS id_to_notify FROM bid WHERE auction_id = NEW.id
        UNION
        SELECT NEW.owner_id AS id_to_notify
    ) AS recipients;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_auction_cancelled
AFTER UPDATE ON auction
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status AND NEW.status = 'Cancelled')
EXECUTE FUNCTION send_notifications_on_auction_cancel();

-----------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION review_send_notification()
RETURNS TRIGGER AS $$
DECLARE
    
BEGIN
    INSERT INTO notifications (user_id, type, auction_id)
    SELECT
        id_to_notify,
        'review' AS type,
        NEW.id 
    FROM (
        SELECT owner_id AS id_to_notify FROM auction WHERE id = NEW.auction_id
        UNION
        SELECT id FROM users WHERE id = NEW.user_id
    ) AS recipients;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER send_review_notifications
AFTER INSERT ON review
FOR EACH ROW
EXECUTE FUNCTION review_send_notification();


-------------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION set_initial_current_price()
RETURNS TRIGGER AS $$
BEGIN
    NEW.current_price = NEW.starting_price;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_set_initial_price
BEFORE INSERT ON auction
FOR EACH ROW
EXECUTE FUNCTION set_initial_current_price();

------------------------------------------------------------

CREATE OR REPLACE FUNCTION validate_bid_rules()
RETURNS TRIGGER AS $$
DECLARE
    auction_status_val auction_status;
    auction_owner_id INT;
    current_bid_price NUMERIC(12,2);
    starting_bid_price NUMERIC(12,2);
    user_credit_val NUMERIC(12,2);
    min_increment NUMERIC(12,2);
    current_high_bidder_id INT;
BEGIN
    
    SELECT 
        a.status, a.owner_id, a.current_price, a.starting_price, u.credit
    INTO 
        auction_status_val, auction_owner_id, current_bid_price, starting_bid_price, user_credit_val
    FROM auction a
    JOIN users u ON u.id = NEW.user_id
    WHERE a.id = NEW.auction_id;

    -- Get the current highest bidder (if one exists)
    SELECT user_id 
    INTO current_high_bidder_id
    FROM bid
    WHERE auction_id = NEW.auction_id
    ORDER BY amount DESC, date ASC
    LIMIT 1;

    -- Rule: Check if auction is active 
    IF auction_status_val <> 'Active' THEN
        RAISE EXCEPTION 'Bidding is not allowed on auctions that are not active.';
    END IF;

    -- Rule: Check if bidder is the owner 
    IF auction_owner_id = NEW.user_id THEN
        RAISE EXCEPTION 'You cannot bid on your own auction.';
    END IF;

    -- BR06: Credit Requirement
    IF user_credit_val < NEW.amount THEN
        RAISE EXCEPTION 'Insufficient credit. You have %, but the bid is %.', user_credit_val, NEW.amount;
    END IF;
    
    -- BR03: No Self-Overbidding
    IF NEW.user_id = current_high_bidder_id THEN
        RAISE EXCEPTION 'You are already the highest bidder.';
    END IF;

    min_increment := starting_bid_price * 0.10;
    
    IF NEW.amount < (current_bid_price + min_increment) THEN
        RAISE EXCEPTION 'Your bid must be at least % higher than the current price (%).', min_increment, current_bid_price;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_validate_bid
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION validate_bid_rules();

----------------------------------------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION update_auction_on_bid()
RETURNS TRIGGER AS $$
DECLARE
    previous_high_bidder_id INT;
    previous_high_bid_amount NUMERIC(12,2);
    auction_end_time TIMESTAMP;
    buy_now_val NUMERIC(12,2);
    is_buy_now_on BOOLEAN;
BEGIN
    -- BR08: Refund the *previous* high bidder (if they exist and are not the new bidder)
    SELECT user_id, amount
    INTO previous_high_bidder_id, previous_high_bid_amount
    FROM bid
    WHERE auction_id = NEW.auction_id AND id != NEW.id
    ORDER BY amount DESC, date ASC
    LIMIT 1;

    IF previous_high_bidder_id IS NOT NULL AND previous_high_bidder_id <> NEW.user_id THEN
        UPDATE users
        SET credit = credit + previous_high_bid_amount, held_credit = held_credit -previous_high_bid_amount
        WHERE id = previous_high_bidder_id;
    END IF;

    -- BR08: Hold credit for the *new* high bidder
    UPDATE users
    SET credit = credit - NEW.amount, held_credit = held_credit + NEW.amount
    WHERE id = NEW.user_id;
    
    -- Update the auction's current price
    UPDATE auction
    SET current_price = NEW.amount
    WHERE id = NEW.auction_id;

    -- Handle "Buy Now"
    SELECT buy_now_price, is_buy_now_active
    INTO buy_now_val, is_buy_now_on
    FROM auction
    WHERE id = NEW.auction_id;

    IF is_buy_now_on = TRUE AND NEW.amount >= buy_now_val THEN
        UPDATE auction
        SET status = 'Ended'
        WHERE id = NEW.auction_id;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_update_auction_on_bid
AFTER INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION update_auction_on_bid();

---------------------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION prevent_auction_cancellation()
RETURNS TRIGGER AS $$
DECLARE
    bid_count INT;
BEGIN
    SELECT count(*)
    INTO bid_count
    FROM bid
    WHERE auction_id = NEW.id;

    IF bid_count > 0 THEN
        RAISE EXCEPTION 'Cannot cancel an auction that already has bids.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_prevent_cancellation
BEFORE UPDATE ON auction
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status AND NEW.status = 'Cancelled')
EXECUTE FUNCTION prevent_auction_cancellation();

------------------------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION validate_review_permissions()
RETURNS TRIGGER AS $$
DECLARE
    v_winner_id INT;
    v_owner_id INT;
BEGIN
    SELECT owner_id INTO v_owner_id
    FROM auction
    WHERE id = NEW.auction_id;

    -- Rule 1: Prevent owner from reviewing
    IF NEW.user_id = v_owner_id THEN
        RAISE EXCEPTION 'You cannot review your own auction.';
    END IF;

    -- Get auction winner
    SELECT user_id INTO v_winner_id
    FROM bid
    WHERE auction_id = NEW.auction_id
    ORDER BY amount DESC, date ASC
    LIMIT 1;

    -- Rule 2: Only the winner can review
    IF v_winner_id IS NULL OR NEW.user_id <> v_winner_id THEN
        RAISE EXCEPTION 'Only the auction winner can leave a review.';
    END IF;

    IF EXISTS (SELECT 1 FROM review WHERE user_id = NEW.user_id AND auction_id = NEW.auction_id) THEN
        RAISE EXCEPTION 'You have already reviewed this auction.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_validate_review
BEFORE INSERT ON review
FOR EACH ROW
EXECUTE FUNCTION validate_review_permissions();