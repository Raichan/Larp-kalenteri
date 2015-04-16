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