DROP SCHEMA IF EXISTS lbaw25172 CASCADE;
CREATE SCHEMA lbaw25172;
SET search_path TO lbaw25172;

------------------------------------------------------------
-- ENUMERATED TYPES
------------------------------------------------------------
CREATE TYPE auction_status AS ENUM ('Pending', 'Active', 'Ended', 'Cancelled');
CREATE TYPE report_status AS ENUM ('Pending', 'InReview', 'Resolved', 'Dismissed');
CREATE TYPE transaction_status AS ENUM ('Pending', 'Completed', 'Cancelled');

CREATE TYPE notification_type AS ENUM (
    'new-bid',
    'ending',
    'ended',
    'winner',
    'cancel'
);

------------------------------------------------------------
-- USER AND ADMIN
------------------------------------------------------------
CREATE TABLE users (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    obs TEXT,
    credit NUMERIC(12,2) DEFAULT 0 CHECK (credit >= 0),
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    password TEXT NOT NULL,
    url TEXT
);

CREATE TABLE admin (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    password TEXT NOT NULL
);

------------------------------------------------------------
-- CATEGORY AND LOCATION
------------------------------------------------------------
CREATE TABLE category (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name TEXT UNIQUE NOT NULL
);

CREATE TABLE location (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    latitude TEXT NOT NULL,
    longitude TEXT NOT NULL
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
    location_id INTEGER REFERENCES location(id),
    is_featured BOOLEAN DEFAULT FALSE,
    featured_until TIMESTAMP,
    buy_now_price NUMERIC(12,2) CHECK (buy_now_price > 0),
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
    create_ddate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status report_status DEFAULT 'Pending',
    user_id INTEGER REFERENCES users(id),
    admin_id INTEGER REFERENCES admin(id),
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
         setweight(to_tsvector('english', NEW.obs), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.obs <> OLD.obs) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.obs), 'B')
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




CREATE OR REPLACE FUNCTION send_notifications_on_auction_end()
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
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_auction_ended
AFTER UPDATE ON auction
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status AND NEW.status = 'Ended')
EXECUTE FUNCTION send_notifications_on_auction_end();



CREATE OR REPLACE FUNCTION send_notifications_on_auction_cancel()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notifications (user_id, type, auction_id)
    SELECT
        id_to_notify,
        'cancel' AS type,
        NEW.id 
    FROM (
        SELECT NEW.owner_id AS id_to_notify
        UNION
        SELECT DISTINCT user_id FROM bid WHERE auction_id = NEW.id
    ) AS recipients;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_auction_cancelled
AFTER UPDATE ON auction
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status AND NEW.status = 'Cancelled')
EXECUTE FUNCTION send_notifications_on_auction_cancel();


CREATE OR REPLACE FUNCTION validate_bid()
RETURNS TRIGGER AS $$
DECLARE
    auctionStatus auction_status;
    auction_owner_id INT;
    current_bid_price NUMERIC(12,2);
BEGIN
    SELECT status, owner_id, current_price
    INTO auctionStatus, auction_owner_id, current_bid_price
    FROM auction WHERE id = NEW.auction_id

   IF auction_status <> 'Active' THEN
        RAISE EXCEPTION 'Bidding is not allowed on auctions that are not active.';
    END IF;

    IF auction_owner_id = NEW.user_id  THEN
        RAISE EXCEPTION 'Bidding is not allowed on auctions that you own.';
    END IF;

    IF current_bid_price <= NEW.amount THEN
        RAISE EXCEPTION 'Your bid must be higher than the current price of %. a', current_bid_price;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_validate_bid
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION validate_bid();