CREATE SEQUENCE unique_id_admins;

CREATE TABLE admins (
  id integer NOT NULL DEFAULT nextval('unique_id_admins'),
  username character varying(50) NOT NULL,
  password character varying(50) NOT NULL,
  name character varying(50),
  surname character varying(50),
  email character varying(50)
);

ALTER SEQUENCE unique_id_admins owned by admins.id;

CREATE SEQUENCE unique_id_events;

CREATE TABLE events (
  id integer NOT NULL DEFAULT nextval('unique_id_events'),
  eventName character varying(100),
  eventType character varying(100),
  startDate character varying(50),
  endDate character varying(50),
  dateTextField character varying(100),
  startSignupTime character varying(50),
  endSignupTime character varying(50),
  locationDropDown character varying(100),
  locationTextField character varying(100),
  iconUrl character varying(500),
  genre character varying(500),
  cost character varying(100),
  ageLimit character varying(100),
  beginnerFriendly boolean,
  eventFull boolean,
  invitationOnly boolean,
  languageFree boolean,
  storyDescription character varying(3000),
  infoDescription character varying(5000),
  organizerName character varying(100),
  organizerEmail character varying(100),
  link1 character varying(500),
  link2 character varying(500),
  status character varying(100),
  password character varying(100),
  illusionId bigint default null,
  fniUserCreated boolean default false
);

ALTER SEQUENCE unique_id_events owned by events.id;

/* oauth_clients */
CREATE SEQUENCE unique_id_oauth_clients;
CREATE TABLE oauth_clients (
  id integer unique NOT NULL DEFAULT nextval('unique_id_oauth_clients'),
  name character varying(50) UNIQUE NOT NULL,
  client_id character varying(50) UNIQUE NOT NULL,
  client_secret character varying(50) NOT NULL
);
ALTER SEQUENCE unique_id_oauth_clients owned by oauth_clients.id;

/* oauth_sessions */

CREATE SEQUENCE unique_id_oauth_sessions;
CREATE TABLE oauth_sessions (
  id integer unique NOT NULL DEFAULT nextval('unique_id_oauth_sessions'),
  client_id integer references oauth_clients (id),
  session_id character varying(50) unique NOT NULL,
  owner_id character varying(50) NOT NULL,
  owner_type character varying(50) NOT NULL,
  client_redirect_uri character varying(255)
);
ALTER SEQUENCE unique_id_oauth_sessions owned by oauth_sessions.id;

/* oauth_access_tokens */

CREATE SEQUENCE unique_id_oauth_access_tokens;
CREATE TABLE oauth_access_tokens (
  id integer UNIQUE NOT NULL DEFAULT nextval('unique_id_oauth_access_tokens'),
  access_token character varying(255) UNIQUE NOT NULL,
  session_id integer references oauth_sessions (id),
  expire_time integer NOT NULL
);
ALTER SEQUENCE unique_id_oauth_access_tokens owned by oauth_access_tokens.id;

/* oauth_auth_codes */

CREATE SEQUENCE unique_id_oauth_auth_codes;
CREATE TABLE oauth_auth_codes (
  id integer NOT NULL DEFAULT nextval('unique_id_oauth_auth_codes'),
  auth_code character varying(50) unique NOT NULL,
  session_id integer references oauth_sessions (id)
);
ALTER SEQUENCE unique_id_oauth_auth_codes owned by oauth_auth_codes.id;