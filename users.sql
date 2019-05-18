CREATE TABLE public.users
(
  id integer NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  username character varying(200),
  password character varying(200),
  name character varying(200),
  created timestamp without time zone,
  modified timestamp without time zone,
  CONSTRAINT users_pkey PRIMARY KEY (id)
)