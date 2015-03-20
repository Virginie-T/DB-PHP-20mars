--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: clients; Type: TABLE; Schema: public; Owner: VirginieT; Tablespace: 
--

CREATE TABLE clients (
    id integer NOT NULL,
    name character varying,
    stylist_id integer
);


ALTER TABLE clients OWNER TO "VirginieT";

--
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: VirginieT
--

CREATE SEQUENCE clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE clients_id_seq OWNER TO "VirginieT";

--
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: VirginieT
--

ALTER SEQUENCE clients_id_seq OWNED BY clients.id;


--
-- Name: stylist; Type: TABLE; Schema: public; Owner: VirginieT; Tablespace: 
--

CREATE TABLE stylist (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE stylist OWNER TO "VirginieT";

--
-- Name: stylist_id_seq; Type: SEQUENCE; Schema: public; Owner: VirginieT
--

CREATE SEQUENCE stylist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE stylist_id_seq OWNER TO "VirginieT";

--
-- Name: stylist_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: VirginieT
--

ALTER SEQUENCE stylist_id_seq OWNED BY stylist.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: VirginieT
--

ALTER TABLE ONLY clients ALTER COLUMN id SET DEFAULT nextval('clients_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: VirginieT
--

ALTER TABLE ONLY stylist ALTER COLUMN id SET DEFAULT nextval('stylist_id_seq'::regclass);


--
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: VirginieT
--

COPY clients (id, name, stylist_id) FROM stdin;
16	yop	8
17	Vanessa Trubiano	9
18	Gregoire Dumais	7
28	yop	14
29	kkk	14
31	yop	15
34	llll	15
30	doigts croisés	15
\.


--
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: VirginieT
--

SELECT pg_catalog.setval('clients_id_seq', 35, true);


--
-- Data for Name: stylist; Type: TABLE DATA; Schema: public; Owner: VirginieT
--

COPY stylist (id, name) FROM stdin;
15	Majda damour
14	victory
\.


--
-- Name: stylist_id_seq; Type: SEQUENCE SET; Schema: public; Owner: VirginieT
--

SELECT pg_catalog.setval('stylist_id_seq', 15, true);


--
-- Name: clients_pkey; Type: CONSTRAINT; Schema: public; Owner: VirginieT; Tablespace: 
--

ALTER TABLE ONLY clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- Name: stylist_pkey; Type: CONSTRAINT; Schema: public; Owner: VirginieT; Tablespace: 
--

ALTER TABLE ONLY stylist
    ADD CONSTRAINT stylist_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: VirginieT
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM "VirginieT";
GRANT ALL ON SCHEMA public TO "VirginieT";
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

