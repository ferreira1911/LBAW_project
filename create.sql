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
    name TEXT PRIMARY KEY
);

CREATE TABLE location (
    INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    gps TEXT UNIQUE NOT NULL,
    address TEXT NOT NULL,
    url TEXT
);

------------------------------------------------------------
-- AUCTION
------------------------------------------------------------
CREATE TABLE auction (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    title TEXT NOT NULL,
    reference INTEGER UNIQUE,
    description TEXT,
    startdate TIMESTAMP NOT NULL,
    enddate TIMESTAMP NOT NULL CHECK (enddate > startdate),
    startingprice NUMERIC(12,2) NOT NULL CHECK (startingprice > 0),
    currentprice NUMERIC(12,2) NOT NULL CHECK (currentprice >= startingprice),
    status auction_status DEFAULT 'Pending',
    owner_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id INTEGER REFERENCES category(name) ON DELETE SET NULL,
    location_id INTEGER REFERENCES location(id) ON DELETE SET NULL
);

------------------------------------------------------------
-- BID
------------------------------------------------------------
CREATE TABLE bid (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    amount NUMERIC(12,2) NOT NULL CHECK (amount > 0),
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON DELETE CASCADE
);

------------------------------------------------------------
-- TRANSACTION
------------------------------------------------------------
CREATE TABLE transactions (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    amount NUMERIC(12,2) NOT NULL CHECK (amount > 0),
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status transaction_status DEFAULT 'Pending',
    auction_id INTEGER REFERENCES auction(id) ON DELETE CASCADE,
    CHECK (date > CURRENT_TIMESTAMP)
);

------------------------------------------------------------
-- NOTIFICATION
------------------------------------------------------------
CREATE TABLE notifications (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    message TEXT NOT NULL,
    type notification_type NOT NULL,
    read BOOLEAN NOT NULL DEFAULT FALSE,
    createddate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON DELETE CASCADE,
    CHECK (
            (
            type IN ('new-bid', 'ending', 'ended', 'winner', 'cancel')
            AND auction_id IS NOT NULL
        )
    )
);

------------------------------------------------------------
-- REVIEW
------------------------------------------------------------
CREATE TABLE review (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    description TEXT NOT NULL,
    rating NUMERIC(3,2) NOT NULL CHECK (rating BETWEEN 0 AND 5),
    createddate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INTEGER REFERENCES users(id) ON DELETE SET NULL
);

------------------------------------------------------------
-- REPORT 
------------------------------------------------------------
CREATE TABLE report (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    description TEXT NOT NULL,
    createddate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status report_status DEFAULT 'Pending',
    user_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
    admin_id INTEGER REFERENCES admin(id) ON DELETE SET NULL,
    reported_user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    auction_id INTEGER REFERENCES auction(id) ON DELETE CASCADE
);

------------------------------------------------------------
-- USER FOLLOWS (many-to-many)
------------------------------------------------------------
CREATE TABLE user_follows (
    follower_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    followed_auction INTEGER REFERENCES auction(id) ON DELETE CASCADE,
    PRIMARY KEY (follower_id, followed_auction)
);
