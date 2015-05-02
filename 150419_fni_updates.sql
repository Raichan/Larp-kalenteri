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






